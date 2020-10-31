<?php

namespace App\Lib;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Auth;

//Model
use App\User;
use App\Models\Profile;
use App\Models\QuestionCategory;

class SiteInfo
{
    
    public function getInfo()
    {
    	$profile = Profile::first();
    	return $profile;
    }

    public function getCategory()
    {
    	$data = QuestionCategory::all();
    	return $data;
    }

}