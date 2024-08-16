<?php
   
namespace App\Imports;
   
use App\Models\UsersOnlineData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
    
class UsersOnlineDataImport implements ToModel, WithHeadingRow {
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row) {
		$dob = null;
		if(!empty($row['dob']) && is_numeric($row['dob'])){
			$dob = strtotime("- ".$row['dob']." year", strtotime("01-01-".date('Y')));
		}
        return new UsersOnlineData([
            'name'     => $row['name'],
            'gender'     => $row['gender'],
            'dob'     => $row['dob'],
            'title'    => $row['title'],
            'type'    => $row['type'],
            'mobile'    => $row['mobile'],
            'email'    => $row['email'],
            'com_name'    => $row['com_name'],
            'url'    => $row['url'],
            'data_type'    => $row['data_type'],
            'bp_s'    => $row['bp_s'],
            'bp_d'    => $row['bp_d'],
            'sugar'    => $row['sugar'],
            'dob'    => $dob,
            'gender'    => $row['gender'],
        ]);
    }
}