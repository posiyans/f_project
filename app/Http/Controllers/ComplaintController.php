<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Medical\Complaint;
use App\Model\Medical\ActionType;
use App\Model\Medical\Lpy;
use Carbon\Carbon;

class ComplaintController extends Controller
{
    //
    public function edit(Request $request,$complaint_id)
    {
        //echo($complaint_id);
       
        if ($request->isMethod('post')) {
            dump($_POST);
            echo $complaint_id;
            Complaint::complUpdate($request,$complaint_id);
        }
        $complaint = Complaint::find($complaint_id);
        $medActionType=ActionType::all();
        $lpy=Lpy::all();
        //$complaint = Complaint::find($complaint_id);
        //dump($complaint);
        return view('med.worker.complaint.complaint_edit', ['complaint'=>$complaint,'medActionType'=>$medActionType,'lpy'=>$lpy]);
        //dump($complaint);
    }
    public function close(Request $request)
    {
        if ($request->isMethod('post')) {
            $complain_id=$request->complain_id;
            $med_action = Complaint::find($complain_id);
            $med_action->enable=Carbon::now();
            $med_action->save();
            echo "OK";
        }
    }
}
