<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gate;
use Carbon\Carbon;
use App\Model\Medical\Action;

class ActionController extends Controller
{
    //
    public function actionPeport(Request $request)
    {
        if (Gate::denies('med-page')) {
            return redirect('home');
        }
        if ($request->isMethod('post')) {
            $action_id=$request->action_id;
            $med_action = Action::find($action_id);
            $med_action->report=Carbon::now();
            $med_action->save();
            echo "OK";
        }
    }

    
    public function close(Request $request)
    {
        if ($request->isMethod('post')) {
            $action_id=$request->action_id;
            $med_action = Action::find($action_id);
            $med_action->enable=Carbon::now();
            $med_action->save();
            echo "OK";
        }
    }
}
