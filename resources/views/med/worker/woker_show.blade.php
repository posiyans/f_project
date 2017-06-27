@extends('layouts.app')
@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<script src="/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="/js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="/js/plugins/purify.min.js" type="text/javascript"></script>
<script src="/js/fileinput.min.js"></script>

<script src="/themes/fa/theme.js"></script>
<script src="/js/locales/ru.js"></script>
<script type= "text/javascript" >

function Sendsms(id_worker){
var url='{{ route('SmsSend') }}';
var phone=$('#phone').val();
var textsms=$('#textsms').val();
//alert(phone+' '+textsms);
var data='idworker='+id_worker+'&phone='+phone+'&text='+textsms;
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
      $("#smsres").html(data);
      setTimeout(function(){window.location.reload();},2000);
    }
});

}
function showMany(){

    $('.maney').slideToggle('fast');    
 

}
</script>

  <div class="container-fluid  well">
      <div class="row">
            <div class="col-md-7">
                 @include('med.worker.cart_show')
            </div>
            <div class="col-md-5">
                @include('med.worker.right_form_cart')
            </div>
      </div>
   </div>   
   <div class="container-fluid  well">
        <div class="row">
            @include('med.worker.creat_complaint')
        </div>
      
    </div> 
    <div class="container-fluid  well">
        <div class="row">
                <div class="">
                    @include('med.worker.complaints_action')
                </div>
        </div>
      
    </div> 

@endsection


