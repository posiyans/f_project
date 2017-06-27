<?php

namespace App\Model\Medical;

use Illuminate\Database\Eloquent\Model;
use App\Model\Medical\Action;
use App\Model\Medical\Lpy;
use App\Model\Medical\ActionType;
use App\Model\Medical\Worker;
use Auth;
use Carbon\Carbon;

class Complaint extends Model
{
    //
    public function getActions()
    {
        return $this->hasMany(Action::class, 'complaint_id', 'id');
    }
    public function getType()
    {
        return $this->hasMany(ActionType::class, 'id', 'action_type_id');
    }
    public function worker()
    {
        return $this->hasOne(Worker::class, 'id', 'worker_id');
    }

    public $type_id= [ 0 =>"Актив",
                    1 => "ЦИПС",
                    2 => "Обращение",
                    3 => "Терапевт"
                    ];


    public static function add($request, $worker)
    {
        //dump($request);
        $complaint = new Complaint();
        $complaint->text=$request->complaint_text;
        $complaint->worker_id=$worker->id;
        $complaint->type=$request->type;
        $actions_key=$request->action_type;
        //dump($complaint);
        //if (count($actions_key)>0){
           // foreach ($actions_key as $i=>$type){
                $complaint->getActions->lpy_id=$request->lpy;
                $complaint->getActions->text=$request->prim;
          // }
        //}
        //dump($complaint);
        $complaint->save();
        //$complaint->push();
        //dump($complaint);
        $hist="Создано обращение<br>";
        $hist.=Action::add($complaint, $request);
        if ($hist!='') {
            $complaint->history.="<b>".Carbon::now()." ".Auth::user()->name."</b><br>".$hist;
        }
        $complaint->save();
    }

    public static function complUpdate($request, $complaint_id)
    {
         $complaint = Complaint::find($complaint_id);
         $hist='';
        if ($complaint->text!=$request->text) {
            $hist.="Смена причины обращения с ".$complaint->text." на ".$request->text."<br>";
            $complaint->text=$request->text;
        }
        if ($complaint->type!=$request->type) {
            $hist.="Смена типа записи с ".$complaint->type_id[$complaint->type]." на ".$complaint->type_id[$request->type]."<br>";
            $complaint->type=$request->type;
        }
        foreach ($complaint->getActions as $action) {
            if (empty($request->actText[$action->id]) && $action->text!=$request->actText[$action->id]) {
                $hist.="Смена описания действия № ".$action->id." с ".$action->text." на ".$request->actText[$action->id]."<br>";
                $action->text=$request->actText[$action->id];
            }
            if (isset($request->actType[$action->id]) && $action->action_type_id!=$request->actType[$action->id]) {
                $hist.="Смена типа действия № ".$action->id." с ".$action->action_type_id." на ".$request->actType[$action->id]."<br>";
                $action->action_type_id=$request->actType[$action->id];
            }
            if (isset($request->actLpy[$action->id]) && $action->lpy_id!=$request->actLpy[$action->id]) {
                $oldLpy=$action->getLpy->name;
                $newLpy=Lpy::find($request->actLpy[$action->id])->name;
                $hist.="Смена ЛПУ действия № ".$action->id." с ".$oldLpy." на ".$newLpy."<br>";
                $action->lpy_id=$request->actLpy[$action->id];
            }
            if (isset($request->actData[$action->id]) && $action->data!=$request->actData[$action->id]) {
                $hist.="Смена типа действия № ".$action->id." с ".$action->data." на ".$request->actData[$action->id]."<br>";
                $action->data=$request->actData[$action->id];
            }

        }
        $hist.=Action::add($complaint, $request);
        if ($hist!='') {
            $complaint->history.="<b>".Carbon::now()." ".Auth::user()->name."</b><br>".$hist;
        }
        $complaint->push();
        dump($complaint);
    }
}
