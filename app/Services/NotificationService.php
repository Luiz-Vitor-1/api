<?php

namespace App\Services;

use App\Interfaces\PushNotificationInterface;
use App\Providers\OneSignalProvider;

class NotificationService
{
    protected PushNotificationInterface $pushNotificationProvider;

    public function __construct()
    {
       $this->pushNotificationProvider = new OneSignalProvider(); //Escolhido Serviço de notificação Onesignal
    }

    public function sendPushNotificationForAll(string $title, string $message, array $data = [])
    {
        $this->pushNotificationProvider->sendPushNotificationForAll($title, $message, $data);
    }

    public function sendPushNotificationInTime(string $title, string $message, array $playersId, array $data = [], string $dateToSend)
    {
        $this->pushNotificationProvider->sendPushNotificationInTime($title,  $message, $playersId, $data = [], $dateToSend);
    }

    public function sendPushNotificationToSegment(string $title, string $message, array $data = [])
    {
        $this->pushNotificationProvider->sendPushNotificationToSegment($title, $message, $data);
    }
}
