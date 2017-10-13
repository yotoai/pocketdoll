<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    //
    public function filesUpload(Request $request)
    {
        $pic = '';
        if($request->hasFile('pic'))
        {
            if ($request->file('pic')->isValid()){
                $file = $request->file('pic');
                return storage_path( $file->store('/image'));
            }else{
                return ['code'=>-1,'msg'=>'图片上传失败'];
            }
        }else{
            return $pic;
        }
    }
}
