<?php

namespace App\Imports;

use App\Models\excel1;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class eximport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new excel1([
            'Army' => $row['army'],
            'Ts' => $row['ts']
           ]);
    }
}
