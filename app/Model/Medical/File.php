<?php

namespace App\Model\Medical;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //

    public static function getDocWoker($worker)
    {
        $docFile = File::where('worker_id', $worker->id)->orderBy('created_at', 'asc')->get();
        return ($docFile);
    }
    public static function saveDocWoker($request, $worker)
    {
       // dump($request->primdoc);
        $prim=htmlspecialchars($request->primdoc);
        $file=$request->file('filedoc');
        $md5=md5_file($file->getRealPath());
        $sm_md5=substr($md5, 0, 2);
        $name=$file->getClientOriginalName();
        $store = 'file/med/md5/'.$sm_md5.'/';
        $file->storeAs($store, $md5);
        $item=new File();
        $item->worker_id=$worker->id;
        $item->md5=$md5;
        $item->full_name=$prim;
        $item->name=$name;
        $item->save();
        return $item;
    }
}
