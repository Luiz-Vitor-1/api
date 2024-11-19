<?php

namespace App\Interfaces;

interface PushNotificationInterface
{
    public function sendPushNotificationForAll(string $title, string $message, array $data = []);

    public function sendPushNotificationInTime(string $title, string $message, array $playersId, array $data = [], string $dateToSend);

    public function sendPushNotificationToSegment(string $title, string $message, string $segmentId, array $data = []);
}


