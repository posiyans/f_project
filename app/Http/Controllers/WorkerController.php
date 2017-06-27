<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gate;

use App\Model\Medical\Worker;
use App\Model\Medical\File;
use App\Model\Medical\Diagnosis;
use App\Model\Medical\ActionType;
use App\Model\Medical\Lpy;
use App\Model\Medical\Complaint;




use App\Model\Firm;

use App\Model\Sms;
use Carbon\Carbon;

class WorkerController extends Controller
{
    //


    public function index()
    {
        if (Gate::denies('med-page')) {
            return redirect('home');
        }
        return view('med.search');
    }

    public function show(Request $request, $f = 0)
    {
        if (Gate::denies('med-page')) {
            return redirect('home');
        }
        $worker = Worker::find($f);
        if ($request->isMethod('post')) {
            dump($_POST);
            if ($request->hasFile('filedoc') && $request->file('filedoc')->isValid()) {
                File::saveDocWoker($request, $worker);
            }
            if ($request->complaint_text) {
                Complaint::add($request, $worker);
            }
        }
        $worker = Worker::find($f);
        if (empty($worker)) {
            return redirect(route('WorkerSearchIndex'));
        }
        $docFile= File::getDocWoker($worker);
        $diagnos= Diagnosis::where('worker_id', $worker->id)->get();


        //dump($worker->complaints->getActions);
        //$sms = Sms::where('worker_id', $worker->id)->orderBy('created_at', 'asc')->get();
        $sms = Sms::getWokerSms($worker->id);
        $smsBalans = Sms::getBalans();
        $smsphone = Sms::parserPhone($worker->phone);
        $medActionType=ActionType::all();
        $lpy=Lpy::all();
        $money=$worker->getMoney();
        //dump($money);
        return view('med.worker.woker_show', ['worker'=>$worker,
                                            'sms'=> $sms,
                                            'smsbalans'=>$smsBalans,
                                            'smsphone' => $smsphone,
                                            'docfiles'=>$docFile,
                                            'diagnos'=>$diagnos,
                                            'medActionType'=>$medActionType,
                                            'lpy'=>$lpy,
                                            'money'=>$money
                                            ]);
    }
    public function search(Request $request)
    {
        $find=$request->find;
        $workers = new Worker;
        $count_rez = 20;
        $count_workers = $workers->findWorker($find);
        $workers = $workers->findWorker($find, $count_rez);
        $count_workers=$count_workers->count();
        return view('med.search_table', ['workers'=>$workers, 'count_woker' => $count_workers,'find' => $find, 'count'=> $count_rez]);
    }
    public function edit(Request $request, $worker_id)
    {
        if ($request->isMethod('post')) {
            //dump($_POST);
           Worker::updateWorker($request, $worker_id);
           return redirect(route('WorkerView',$worker_id));
        }
        if ($worker_id=='new') {
            $worker = new Worker;
            $action = "Добавить нового сотрудника";
        } else {
            $worker = Worker::find($worker_id);
             $action =$worker->fam." ".$worker->name." ".$worker->ot;
            if (isset($worker->data_rogd)) {
                $action .= " ".Carbon::createFromFormat('Y-m-d', $worker->data_rogd)->format('d-m-Y');
            }
        }
   
        return view('med.worker.add', ['worker'=>$worker,'action'=>$action]);
    }
}
