<?php

namespace App\Facades;


use App\Exceptions\ConfigException;
use App\Helpers\Whatsapp\Exceptions\RequestException;
use App\Helpers\Whatsapp\Models\MessageResponse;
use App\Helpers\Whatsapp\Whatsapp;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class Notify
{
    static function notifyTelegram($message)
    {
        try {
            $telegramToken = ConfigFacade::get('TELEGRAM_NOTIFICATIONS_BOT');
            $message = urlencode($message);
            $client = new Client();
            $res = $client->get("https://api.telegram.org/bot$telegramToken/sendMessage?chat_id=-1001283312401&text=$message", [
                'timeout' => 7
            ]);
        } catch (Exception $e) {
            \Log::alert("Notificaciones de depósitos por telegram falló. " . $e->getMessage());
        }
    }

    /**
     * @param $phone
     * @param $message
     * @return bool|string
     * @throw AwsException
     */
    static function sms($phone, $message)
    {
        $phone = str_replace(' ', '', $phone);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mensatek.com/v6/EnviarSMS");
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 6); //timeout in seconds
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'Correo=' .
            config('services.mensatek.email')
            . '&Passwd=' .
            config('services.mensatek.password')
            . '&Remitente=PagoActivo&Destinatarios=' . $phone .
            '&Mensaje=' . $message . '&Resp=JSON');
        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        $sub = curl_exec($ch);
        curl_close($ch);
        return $sub;

    }

    /**
     * @param $phone
     * @param $message
     * @return bool|string
     * @throw AwsException
     */
    static function whatsapp($phone, $message, $num = '')
    {
        $phone = trim($phone);
        $phone = str_replace('+', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $server = ConfigFacade::get('WHATSAPP_SERVER' . $num);

        $key = ConfigFacade::get('WHATSAPP_KEY' . $num);
        $token = ConfigFacade::get('WHATSAPP_TOKEN' . $num);


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $server . '/msgs',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 6,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "phone_token" => $token,
                "token" => $key,
                "body" => $message,
                "type" => "text",
                "to" => $phone,
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

    static function whatNotification($phone, $message, $levelNotification = 1)
    {
        try {
            $level = ConfigFacade::get('LEVEL_NOTIFICATIONS', 1);
            if ($level >= $levelNotification) {
                $phoneName = "certiactivo";
                return self::whatapi($phoneName, $phone, $message);
            }
        } catch (ConfigException $e) {
        }
        return false;
    }

    static function whatapiNameGroup($phoneName, $configName, $message)
    {
        try {
            $recipient = ConfigFacade::get($configName);
        } catch (Exception $e) {
            Log::error("Config no encontrada - PHONE_GROUP" . $e->getMessage());
            return false;
        }
        return self::whatapi($phoneName, $recipient, $message, true);
    }

    static function whatapiName($phoneName, $configName, $message)
    {
        try {
            $recipient = ConfigFacade::get($configName);
        } catch (Exception $e) {
            Log::error("Config no encontrada - PHONE_CLIENT" . $e->getMessage());
            return false;
        }
        return self::whatapi($phoneName, $recipient, $message);
    }

    /**
     * @param $phoneNameSender
     * @param $phone
     * @param $message
     * @return MessageResponse|bool
     */
    static function whatapi($phoneNameSender, $phone, $message, $isGroup = false)
    {
        try {
            $data = ConfigFacade::get('WHATAPI_CONFIG');
        } catch (Exception $e) {
            Log::error("Config no encontrada - WHATAPI_CONFIG" . $e->getMessage());
            return false;
        }
        $data = json_decode($data, 1);
        if ($data == null) {
            Log::error("Config no encontrada - WHATAPI_CONFIG");
            return false;
        }
        $wha = new Whatsapp($data['server'], $data['key']);

        try {
            $data = ConfigFacade::get('WHATAPI_PHONES');
        } catch (Exception $e) {
            Log::error("Config no encontrada - WHATAPI_PHONES");
            return false;
        }
        $data = json_decode($data, 1);
        if ($data == null) {
            //throw new Exception("Config no encontrada - WHATAPI_PHONES");
            Log::error("Config no encontrada - WHATAPI_PHONES");
            return false;
        }
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('+', '', $phone);
        try {
            if ($isGroup)
                return $wha->sendTextGroup($data[$phoneNameSender], $phone, $message);
            else
                return $wha->sendText($data[$phoneNameSender], $phone, $message);
        } catch (RequestException $e) {
            Log::error($e->getMessage());
            return false;
        }

    }
}
