<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\AttendanceSheet;
use App\Models\ehr\EmailTemplate;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Mail;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AttendanceController extends Controller
{
    public function attendanceAdminList(Request $request)
    {
        if ($request->isMethod('post')) {
//            dd($request->all());
            $params = [];

            if (!empty($request->input('search'))) {
                $params['search'] = base64_encode($request->input('search'));
            }
            if (!empty($request->input('page_no'))) {
                $params['page_no'] = base64_encode($request->input('page_no'));
            }
            if (!empty($request->input('added_by'))) {
                $params['added_by'] = base64_encode($request->input('added_by'));
            }
            if (!empty($request->input('created_at'))) {
                $params['created_at'] = base64_encode($request->input('created_at'));
            }

            return redirect()->route('admin.attendanceAdminList', $params)->withInput();
        } else {
            $attendances = AttendanceSheet::with(['admin'])->orderByDesc('created_at');

            $perPage = 10;
            if (!empty($request->input('page_no'))) {
                $perPage = base64_decode($request->input('page_no'));
            }


            if ($request->filled('search')) {
                $searchTerm = base64_decode($request->input('search'));
                $attendances->whereHas('admin', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', "%$searchTerm%");
                });
            }
            if($request->input('added_by')  != '') {
                $added_by = base64_decode($request->input('added_by'));
                $attendances->where('added_by',$added_by);
            }
            if ($request->filled('created_at')) {
                $date = base64_decode($request->input('created_at'));
                $attendances->whereDate('created_at', $date);
            }
            $attendances = $attendances->paginate($perPage);
            return view('admin.attendance.attendance-list', compact('attendances'));
        }


    }

    public function attendanceList(Request $request)
    {
        $auth = \Session::get('userdata');
        $shiftTime = Admin::where('id', $auth->id)->first();
        if(!empty($shiftTime)) {
            $shiftStartTime = $shiftTime->shift_t_strt; // Start time
            $shiftEndTime = $shiftTime->shift_t_end; // End time

            $formattedShiftStartTime = $this->formatTimeToAMPM($shiftStartTime);
            $formattedShiftEndTime = $this->formatTimeToAMPM($shiftEndTime);
        }

            $user = $formattedShiftStartTime . ' - ' . $formattedShiftEndTime;
            $attendances = AttendanceSheet::with(['admin'])->where('added_by', $auth->id)->orderByDesc('created_at')->paginate(10);
            return view('admin.attendance.user-attendance-list', compact('attendances', 'user'));


    }

    public function storeAttendance(Request $request)
    {
        $auth = \Session::get('userdata');
        $customMessages = [
//            'start_time.required' => 'Please provide a start time.',
            'live_location.required' => 'Please enable your location.',
        ];
        $rules = [
//            'start_time' => 'required',
            'live_location' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()->all()
            ], 400);
        }
        $shiftTime = Admin::where('id', $auth->id)->first();

//        dd(456);
        $shiftTimeString = $shiftTime->shift_t_strt . '-' . $shiftTime->shift_t_end;

        $attendance = AttendanceSheet::create([
            "lat" => $request->input('lat'),
            "lng" => $request->input('lng'),
            "live_location" => $request->input('live_location'),
            "location" => $request->input('location'),
            "added_by" => $shiftTime->id,
            "shift_time" => $shiftTimeString

        ]);
        if ($request->has('start_time') && !is_null($request->input('start_time'))) {
            $start_time = $request->input('start_time');
            $datetime = date('Y-m-d') . ' ' . $start_time;
            $attendance->start_time = $datetime;
        }

        if ($request->has('weak_off')) {
            $weakOffValue = $request->input('weak_off');
            $attendance->weak_off = $weakOffValue;

        }
//        $file = $request->file('start_pic');
        $file = $request->file('start_pic');
