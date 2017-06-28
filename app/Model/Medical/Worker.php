<?php

namespace App\Model\Medical;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Model\Firm;
use App\Model\Status;
use App\Model\Medical\Complaint;
use Carbon\Carbon;

class Worker extends Model
{
    //
   // protected $fillable = [fam,name,ot];
    //protected $dateFormat = 'Y-m-d H:i:s';
    public function setDataRogdAttribute($value)
    {

        $this->attributes['data_rogd'] =Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }
    public function getDataYvolenAttribute($value)
    {
        if ($value) {
            return Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y');
        }
    }
    public function getDataRogdAttribute($value)
    {
        if ($value) {
            return Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y');
        }
    }
    public function setDataPrinyatAttribute($value)
    {

        $this->attributes['data_prinyat'] =Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function firm_id()
    {
        return $this->hasOne(Firm::class, 'id', 'firm');
    }
    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'worker_id', 'id');
    }
    public function firm_1c_id()
    {
        return $this->hasOne(Firm::class, 'id', 'firm_1c');
    }
    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
    public function status_1c()
    {
        return $this->hasOne(Status::class, 'id', 'status_1c_id');
    }
    /*
    *$all  весь список или только сотрудники 
    */
    public function getFioFirm($all = false)
    {
        if ($all) {
            $workers = Worker::all();
        } else {
            $workers = Worker::where('status_id', '!=', '9')->where('status_id', '!=', '10')->get();
        }
        
        $workers->load('firm_id');
        $res= collect();
        foreach ($workers as $worker) {
            $wok=new Worker();
            $wok->id=$worker->id;
            $wok->name=$worker->fam." ".mb_substr($worker->name, 0, 1).". ".mb_substr($worker->ot, 0, 1).". ".$worker->firm_id->name;
            $res->push($wok);
        }
        return $res;
    }
    public function getStatusList($all = false)
    {
        if ($all) {
            $statuses = Status::all();
        } else {
            $statuses = Status::whereNull('type')->get();
            ;
        }
        return $statuses;
    }
    public function getFirmList($all = false)
    {
        if ($all) {
            $statuses = Firm::all();
        } else {
            $statuses = Firm::whereNotNull('parent')->get();
            ;
        }
        return $statuses;
    }
    public function getTypeCompaint()
    {
        $type= new Complaint();
        return $type->type_id;
    }
    public function getParent()
    {
        $parent= Worker::where('parent', $this->id)->get();
        return $parent;
    }
    public function findWorker($find, $count = false)
    {
        $find_array = explode(" ", $find);
        $poisk = '';
        $sql_data = [];
        for ($i=0; $i < count($find_array); $i++) {
            $poisk.=' concat_ws("-",`fam`,	`name`, `ot`, `dolgn`,`dolgn_1c`,
            `data_rogd`,`data_prinyat`,`data_prinyat_1c`,`data_yvolen`,
            `adress_propiski`,`adress_propiski_1c`,`adress`,`adress_1c`,
            `phone`,`phone_1c`,`poliklinika`,`poliklinika_1c`,
            `prim`,`prim_ok`,`history`) like :find'.$i.' and';
            $sql_data['find'.$i]='%'.$find_array[$i].'%';
        }
        $poisk=substr($poisk, 0, strlen($poisk)-3);

        //$sql = 'SELECT * FROM workers WHERE '.$poisk.' ORDER BY `data_yvolen` ASC , fam ASC, name ASC';
/*        $results = DB::select($sql, $sql_data);
        return $results;*/
        if ($count) {
            $wokers = $this->whereRaw($poisk, $sql_data)->orderBy('data_yvolen', 'asc')->orderBy('fam', 'asc')->take($count)->get();
        } else {
            $wokers = $this->whereRaw($poisk, $sql_data)->orderBy('fam', 'asc')->orderBy('data_yvolen', 'asc')->get();
        }
       
        return $wokers;
    }
    public static function updateWorker($request, $worker_id)
    {
        if ($worker_id=="new") {
            $worker= new Worker();
            $worker->fam=$request->fam;
            $worker->name=$request->name;
            $worker->ot=$request->ot;
            if (empty($request->parent)) {
                $worker->parent=$request->parent;
            }
            $worker->firm=$request->firm;
            $worker->dolgn=$request->dolgn;
            $worker->status_id=$request->status_id;
            $worker->data_rogd=$request->data_rogd;
            $worker->data_prinyat=$request->data_prinyat;
            $worker->adress=$request->adress;
            $worker->adress_propiski=$request->adress_propiski;
            $worker->phone=$request->phone;
            $worker->prim=$request->prim;
            $worker->save();
            //dump($worker);
            //dump($worker->data_rogd);
        } else {
            $worker= Worker::find($worker_id);
            $worker->fam=$request->fam;
            $worker->name=$request->name;
            $worker->ot=$request->ot;
            if (empty($request->parent)) {
                $worker->parent=$request->parent;
            }
            $worker->firm=$request->firm;
            $worker->dolgn=$request->dolgn;
            $worker->status_id=$request->status_id;
            $worker->data_rogd=$request->data_rogd;
            $worker->data_prinyat=$request->data_prinyat;
            $worker->adress=$request->adress;
            $worker->adress_propiski=$request->adress_propiski;
            $worker->phone=$request->phone;
            $worker->prim=$request->prim;
            $worker->save();
        }
    }
    public function getMoney()
    {
        $class = new \stdClass();
        $class->dms_now=0;
        $class->dms_all=0;
        $class->oms_now=0;
        $class->oms_all=0;
        $class->all=0;
        $types= ActionType::all();
        foreach ($types as $type) {
            $class->{"m".$type->id."_now"}=0;
            $class->{"m".$type->id."_all"}=0;
        }
        
        foreach ($this->complaints as $complaint) {
            foreach ($complaint->getActions as $action) {
                $class->all+=$action->money;
                if ($action->getType->type==1) {
                    $class->oms_all+=$action->money;
                    if (empty($action->enable) && Carbon::createFromFormat('Y-m-d H:i:s', $action->enable)->format('Y') == Carbon::now()->format('Y')) {
                        $class->{"m".$action->action_type_id."_now"}+=$action->money;
                    }
                    $class->{"m".$action->action_type_id."_all"}+=$action->money;
                } else {
                    if (isset($action->enable) && Carbon::createFromFormat('Y-m-d H:i:s', $action->enable)->format('Y') == Carbon::now()->format('Y')) {
                        $class->{"m".$action->action_type_id."_now"}+=$action->money;
                        $class->dms_now+=$action->money;
                    }
                    $class->{"m".$action->action_type_id."_all"}+=$action->money;
                    $class->dms_all+=$action->money;
                }
            }
        }
        return $class;
    }
}
