@extends('layouts.app')
@section('content')
<script src="/js/dt/jscal2.js"></script>
<script src="/js/dt/ru.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dt/jscal2.css" />
<link rel="stylesheet" type="text/css" href="/css/dt/border-radius.css" />
<script type= "text/javascript" >
    window.onload=function(){
        changStatus();
        new Calendar({
                        inputField: "rogdtext",
                        dateFormat: "%d-%m-%Y",
                        trigger: "rogdtext",
                        bottomBar: true,
                        selectionType: Calendar.SEL_MULTIPLE,
                        showTime: 24,
                        onSelect: function() {
                                var date = Calendar.intToDate(this.selection.get());
                                //LEFT_CAL.args.min = date;
                                //LEFT_CAL.redraw();
                                this.hide();
                        }
                    });
        new Calendar({
                        inputField: "prinyattext",
                        dateFormat: "%d-%m-%Y",
                        trigger: "prinyattext",
                        bottomBar: true,
                        selectionType: Calendar.SEL_MULTIPLE,
                        showTime: 24,
                        onSelect: function() {
                                var date = Calendar.intToDate(this.selection.get());
                                //LEFT_CAL.args.min = date;
                                //LEFT_CAL.redraw();
                                this.hide();
                        }
                    });


                    
    }
    function changStatus(){
        var d=document.getElementById("statustext").value;
        var ele = document.getElementById("parent");
        var dpr = document.getElementById("dprinyat");
        var firm = document.getElementById("firm");
        var dolgn = document.getElementById("dolgn");
        if (d==9)
        {
            ele.style.display = "block";
            dpr.style.display = "none"; 
            firm.style.display = "none"; 
            dolgn.style.display = "none"; 
        }else{
            ele.style.display = "none";
            dpr.style.display = "block";
            firm.style.display = "block";
            dolgn.style.display = "block";
        }
    }
</script>
<div class="container">
    <form method="post" action=''>
        {{ csrf_field() }}
        <h2>{{$action}}</h2>
        <div class="form-group">
        @if (isset($worker->id))
            {{Form::hidden('worker_id',$worker->id)}}   
        @else
            {{Form::hidden('worker_id','new')}}
        @endif
        </div>
        <div class="form-group">
            <label for="famtext"><b>Фамилия</b></label>
            {{Form::text('fam',$worker->fam,['class'=>"form-control",'id'=>'famtext','placeholder'=>'Иванов'])}}
        </div>
        <div class="form-group">
            <label for="nametext"><b>Имя</b></label>
            {{Form::text('name',$worker->name,['class'=>"form-control",'id'=>'nametext','placeholder'=>'Иван'])}}
        </div>
        <div class="form-group">
            <label for="ottext"><b>Отчество</b></label>
            {{Form::text('ot',$worker->ot,['class'=>"form-control",'id'=>'ottext','placeholder'=>'Иванович'])}}
        </div>
        <div class="form-group">
            <label for="rogdtext"><b>Дата рождения</b></label>
            @if (isset($worker->data_rogd))
                {{Form::text('data_rogd',Carbon\Carbon::createFromFormat('Y-m-d', $worker->data_rogd)->format('d-m-Y'),['class'=>"form-control",'id'=>'rogdtext','placeholder'=>'30-08-1990'])}}        </div>
            @else
                {{Form::text('data_rogd','',['class'=>"form-control",'id'=>'rogdtext','placeholder'=>'30-08-1990'])}}        </div>
            @endif
        <div class="form-group">
            <label for="statustext"><b>Статус</b></label>
            {!! Form::select('status_id',['0'=>'Статус сотрудника']+$worker->getStatusList(true)->pluck('full_name','id')->toArray(),$worker->status_id,['class'=> 'selectpicker form-control','id'=>'statustext','data-live-search'=>"true", 'onChange'=>'changStatus()']) !!}
        </div>
        <div class="form-group" style="display: none" id="parent">
            <label for="parenttext"><b>Родственник</b></label>
            {!! Form::select('parent',[''=>'Укажите кто работает в Холдинге']+$worker->getFioFirm()->pluck('name','id')->sort()->toArray(),$worker->parent,['class'=> 'selectpicker form-control','id'=>'parenttext','data-live-search'=>"true"]) !!}
        </div>
        <div class="form-group" id="dprinyat">
            <label for="prinyattext"><b>Дата принятия на работу</b></label>
            @if (isset($worker->data_prinyat))
                {{Form::text('data_prinyat',Carbon\Carbon::createFromFormat('Y-m-d', $worker->data_prinyat)->format('d-m-Y'),['class'=>"form-control",'id'=>'prinyattext','placeholder'=>'01-01-2010'])}}
            @else
                {{Form::text('data_prinyat','',['class'=>"form-control",'id'=>'prinyattext','placeholder'=>'01-01-2010'])}}
            @endif
        </div>
        <div class="form-group" id="firm">
            <label for="firmtext"><b>Предприятие</b></label>
            
            {{ Form::select('firm',[''=>'Предприятие']+$worker->getFirmList()->pluck('name','id')->sort()->toArray(),$worker->firm,['class'=> 'selectpicker form-control','id'=>'firmtext','data-live-search'=>"true"]) }}
            
        </div>
        <div class="form-group" id="dolgn">
            <label for="dolgntext"><b>Должность</b></label>
            {{Form::text('dolgn',$worker->dolgn,['class'=>"form-control",'id'=>'prinyattext','placeholder'=>'Должность'])}}
        </div>
        <div class="form-group">
            <label for="phonetext"><b>Телефон</b></label>
            {{Form::text('phone',$worker->phone,['class'=>"form-control",'id'=>'phonetext','placeholder'=>'+7-912-345-67-89'])}}
        </div>
        <div class="form-group">
            <label for="adrestext"><b>Адрес проживания</b></label>
            {{Form::text('adress',$worker->adress,['class'=>"form-control",'id'=>'adrestext'])}}
        </div>
        <div class="form-group">
            <label for="propiskatext"><b>Адрес прописки</b></label>
            {{Form::text('adress_propiski',$worker->adress_propiski,['class'=>"form-control",'id'=>'propiskatext'])}}
        </div>
        <div class="form-group">
            <label for="primtext"><b>Примечание</b></label>
            {{Form::textarea('prim',$worker->prim,['class'=>"form-control",'id'=>'primtext'])}}
        </div>


         
       <input type="submit" class="btn btn-primary" name=""  id="submit_id" value="Сохранить" />
    </form>
</div>
@endsection