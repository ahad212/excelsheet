<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class excel2 extends Model
{
    use HasFactory;
    protected $table = 'paidlist';

    protected $fillable = [
        'Armyts'
    ];
    public static function getPaidlist()
    {
        $records = DB::table('paidlist')->get();
        return $records;
    }
}
