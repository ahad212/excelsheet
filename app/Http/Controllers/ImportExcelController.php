<?php

namespace App\Http\Controllers;
use App\Models\excel1;
use App\Models\excel2;
use App\Exports\excel1Export;
use App\Exports\excel2Export;
use Illuminate\Http\Request;
use DB;
use Excel;
use DataTables;
use App\Imports\eximport;
use App\Imports\eximport2;
class ImportExcelController extends Controller
{

    public function register(Request $request) {

       $exist = DB::table('user')->where('email',$request->email)->first();
       if ($exist) {
            return back()->with('danger', 'Email already exist.');
       }
        $data = array();
        $data['name'] = $request->username;
        $data['email'] = $request->email;
        $data['pass'] = md5($request->pass);
        $insert = DB::table('user')->insert($data);

        if ($insert) {
            return redirect()->route('logg')->with('success', 'Registered successfully.');
        } 
    }

    public function login (Request $request) {

        $get = DB::table('user')->where([['email',$request->email],['pass', md5($request->pass)]])->first();
        if ($get) {
            return redirect()->route('import_excel')->with('success', 'Login successfully.');
        } else {
            return back()->with('danger', 'Email & Password not matched.');
        }
    }
    public function index()
    {
     $data = excel1::all();
     $matched = array();
     foreach ($data as $key => $datas) {
        $data1 = DB::table('paidlist')->select('Armyts')->where('Armyts',$datas->Army)->orWhere('Armyts',$datas->Ts)->first();
        if ( $data1 === null ) {
            $datas->extra = 'Unmatched';
        } else {
            $datas->extra = $data1->Armyts;

        }
    }
    // return view('import_excel',['data' => $data]);
    return response()->json(['data' => $data]);
    }

    public function matched()
    {
     $data = excel1::all();
     $matched = array();
     foreach ($data as $key => $datas) {
        $data1 = DB::table('paidlist')->select('Armyts')->where('Armyts',$datas->Army)->orWhere('Armyts',$datas->Ts)->first();
        if ( $data1 === null ) {
            $datas->extra = 'Unmatched';
        } else {
            $datas->extra = $data1->Armyts;
            array_push($matched,$datas);
        }
     }
    //  return DataTables::queryBuilder($data)->toJson();
    return response()->json($matched);
    }

    public function unmatched()
    {
     $data = excel1::all();
     $unmatch = array();
     foreach ($data as $key => $datas) {
        $data1 = DB::table('paidlist')->select('Armyts')->where('Armyts',$datas->Army)->orWhere('Armyts',$datas->Ts)->first();
        if ( $data1 === null ) {
            $datas->extra = 'Unmatched';
            array_push($unmatch,$datas);
        } else {
            $datas->extra = $data1->Armyts;
        }
     }
    //  return DataTables::queryBuilder($data)->toJson();
    return response()->json($unmatch);
    }

    public function import(Request $request)
    {
     $this->validate($request, [
      'select_file'  => 'required|mimes:xls,xlsx'
    ]);

    $path = $request->file('select_file')->getRealPath();

    if ( $path ) {
        try {
            $data = Excel::import(new eximport,$path);
        } catch (\Throwable $th) {
            $data = Excel::import(new eximport2,$path);
        }

    }
     return back()->with('success', 'Excel Data Imported successfully.');
    }
}