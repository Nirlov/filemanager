<?php

namespace App\Modules\Filemanager\Repositories;

use Auth;
//Models
use App\Models\Directory;

class ContentBankRepository
{
	public function directoryList()
	{
		return Directory::all();
	}

	public function directoryStore($request)
	{
		$user_id = Auth::id();

        $input = $request->all();

        $insert = new Directory;

	    $insert->title      		= $input['title'];
	    $insert->created_by      	= $user_id;
	    $insert->updated_by      	= $user_id;

	    if($insert->save()){
            $data = [
	            'status'    => 'Success',
	            'code'      => '200',
	            'message'   => 'Directory successfully Save.',
	        ];
        }
        else{
            $data = [
	            'status'    => 'Danger',
	            'code'      => '200',
	            'message'   => 'Directory Added Failed.',
	        ];
        }

        return $data;
	}

	public function directoryEdit($request, $id)
	{
		$user_id = Auth::id();

        $input = $request->all();

        $insert = Directory::find($id);

	    $insert->title      		= $input['title'];
	    $insert->updated_by      	= $user_id;

	    if($insert->update()){
            $data = [
	            'status'    => 'Success',
	            'code'      => '200',
	            'message'   => 'Directory successfully updated.',
	        ];
        }
        else{
            $data = [
	            'status'    => 'Danger',
	            'code'      => '200',
	            'message'   => 'Directory updated Failed.',
	        ];
        }

        return $data;
	}

	public function directoryDestroy($id)
	{
		$insert = Directory::find($id);

    	if($insert->delete()){
            $data = [
	            'status'    => 'Success',
	            'code'      => '200',
	            'message'   => 'Directory successfully deleted.',
	        ];
        }
        else{
            $data = [
	            'status'    => 'Danger',
	            'code'      => '200',
	            'message'   => 'Directory deleted failed.',
	        ];
        }

        return $data;
	}
}