<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class excel1 extends Model
{
    use HasFactory;

    protected $table = 'excelfile';

    protected $fillable = [
        'Army',
        'Ts'
    ];


    public static function getEmployee()
    {
        $records = DB::table('excelfile')->get();
        return $records;
    }
}
