<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AppConstants;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Department;
use App\Models\File;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\TicketUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TicketController extends Controller
{

    public function AssignNow(Request $request)
    {
        $ticketId = $request->ticket_id;
        $userId = $request->user;
//        dd($request->all());
        if(is_null($ticketId)){
            throw new  HttpException(400, 'Please Select Ticket First');
        }

        // Find the ticket by ID
        $ticket = Ticket::find($ticketId);

        $ticket->assign_by = $userId;
        $ticket->save();

        // Optionally, you can return a response indicating the success of the operation
        return response()->json(['message' => 'Ticket assigned successfully']);


    }
    public function unassignTicketList(Request $request)
    {
        $query = Ticket::with(['user.files', 'comments.ticketReply'])
            ->whereNull('assign_by')
            ->orderByDesc('created_at')
            ->get();

        return view('supportTickets.ticket-list', compact('query'));
    }

    public function assignTicketList(Request $request)
    {
        // Start with a base query
        $query = Ticket::with(['assignByUser.departments', 'user', 'comments.ticketReply'])
            ->whereNotNull('assign_by')
            ->orderByDesc('created_at');

        // Apply filters if they exist in the request
        if ($request->filled('ticket_no')) {
            $query->where('ticket_no', $request->ticket_no);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department_id')) {
            $query->whereHas('assignByUser.departments', function ($query) use ($request) {
                $query->where('id', $request->department_id);
            });
        }

        // Execute the query
        $query = $query->get();

        return view('supportTickets.assign-ticket', compact('query'));
    }

    public function editTicket(Request $request)
    {

        $id = $request->id;
        $ticket = Ticket::with(['assignByUser.departments', 'user', 'comments.ticketReply'])->findOrFail($id);
        return view('supportTickets.edit-ticket', compact('ticket'));

    }
    public function getReplyMessage(Request $request)
    {

        $id = $request->id;
        $ticket = Ticket::with(['assignByUser.departments', 'user', 'comments.ticketReply'])->findOrFail($id);
        return view('supportTickets.update-status', compact('ticket'));

    }
    public function updateTicket(Request $request)
    {
        $id = $request->id;
        $departmentId = $request->input('department');
        $ticket = Ticket::findOrFail($id);
        $ticket->update([
            'status' => $request->input('status'),
            'assign_by' => $request->input('assign_by')
        ]);
        $ticketUser = TicketUser::where('id', $ticket->assign_by)->first();
        if ($ticketUser) {
            $ticketUser->update(['department_id' => $departmentId]);
        }

        return redirect()->back()->with('success', 'Ticket updated successfully.');
    }

    public function replyToComment(Request $request, Comment $comment)
    {
        $request->validate([
            'reply_message' => 'required|string|max:255',
        ]);

        $ticketData = $request->all();
        $ticketId = $ticketData['ticket_id'];

        // Retrieve the ticket
        $ticket = Ticket::findOrFail($ticketId);
        $assignByUser = $ticket->assignByUser;
        $comment->ticketReply()->create([
            'message' => $request->input('reply_message'),
            'ticket_id' => $request->input('ticket_id'),
            'department_id' => $assignByUser->department_id
        ]);

        return redirect()->back()->with('success', 'Reply submitted successfully.');
    }
    public function viewTickets()
    {
        $totalTickets = Ticket::count();
        $statusWiseCounts = Ticket::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count'),
            'status',
            'created_at'
        )
            ->groupBy('year', 'month', 'status')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Group the data by status for easier processing in the view
        $statusWiseCountsGrouped = [];
        foreach ($statusWiseCounts as $count) {
            $statusWiseCountsGrouped[$count->status][] = [
                'month' => $count->month,
                'count' => $count->count,
                'created_at' => $count->created_at
            ];
        }

//        dd($statusWiseCountsGrouped);

        // Pass the data to the view
        return view('supportTickets.ticket-view-progress', compact('totalTickets', 'statusWiseCountsGrouped'));
    }
    public function fetchUsers(Request $request)
    {
        $departmentId = $request->input('department_id');
        $users = TicketUser::where('department_id', $departmentId)->get();
        return response()->json($users);
    }





}
