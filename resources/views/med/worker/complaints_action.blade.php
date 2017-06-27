<script type= "text/javascript" >
function report(id){
    var save = confirm("Потвердить действие");
    if (save){
        var url='{{ route('WorkeractionPeport') }}';
        var data='action_id='+id;
        $.ajax({
            url: url,             // указываем URL и
            type: "POST",
            data: data,
            dataType : "text",                     // тип загружаемых данных
            async: true,
            beforeSend: function(request) {
                return request.setRequestHeader("X-CSRF-TOKEN", $('meta[name=csrf-token]').attr('content'));
            },
                success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                alert (data);
                //$("#smsres").html(data);
                setTimeout(function(){window.location.reload();},500);
            }
        });
    }
}
function complaintClose(id){
    var save = confirm("Закрыть обращение");
    if (save){
        var url='{{ route('ComplaintClose') }}';
        var data='complain_id='+id;
        $.ajax({
            url: url,             // указываем URL и
            type: "POST",
            data: data,
            dataType : "text",                     // тип загружаемых данных
            async: true,
            beforeSend: function(request) {
                return request.setRequestHeader("X-CSRF-TOKEN", $('meta[name=csrf-token]').attr('content'));
            },
                success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                alert (data);
                //$("#smsres").html(data);
                setTimeout(function(){window.location.reload();},500);
            }
        });
    }
}
function actionClose(id){
    var save = confirm("Закрыть действие");
    if (save){
        var url='{{ route('ActionClose') }}';
        var data='action_id='+id;
        $.ajax({
            url: url,             // указываем URL и
            type: "POST",
            data: data,
            dataType : "text",                     // тип загружаемых данных
            async: true,
            beforeSend: function(request) {
                return request.setRequestHeader("X-CSRF-TOKEN", $('meta[name=csrf-token]').attr('content'));
            },
                success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                alert (data);
                //$("#smsres").html(data);
                setTimeout(function(){window.location.reload();},500);
            }
        });
    }
}


</script>
@if (asset($worker->complaints))
    <table class="table table-bordered">
    <tr>
        <th></th>
        <th>Дата обращения</th>
        <th>Тип</th>
        <th>Причина обращения</th>
        <th>Статус</th>
        <th>Проведеные дествия</th>
        <th>Пояснение</th>
        <th>Дата</th>
        <th>ЛПУ</th>
        <th>{{Html::image(asset('src/img/phone.png'))}}</th>
        <th>Статус</th>
        <th>Цена</th>
    </tr>

    @foreach($worker->complaints as $complaint)

        <tr>
            <td @if (count($complaint->getActions)>0) rowspan="{{count($complaint->getActions)}}" @endif class="{{empty($complaint->enable) ? 'alert-success':''}}">
              <a href="{{route('MedComplaintEdit',$complaint->id)}}">{{Html::image('src/img/b_edit.png')}}</a>
             
            </td>
            <td @if (count($complaint->getActions)>0) rowspan="{{count($complaint->getActions)}}" @endif class="{{empty($complaint->enable) ? 'alert-success':''}}">{{$complaint->created_at}}</td>
            <td @if (count($complaint->getActions)>0) rowspan="{{count($complaint->getActions)}}" @endif>{{$complaint->type_id[$complaint->type]}}</td>
            <td @if (count($complaint->getActions)>0) rowspan="{{count($complaint->getActions)}}" @endif>{{$complaint->text }}</td>
            <td @if (count($complaint->getActions)>0) rowspan="{{count($complaint->getActions)}}" @endif class="{{empty($complaint->enable) ? 'alert-success':''}}" style="text-align: center; vertical-align:middle">
                @if (!empty($complaint->enable)) 
                    Закрыто<br>
                    {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $complaint->enable)->format('d-m-Y') }}
                    @else
                    <div onClick="complaintClose({{$complaint->id}}) "><span class="glyphicon glyphicon-saved" aria-hidden="true"></span>Закрыть</div>
                    @endif
            </td>
            @foreach($complaint->getActions as $i=>$action)
                @if($i>0)
                    <tr>
                @endif 
                <td  class="{{empty($action->enable) ? 'alert-success':''}}">{{$action->getType->name}}</td>
                <td> {{$action->text}} </td>
                <td> {{$action->data}} </td>
                <td>
                @if ($action->lpy_id)
                    {{$action->getLpy->name}}
                @endif
                </td>
                <td  class="{{empty($action->report) ? 'alert-success':''}}" style="text-align: center; vertical-align:middle">
                @if (empty($action->report))
                    {{HTML::image('src/img/phone.png','',['onClick'=>"report(".$action->id.")"])}}
                @endif
                {{$action->report}} 
                </td>
                <td  class="{{empty($action->enable) ? 'alert-success':''}}" style="text-align: center; vertical-align:middle">
                    @if (!empty($action->enable)) 
                        Закрыто<br>
                        {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $action->enable)->format('d-m-Y') }}
                    @else
                        <div onClick="actionClose({{$action->id}})"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span>Закрыть</div>
                    @endif
                </td>
                <td>
                @if ($action->money)
                    {{$action->money}} .руб
                @endif
                </td>
                
                    </tr>
                
            @endforeach
            @if (count($complaint->getActions)==0)
                 </tr>
            @endif
        
    @endforeach
    </table>
@endif