//        dd($file);
        if ($request->input('location') !== "0") {
            if ($request->hasFile('start_pic')) {
                $file = $request->file('start_pic');
                $filename = time() . '_' . $file->getClientOriginalName();
//                dd($filename);
                $attendance->start_pic = $filename;
                $file->move(public_path('attendanceUserImage'), $filename);
            } else {
                return response()->json(['errors' => ['Please Upload Image']], 400);

            }
        }

        $attendance->save();

        \Session::flash('message', "Attendance Added Successfully");
        return 1;

    }
    function formatTimeToAMPM($timeString) {
        $timeArray = explode(':', $timeString);

        // Check if the array has at least two elements
        if (count($timeArray) >= 2) {
            $hours = intval($timeArray[0]);
            $minutes = intval($timeArray[1]);

            $ampm = $hours >= 12 ? 'PM' : 'AM';
            $hours = $hours % 12;
            $hours = $hours ? $hours : 12; // Handle midnight (0:00) as 12 AM
            $formattedTime = sprintf("%02d:%02d %s", $hours, $minutes, $ampm);

            return $formattedTime;
        } else {
            // Handle the case where $timeString doesn't contain a colon
            return "Invalid time format";
        }
    }

    public function editAttendance(Request $request)
    {

        try {


            $id = $request->id;
            $attendance = AttendanceSheet::findOrFail($id);
            $end_time = $request->input('end_time');
            $datetime = date('Y-m-d') . ' ' . $end_time;

            if ($request->isMethod('post')) {
                DB::beginTransaction();
                try {
                    $attendance->end_time = $datetime;

                    // Handle file upload
                    if ($request->hasFile('end_pic')) {
                        $file = $request->file('end_pic');
//                        $filename = $file->getClientOriginalName();
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('attendanceUserImage'), $filename);
                        $attendance->end_pic = $filename;
                    }

                    // Save the updated attendance
                    $attendance->save();

                    DB::commit();

                    \Session::flash('message', "Attendance Updated Successfully");
                } catch (\Exception $e) {
                    DB::rollback();
                    \Log::error($e);
                    return response()->json(['error' => 'Unable to update attendance.'], 400);
                }
            }
            return view('admin.attendance.attendance-edit', compact('attendance'));
        } catch (ValidationException $e) {
            \Log::error('Validation failed during attendance update.', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 404);
        }
    }


    public function leaveRequestAdminList(Request $request)
    {


        if ($request->isMethod('post')) {
//            dd($request->all());
            $params = [];

            if (!empty($request->input('search'))) {
                $params['search'] = base64_encode($request->input('search'));
            }
            if (!empty($request->input('page_no'))) {
                $params['page_no'] = base64_encode($request->input('page_no'));
            }
            if ($request->filled('status')) {
                $params['status'] = base64_encode($request->input('status'));
            }
            if (!empty($request->input('added_by'))) {
                $params['added_by'] = base64_encode($request->input('added_by'));
            }
            if (!empty($request->input('created_at'))) {
                $params['created_at'] = base64_encode($request->input('created_at'));
            }

            return redirect()->route('admin.leaveRequestAdminList', $params)->withInput();
        } else {
            $leaves = LeaveRequest::with(['admin'])->orderByDesc('created_at');

            $perPage = 10;
            if (!empty($request->input('page_no'))) {
                $perPage = base64_decode($request->input('page_no'));
            }

            // Apply filters
            if ($request->filled('status')) {
                $status = base64_decode($request->input('status'));
                $leaves->where('status', $status);
            }
            if ($request->filled('search')) {
                $searchTerm = base64_decode($request->input('search'));
                $leaves->whereHas('admin', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', "%$searchTerm%");
                });
            }
            if($request->input('added_by')  != '') {
                $added_by = base64_decode($request->input('added_by'));
                $leaves->where('added_by',$added_by);
            }
            if ($request->filled('created_at')) {
                $date = base64_decode($request->input('created_at'));
                $leaves->whereDate('created_at', $date);
            }

            // Paginate the results
            $leaves = $leaves->paginate($perPage);

            // Return the view with the paginated leaves
            return view('admin.attendance.leave-request-list', compact('leaves'));
        }
    }
    public function leaveRequestList(Request $request)
    {
        $auth = \Session::get('userdata');


            $leaves = LeaveRequest::with(['admin'])->where('added_by', $auth->id)->orderByDesc('created_at')->paginate(10);
            return view('admin.attendance.user-leave-request-list', compact('leaves'));

    }




    public function storeLeaveRequest(Request $request) {
        $auth = \Session::get('userdata');
//        dd($auth);
//        dd($request->all());
        $leaves = LeaveRequest::create([
            "l_date" => $request->input('l_date'),
            "remark" => $request->input('remark'),
            "type" => $request->input('type'),
            "status" => 0,
            "added_by" => $auth->id,
            "manager_email" => $request->input('manager_email'),
        ]);
        if(!empty($auth->email)) {
            $EmailTemplate = EmailTemplate::where('slug','leave_application')->first();
            $to = 'danishreza317@gmail.com';
            $type = $leaves->type;
            $type_text = '';
            switch ($type) {
                case 0:
                    $type_text = 'Half Day';
                    break;
                case 1:
                    $type_text = 'One Day';
                    break;
                case 2:
                    $type_text = 'Two Days';
                    break;
                case 3:
                    $type_text = 'Three Days';
                    break;
                case 4:
                    $type_text = 'Four Days';
                    break;
                case 5:
                    $type_text = 'Five Days';
                    break;
                case 6:
                    $type_text = 'Six Days';
                    break;
                case 7:
                    $type_text = 'Seven Days';
                    break;
                case 10:
                    $type_text = 'Ten Days';
                    break;
                case 15:
                    $type_text = 'Fifteen Days';
                    break;
                default:
                    $type_text = 'Unknown Type';
                    break;
            }
            $remark = $leaves->remark;
            if($EmailTemplate && !empty($to)) {
                $mailMessage = str_replace(
                    array('{{remark}}', '{{type}}', '{{empname}}'),
                    array($remark, $type_text, $auth->name),
                    $EmailTemplate->description
                );
                $datas = array(
                    'to' => $to,
                    'from' => $auth->email,
                    'mailTitle' => $EmailTemplate->title,
                    'content' => $mailMessage,
                    'subject' => $EmailTemplate->subject
                );
                $managerEmails = $leaves->manager_email;
                if (!empty($managerEmails)) {
                    $managerEmailArray = explode(',', $managerEmails);
                    $managerEmailArray = array_map('trim', $managerEmailArray);

                    foreach ($managerEmailArray as $email) {
                        $datas['cc'][] = trim($email);
                    }
                }
                 try {
                Mail::send('emails.leave-mail', $datas, function($message) use ($datas) {
                    $message->to($datas['to'])->from($datas['from'])->subject($datas['subject']);
                    foreach ($datas['cc'] as $ccEmail) {
                        $message->cc($ccEmail);
                    }
                });
                 } catch(\Exception $e) {

                 }
            }
        }
        \Session::flash('message', "Leave Added Successfully");
        return 1;
    }
    public function leaveUpdate(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        $record = LeaveRequest::find($id);

        if ($record) {
            $record->update(['status' => $status]);

            return response()->json(['message' => 'Status updated successfully']);
        } else {
            return response()->json(['error' => 'Record not found'], 404);
        }
    }

    public function dashboardAttendanceList(Request $request)
    {
        // Get the month, year, and admin ID from the request
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $adminId = $request->input('added_by');

        // Select distinct added_by users from attendance sheet for the specified month and year
        $added_by_users_attendance = AttendanceSheet::whereMonth('created_at', $month)
            ->whereYear('created_at', $year);

        // Apply the admin filter if an admin ID is selected
        if ($adminId) {
            $added_by_users_attendance->where('added_by', $adminId);
        }

        $added_by_users_attendance = $added_by_users_attendance->distinct()->pluck('added_by');

        // Select distinct added_by users from leave requests for the specified month and year
        $added_by_users_leave = LeaveRequest::whereMonth('l_date', $month)
            ->whereYear('l_date', $year);

        // Apply the admin filter if an admin ID is selected
        if ($adminId) {
            $added_by_users_leave->where('added_by', $adminId);
        }

        $added_by_users_leave = $added_by_users_leave->distinct()->pluck('added_by');

        // Merge both sets of added_by users to get all unique users
        $added_by_users = $added_by_users_attendance->merge($added_by_users_leave)->unique();

        $user_attendance = [];

        foreach ($added_by_users as $user) {
            $adminName = Admin::find($user)->name;
            $weekOffCount0_attendance = AttendanceSheet::where('added_by', $user)
                ->where('weak_off', 0)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();
            $weekOffCount1_attendance = AttendanceSheet::where('added_by', $user)
                ->where('weak_off', 1)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();

            $halfDayLeaveCount = LeaveRequest::where('added_by', $user)
                ->where('type', 0)->where('status', 1)
                ->whereMonth('l_date', $month)
                ->whereYear('l_date', $year)
                ->count();
          /*  $totalLeavesCount = LeaveRequest::where('added_by', $user)
                ->sum('no_of_leave');*/

            $user_attendance[] = [
                'added_by' => $adminName,
//                'leave'=>$totalLeavesCount,
                'week_off_count_0_attendance' => $weekOffCount0_attendance,
                'week_off_count_1_attendance' => $weekOffCount1_attendance,
                'half_day_leave_count' => $halfDayLeaveCount,
            ];
        }

        return view('admin.attendance.attendance-dashboard', compact('user_attendance'));
    }
    public function addNoOfLeave(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            $id = base64_decode($data['id']);
            LeaveRequest::where('id', $id)->update(array('no_of_leave' => $data['no_of_leave']));
            return 1;
        }


    }



}