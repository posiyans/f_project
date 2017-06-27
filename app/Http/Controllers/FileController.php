<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Gate;
use App\Model\Medical\File;

class FileController extends Controller
{
    //



    public function medDownload($id)
    {
        if (Gate::denies('med-page')) {
            return redirect('home');
        }
        $docFile= File::find($id);
        $smname=substr($docFile->md5,0,2);
        $path = storage_path('app/file/med/md5/'.$smname.'/'.$docFile->md5);

        return response()->download($path,$docFile->name);
    }
}
