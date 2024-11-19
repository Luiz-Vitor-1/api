<?php

namespace App\Providers;

use DateTime;
use onesignal\client\api\DefaultApi;
use onesignal\client\Configuration;
use onesignal\client\model\Notification;
use onesignal\client\model\StringMap;
use GuzzleHttp;
use App\Interfaces\PushNotificationInterface;

class OneSignalProvider implements PushNotificationInterface
{
    private string $appKeyToken;
    private string $userKeyToken;
    private string $appId;
    private $apiInstance;

    public function __construct()
    {
        $this->appKeyToken = env('ONESIGNAL_APP_KEY_TOKEN');
        $this->userKeyToken = env('ONESIGNAL_USER_KEY_TOKEN');
        $this->appId = env('ONESIGNAL_APP_ID');

        // Configuração única para o cliente da API do OneSignal
        $config = Configuration::getDefaultConfiguration()
            ->setAppKeyToken($this->appKeyToken)
            ->setUserKeyToken($this->userKeyToken);

        $clientOptions = [
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false, // Desabilita a verificação de certificado SSL
            ]
        ];

        $this->apiInstance = new DefaultApi(new GuzzleHttp\Client($clientOptions), $config);
    }

    private function createNotification(string $title, string $message): Notification
    {
        $content = new StringMap();
        $content->setEn($message); // Mensagem da notificação

        $notification = new Notification();
        $notification->setAppId($this->appId);
        $notification->setContents($content);
        $notification->setIncludedSegments(['Subscribed Users']);
        $notification->setHeadings(['en' => $title]); // Título da notificação

        return $notification;
    }

    public function sendPushNotificationForAll(string $title, string $message, array $data = [])
    {
        $notification = $this->createNotification($title, $message);
        $result = $this->apiInstance->createNotification($notification);
        print_r($result);
    }

    public function sendPushNotificationInTime(string $title, string $message, array $playersId, array $data = [], string $dateToSend)
    {
        // Calcula a data e hora para o envio
        $dt = new DateTime();
        $dt->modify('+' . $dateToSend . ' day'); // Usa o valor de $dateToSend para calcular o envio

        $notification = $this->createNotification($title, $message);
        $notification->setSendAfter($dt); // Define o envio programado

        // Envia a notificação
        $scheduledNotification = $this->apiInstance->createNotification($notification);
        print_r($scheduledNotification);
    }

    public function sendPushNotificationToSegment(string $title, string $message, string $segmentId, array $data = [])
    {
        // A implementação do envio para segmento deve ser feita conforme o segmento
        $notification = $this->createNotification($title, $message);
        $notification->setIncludedSegments([$segmentId]); // Inclui o segmento na notificação

        $result = $this->apiInstance->createNotification($notification);
        print_r($result);
    }
}
