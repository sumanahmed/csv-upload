<?php

namespace App\Http\Controllers;

use App\Imports\ImportStudent;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use DB, Log;

class StudentController extends Controller
{
    /**
     * upload csv file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {  
        DB::beginTransaction();

        try {
            
            if ($request->hasFile('attachment')) {
                $file       = $request->file('attachment');
                $file_name  = time().".".$file->getClientOriginalExtension();
                $directory  = 'uploads/attachment/';
                $file->move($directory, $file_name);
                $file_path  = $directory.$file_name;

                $import = new ImportStudent();
                Excel::import($import, $file_path);
                
                unlink($file_path);
            }

            DB::commit();

        } catch (\Exception $ex) {

            Log::info("controller   exception : ". $ex->getMessage());

            DB::rollback();

            return response()->json([
                'status' => 403,
                'data'   => $ex->getMessage(),
            ]);
        }  
            
        return response()->json([
            'status' => 201,
            'data'   => [],
        ]);
    }
}
