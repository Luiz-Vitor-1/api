<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Device_EventType;
use App\Models\EventType;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeviceController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function show(): mixed
    {
        try{
            $events = Device::where('id', '>', 0)->get();
            return response()->json($events);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage(),'errors'=> $th->getMessage()],500);
        }
    }

    public function showById(Request $request): mixed
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', 'integer', Rule::exists('devices')]
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Invalid input', 'errors' => $validator->errors()], 400);
            }

            $device_id = $request['id'];

            $device = Device::where('id', $request['id'])->first();
            $deviceEventTypes = Device_EventType::where('device_id', $device_id)->pluck('event_type_id');

            $response = [
                'id' => $device_id,
                'name' => $device->name,
                'notification_token' => $device->notification_token,
                'event_types' => $deviceEventTypes,
            ];

            return response()->json($response);
        }catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage(),'errors'=> $th->getMessage()],500);
        }
    }

    public function create(Request $request): mixed
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'notification_token' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Invalid input', 'errors' => $validator->errors()], 400);
            }

            $device = Device::create($request->only([
                'name',
                'notification_token'
            ]));

            $response = [
                "id" => $device->id,
                "name" => $device->name,
                "notification_token" => $device->notification_token,
                "event_types" => []
            ];

            return response()->json($response, 201);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage(),'errors'=> $th->getMessage()],500);
        }
    }

    public function update(Request $request): mixed
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required','integer', Rule::exists('devices')],
                'name' => 'sometimes|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Invalid input', 'errors' => $validator->errors()], 400);
            }

            $device = Device::find($request['id']);

            if (!$device) {
                return response()->json(['message' => 'Device not found'], 404);
            }

            $device->update($request->only([
                'name',
            ]));

            $deviceEventTypes = Device_EventType::where('device_id', $device->id)->pluck('event_type_id');

            $response = [
                "id" => $device->id,
                "name" => $device->name,
                "notification_token" => $device->notification_token,
                'event_types' => $deviceEventTypes,
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage(),'errors'=> $th->getMessage()],500);
        }
    }

    public function delete(Request $request): mixed
    {
        try {
            $event = Device::find($request['id']);

            if (!$event) {
                return response()->json(['message' => 'Device not found'], 404);
            }

            $event->delete();

            return response()->json(['message' => 'Device deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage(),'errors'=> $th->getMessage()],500);
        }
    }

    public function updateNotificationEventsPreferences(Request $request): mixed
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', 'integer', Rule::exists('devices')],
                'events_notification_preferences' => 'sometimes|array',
                'events_notification_preferences.*' => 'integer|exists:event_types,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Invalid input', 'errors' => $validator->errors()], 400);
            }

            $event = EventType::find($request['events_notification_preferences']);
            $device = Device::find($request['id']);

            if (!$event || !$device) {
                return response()->json(['message' => 'EventType or Device not found'], 404);
            }

            $device->eventTypes()->sync($request['events_notification_preferences']);

            foreach ($request['events_notification_preferences'] as $eventTypeId) {
                $device->eventTypes()->updateExistingPivot($eventTypeId, ['updated_at' => now()]);
            }

            return response()->json("Updated", 200);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage(),'errors'=> $th->getMessage()],500);
        }
    }

    public function notifyAllDevices(Request $request): mixed
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input'], 400);
        }

        $titleNotification = $request->input('title');
        $messageNotification = $request->input('content');

        $this->notificationService->sendPushNotificationForAll(
            $titleNotification,
            $messageNotification
        );

        return response()->json(['message' => 'Notification send for all'], 201);
    }
}
