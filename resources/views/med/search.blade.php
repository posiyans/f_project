@extends('layouts.app')

@section('content')
<script type= "text/javascript" >

function find(f=''){
var url='{{ route('WorkerSearch') }}';
if ( f == '') {
    $("#results").html('');
}else{
var data='find='+f.value;
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
      //alert (data);
      $("#results").html(data);
    }
});
}
//alert ('ii');

}


</script> 
  </head>
  <body>
   <div class="container well">
      Поиск сорудника:
      <div class="input-group">
          <span class="input-group-addon" id="basic-addon1" onClick="document.getElementById('find_imput').value = '';find();">X</span>
          <input type='text' id="find_imput" class="form-control"  placeholder="Иванов Иван Иванович" onkeyup="find(this)">
      </div>
    </div>
    <div id="results">
    </div>
@endsection

