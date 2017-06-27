<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Sms;

class SmsController extends Controller
{
    //


    public function send()
    {
        $phone = Sms::parserPhone($_POST['phone']);
        $text=htmlspecialchars($_POST['text']);
        $result = Sms::sendSms($phone,$text);
        $sms = new Sms();
        $sms->worker_id=$_POST['idworker'];
        $sms->phone=$phone;
        $sms->text=$text;
        $sms->ext_sms_id = $result->sms_id;
        $sms->save();
        if ($result->status == "OK") { // Запрос выполнен успешно
            echo "Сообщение отправлено успешно. ";
            echo "ID сообщения: $result->sms_id.";
        } else {
            echo "Сообщение не отправлено. ";
            echo "Код ошибки: $result->status_code. ";
            echo "Текст ошибки: $result->status_text.";
        }
       

    }
}
