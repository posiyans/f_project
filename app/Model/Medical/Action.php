<?php

namespace App\Model\Medical;

use Illuminate\Database\Eloquent\Model;

use App\Model\Medical\ActionType;
use App\Model\Medical\Lpy;

class Action extends Model
{
    //
    protected $table='med_actions';

    public function getType()
    {
        return $this->hasOne(ActionType::class, 'id','action_type_id');
    }
    public function getLpy()
    {
         return $this->hasOne(Lpy::class, 'id', 'lpy_id');
    }

    public static function add($complaint,$request)
    {
        $hist='';
        $actions_key=$request->new_type;
        if (count($actions_key)>0){
            foreach ($actions_key as $i=>$type){
                if (isset($request->new_prim[$i])){
                    $item= new Action();
                    $item->complaint_id=$complaint->id;
                    $item->action_type_id=$request->new_type[$i];
                    $item->lpy_id=$request->new_lpy[$i];
                    $item->text=$request->new_prim[$i];
                    $item->data=$request->new_data[$i];
                    $item->save();
                    $hist.="Создано действие № ".$item->id."<br>";
                }
            }
        }
        return $hist;


    } 
}
