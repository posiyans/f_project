@extends('layouts.app')
@section('content')
<script src="/js/dt/jscal2.js"></script>
<script src="/js/dt/ru.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dt/jscal2.css" />
<link rel="stylesheet" type="text/css" href="/css/dt/border-radius.css" />
<div class="container">
<a href="{{route('WorkerView',$complaint->worker->id)}}"><h4>{{ $complaint->worker->fam}} {{ $complaint->worker->name}} {{ $complaint->worker->ot}}</h4></a>
<b>Обращение в ГМО:</b> {{$complaint->created_at}}
@if (!empty($complaint->enable)) 
    <i>(Закрыто
    {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$complaint->enable)->format('d-m-Y') }}
    )</i>
@endif
<form name="complaint_data" id="test_form_id" method="post" action=''>
    {{ csrf_field() }}
    <br>
    <div class="form-group">
        <label for="compltype"><b>Тип записи:</b></label>
        
        {{Form::select('type',$complaint->type_id,$complaint->type,['data-style'=>'btn-info', 'class'=> 'btn-primary selectpicker form-control','id'=>'compltype'])}}
    </div>
    <div class="form-group">
        <label for="compltext"><b>Причина обращения</b></label>
       {{Form::textarea('text',$complaint->text,[ 'class'=>"form-control",'id'=>'compltext'])}}
    </div> 
    {!!$complaint->history!!}  
    <h3>Принятые меры</h3>
    <hr>
    @foreach($complaint->getActions as $i=>$action)
       
                <div class="well">
           
                        <div >
                            <h4><b>{{$i+1}}. {{$action->getType->name}}</b></h4>
         
                        </div>
                
                <div class="form-group">
                    <label for="acttype{{$i}}">Тип</label>
                    {{Form::select('actType['.$action->id.']',$medActionType->pluck('name','id'),$action->getType->id,
                                                    ['data-style'=>'btn-info',
                                                    'class'=> 'btn-primary selectpicker form-control',
                                                    'id'=>'acttype'.$i
                                                    ]) }}
                </div>
                <div class="form-group">
                    <label for="actttext{{$i}}">Текст</label>
                    <textarea class="form-control" name="actText[{{ $action->id }}]" id="actttext{{$i}}" cols="50" rows="5">{{$action->text}}</textarea>
                </div>
                @if ($action->getType->id>2)
                    <div class="form-group">
                        <label for="actlpy{{$i}}">ЛПУ</label>
                        @if (isset($action->getLpy->id))
                            {!! Form::select('actLpy['.$action->id.']',[''=>'Укажите ЛПУ']+$lpy->pluck('full_name','id')->sort()->toArray(),$action->getLpy->id,['class'=> 'selectpicker form-control','id'=>'actlpy'.$i]) !!}
                        @else
                            {!! Form::select('actLpy['.$action->id.']',[''=>'Укажите ЛПУ']+$lpy->pluck('full_name','id')->sort()->toArray(),'',['class'=> 'selectpicker form-control','id'=>'actlpy'.$i]) !!}
                        @endif
                    </div>

                    <label for="dt{{$i}}">Датa</label>
                    <div class="form-group">
                        <input id="dt{{$i}}" name="actData[{{$action->id}}]" value="{{$action->data}}"/>
                    </div>     
                @endif                
 
                
                </div>
               
                    <hr>

    @endforeach
                    <script type= "text/javascript" >
                    window.onload=function(){
    @foreach($complaint->getActions as $i=>$action)
    new Calendar({
                            inputField: "dt{{$i}}",
                            dateFormat: "%Y-%m-%d %k:%M",
                            trigger: "dt{{$i}}",
                    
                            bottomBar: true,
                            @if (!empty($action->data)) 
                            date: {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$action->data)->format('Ymd') }},
                            time: {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$action->data)->format('Hi') }},
                            @endif
                            selectionType: Calendar.SEL_MULTIPLE,
                            
                            
                showTime: 24,

                            onSelect: function() {
                                    var date = Calendar.intToDate(this.selection.get());
                                    //LEFT_CAL.args.min = date;
                                    //LEFT_CAL.redraw();
                                    this.hide();
                            }
                    });

    @endforeach
                    }
    </script>

    <div id="add"></div>
    <br>Добавить<br>

                    <div class="row" id="submit_id">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-btn ">{{ Form::select('',array_merge(['Проведеные действия'],$medActionType->pluck('name','id')->toArray()),0,['data-style'=>'btn-info', 'class'=> 'btn-primary selectpicker form-control','id'=>"deistv"]) }}</div>  
                                    <input type="button" class="btn btn-primary" id="add" onClick="add_destv(this)" value="Добавить" />
                                </div>
                            </div>
                            <div class="col-md-3">

                                
                                <input type="submit" class="btn btn-primary" name=""  id="submit_id" value="Сохранить" />
                            </div>
                        </div>

</form>











<script type= "text/javascript" >

function add_destv(){
d=document.getElementById("deistv").value;

var sel = document.getElementById("deistv"); // Получаем наш список
var dname = sel.options[sel.selectedIndex].text;
//alert(d);
if (d==0)
{
exit();
}
txt="<input type='hidden' name='new_type[]' value='"+d+"'/>"; 
txt+="<br><b>"+dname+".</b><br><TEXTAREA  name='new_prim[]' rows=5 cols=120 placeholder='' class='true'></TEXTAREA><br> ";
if ((d==4) || (d==3) || (d==7) || (d==8)){ 
txt+="Дата госпитализации:<input id='f_rangeStart' name='new_data[]'/><button id='f_rangeStart_trigger'>...</button><button id='f_clearRangeStart' onclick='clearRangeStart()'>clear</button>";
}else{
txt+="<input type='hidden' name='new_data[]'/>";  
}
if ((d==5) || (d==3) || (d==4) || (d==8) || (d==9) || (d==7)){ 
txt+='<br>ЛПУ{!! Form::select('new_lpy[]',[''=>'Укажите ЛПУ']+$lpy->pluck('name','id')->sort()->toArray(),['class'=> 'selectpicker form-control']) !!}';
}else{
txt+="<input type='hidden' name='new_lpy[]'/>";
}

txt+="<hr>";
 $("#submit_id").after(txt);
  new Calendar({
                          inputField: "f_rangeStart",
                          dateFormat: "%Y-%m-%d %k:%M",
                          trigger: "f_rangeStart_trigger",
				selectionType: Calendar.SEL_MULTIPLE,
                          bottomBar: true,
			showTime: 24,

                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                  //LEFT_CAL.args.min = date;
                                  //LEFT_CAL.redraw();
                                  this.hide();
                          }
                  });
                  function clearRangeStart() {
                          document.getElementById("f_rangeStart").value = "";
                          //LEFT_CAL.args.min = null;
                          //LEFT_CAL.redraw();
                  };

}
 </script>


<br><br><br><br><br><br><br>
</div> 

 @endsection