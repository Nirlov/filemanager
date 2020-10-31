<?php

namespace App\Modules\Filemanager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Lib\FileUpload;

use App\Http\Controllers\Controller;
use Auth;

//Models
use App\Models\Directory;
use App\Models\ContentBank;
use App\Models\Setting;

//Repository
use App\Modules\Filemanager\Repositories\ContentBankRepository;

class ContentBankController extends Controller
{
	private $contentBankRepository;

    public function __construct(ContentBankRepository $contentBankRepository)
    {
        $this->middleware('auth');
        $this->contentBankRepository = $contentBankRepository;
    }

    public function index()
    {
    	return view('filemanager::contentbank');
    }

    public function directoryList()
    {
    	$data = $this->contentBankRepository->directoryList();
    	return response()->json($data, 200);
    }

    public function directoryStore(Request $request)
    {
    	$data = $this->contentBankRepository->directoryStore($request);
        return response()->json($data, 200);
    }

    public function directoryEdit(Request $request, $id)
    {
    	$data = $this->contentBankRepository->directoryEdit($request, $id);
        return response()->json($data, 200);
    }

    public function directoryDestroy($id)
    {
    	$data = $this->contentBankRepository->directoryDestroy($id);
        return response()->json($data, 200);
    }

    public function contentStore(Request $request)
    {
    	$configuration = $this->manualSetting();

    	$validatedData = $request->validate([
            'thumbnail'       => 'required|max:'.$configuration['file_size'].'|mimes:'.$configuration['file_extension']
        ]);

    	$user_id = Auth::id();

        $input = $request->all();

        $insert = new ContentBank;

        $insert->directory_id           = $input['directory_id'];
        $insert->created_by      		= $user_id;
	    $insert->updated_by      		= $user_id;
        
        if($input['thumbnail']){
        	$file_type = $this->fileType();
            $file   = $input['thumbnail'];
            $prefix = 'file';
            $path   = 'uploads/files';

            $file_upload = new FileUpload;
            $upload = $file_upload->upload($file, $prefix, $path);

            if($upload['status'] == true)
            {
                $file_name = $upload['file_name'];
                $insert->file_name = $file_name;
            }
            
            $insert->content_type           = $file_type;
            $insert->title 					= $input['thumbnail']->getClientOriginalName();
        }

        if($insert->save()){
        	$data = [
	            'status'    => 'Success',
	            'code'      => '200',
	            'message'   => 'File successfully stored.',
	        ];
        }
        else{
            $data = [
	            'status'    => 'Danger',
	            'code'      => '200',
	            'message'   => 'File stored failed.',
	        ];
        }

        return response()->json($data, 200);
    }

    public function contentList(Request $request, $id)
    {
    	$keyword = $request->has('keyword')?$request['keyword']:null;
    	$order_by = $request->has('order_by')?$request['order_by']:'asc';

    	$data = ContentBank::where('directory_id', $id)
    			->when($keyword, function($q) use($keyword){
                    $q->where('title', 'LIKE', '%'.$keyword.'%');
                })
    			->orderBy('created_at', $order_by)
    			->paginate(3);

    	return response()->json($data, 200);
    }

    public function fileType()
    {
    	$fileInfo = finfo_open(FILEINFO_MIME_TYPE);
		$detected_type = finfo_file( $fileInfo, $_FILES['thumbnail']['tmp_name'] );
		$file_type = explode('/', $detected_type);

		return $file_type[0];
    }

    public function manualSetting()
    {
    	$configuration = Setting::first();
    	$data = [];

    	if(!empty($configuration)){
    		$data['file_size'] = $configuration['file_size']*1024;
    		$file_extension = json_decode($configuration['file_extension'], true);
    		$all_extension = [];
    		foreach($file_extension as $key=>$all){
    			if($all) array_push($all_extension, $key);
    		}
    		$data['file_extension'] = implode(',',$all_extension);
    	}else{
    		$data['file_size'] = 1024;
    		$data['file_extension'] = 'jpg,jpeg,png,gif,mp3,wav,wma,mp4,gp3,avi,doc,pptx,pdf';
    	}

    	return $data;
    }
}
