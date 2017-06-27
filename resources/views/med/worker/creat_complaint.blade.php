<script src="/js/dt/jscal2.js"></script>
<script src="/js/dt/ru.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dt/jscal2.css" />
<link rel="stylesheet" type="text/css" href="/css/dt/border-radius.css" />
<link rel="stylesheet" type="text/css" href="/css/dt/stell/stell.css" /> 


<script type= "text/javascript" >

function add_destv(i){
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
txt+='<br>ЛПУ{!! Form::select('new_lpy[]',['0'=>'Укажите ЛПУ']+$lpy->pluck('name','id')->sort()->toArray(),['class'=> 'selectpicker form-control']) !!}';
}else{
txt+="<input type='hidden' name='new_lpy[]'/>";
}

if (d==30){ 
txt+="Дата госпитализации:<input id='f_rangeStart' name='data[]'/><button id='f_rangeStart_trigger'>...</button><button id='f_clearRangeStart' onclick='clearRangeStart()'>clear</button>";

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

<input type="button" value="Создать обращение" class="btn btn-primary" onclick='jQuery(this).next().slideToggle("fast");'>                
        <div style='display: none;' id='kl'>
            <form name="complaint_data" id="test_form_id" method="post" action=''>
            {{ csrf_field() }}
                <input name='worker_id' hidden value="{{$worker->id}}">
		            <div style="vertical-align:middle; padding: 20px; ">
                        @foreach ($worker->getTypeCompaint() as $i=>$complaint)
                            <input type="radio" name="type" value="{{$i}}" {{$i == 2 ? 'checked':''}} >{{$complaint}}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        @endforeach
                   
                        <input name="vagn" type="checkbox" id="chetyre" onchange='ert()'>Важное<br>
                        <div class="Green1">
                        </div>
                    </div>
                <TEXTAREA id='pr' name='complaint_text' rows=5 cols=120 placeholder='Жалоба сотрудника' class='true'>
                </TEXTAREA>
                <br><br>Действия<br>
                   <div class="row" id="submit_id">
                        <div class="col-md-5">
                            <div class="input-group">
                                 <div class="input-group-btn ">{{ Form::select('',['0'=>'Проведеные действия']+$medActionType->pluck('name','id')->toArray(),0,['data-style'=>'btn-info', 'class'=> 'btn-primary selectpicker form-control','id'=>"deistv"]) }}</div>
                                <input type="button" class="btn btn-primary" id="add" onClick="add_destv(this)" value="Добавить" />
                            </div>
                        </div>
                        <div class="col-md-3">

                            
                            <input type="submit" class="btn btn-primary" name=""  id="submit_id" value="Сохранить" />
                        </div>
                    </div>
            </form>
        </div>
