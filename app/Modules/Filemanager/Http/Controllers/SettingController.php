<?php

namespace App\Modules\Filemanager\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Auth;

//Models
use App\Models\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$data = Setting::first();

    	return view('filemanager::setting', compact('data'));
    }

    public function settingConfiguration(Request $request)
    {
    	$user_id = Auth::id();

        $input = $request->all();

        $setting = Setting::first();

        if(!empty($setting)){
        	$setting->file_size 		= $input['file_size'];
        	$setting->file_extension 	= $input['file_extension'];
        	$setting->updated_by 		= $user_id;
        }else{

        	$setting = new Setting;

        	$setting->file_size 		= $input['file_size'];
        	$setting->file_extension 	= $input['file_extension'];
        	$setting->created_by 		= $user_id;
        	$setting->updated_by 		= $user_id;
        }

        if($setting->save()){
        	$data = [
	            'status'    => 'Success',
	            'code'      => '200',
	            'message'   => 'Setting successfully updated.',
	        ];
        }
        else{
            $data = [
	            'status'    => 'Danger',
	            'code'      => '200',
	            'message'   => 'Setting updated failed.',
	        ];
        }

        return response()->json($data, 200);
    }
}
