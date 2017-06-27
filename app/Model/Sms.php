<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Ext\Smsru;

class Sms extends Model
{
//


    protected static $apikey = '';
    function __construct()
    {
        static::$apikey=env('SMS_API_KEY');
    }

    public static function getBalans()
    {
        $balance=null;
        $smsru = new Smsru(self::$apikey); // Ваш уникальный программный ключ, который можно получить на главной странице
        $request = $smsru->getBalance();
        if ($request->status == "OK") { // Запрос выполнен успешно
            $balance=$request->balance;
        }
        return $balance;
    }

    public static function parserPhone($string)
    {
        $string = preg_replace("([^0-9])", "", $string);
        if (substr($string, 0, 1)==9) {
            $string="7".$string;
        }
        if (substr($string, 0, 1)==8) {
            $string="7".substr($string, 1);
        }
        $string=substr($string, 0, 11);
        return $string;
    }


    public static function getWokerSms($woker_id)
    {

        $sms = Sms::where('worker_id', $woker_id)->orderBy('created_at', 'asc')->get();
        $smsru = new Smsru(static::$apikey);
        $data='';
        $idsms = [];
        $codesms = [];
        foreach ($sms as $item) {
            if (!isset($item->status) && ($item->ext_sms_id!='')) {
                $data.=$item->ext_sms_id.",";
                //dump($item->ext_sms_id);
            }
        }
      
        
        if (isset($data)) {
            $data=substr($data, 0, -1);
         
            $request = $smsru->getStatus($data);
            if ($request->status == "OK") { // Запрос выполнен успешно
                //dump ($request);
                foreach ($request->sms as $sms_id => $data) { // Перебираем массив сообщений
                    if ($data->status == "OK") { // Статус сообщения получен
                        $idsms[$sms_id]= $data->status_text."(".$data->status_code.")";
                        $codesms[$sms_id]=$data->status_code;
                    }
                }
            }
            
            foreach ($sms as $item) {
                if (!isset($item->status) && ($item->ext_sms_id!='') && ($item->ext_sms_id!='000000-10000000')) {
                    //dump($idsms);
                    //dump($item->ext_sms_id);
                    $item->status=$idsms[$item->ext_sms_id];
                    if ($codesms[$item->ext_sms_id]>102) {
                        $item->save();
                    }
                }
            }
        }
        return $sms;
    }
    public static function sendSms($phone,$text)
    {
        $apikey=env('SMS_API_KEY');
        $smsru = new Smsru($apikey); // Ваш уникальный программный ключ, который можно получить на главной странице
        //return $smsru;
        // dump($smsru);
        $data = new \stdClass();
        $data->to = $phone;
        $data->text = $text; // Текст сообщения
        if (!env('SMS_API_ENABLE'))
        {
            $data->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
        }
        $data->partner_id = '2316'; // Можно указать ваш ID партнера, если вы интегрируете код в чужую систему
        $sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную
        // dump($sms);
        return $sms;
        /*
        if ($sms->status == "OK") { // Запрос выполнен успешно
            echo "Сообщение отправлено успешно. ";
            echo "ID сообщения: $sms->sms_id.";
        } else {
            echo "Сообщение не отправлено. ";
            echo "Код ошибки: $sms->status_code. ";
            echo "Текст ошибки: $sms->status_text.";
        }
        */
    }
}
