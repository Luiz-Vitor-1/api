<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Device_EventType;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Models\Events;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class EventsController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function showAll(): mixed
    {
        try{
            $events = Events::with('eventType')->get();
            return response()->json($events);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage(),'errors'=> $th->getMessage()],500);
        }
    }

    public function showEventsByType(Request $request) : mixed
    {
        try{
            $typeEventId = $request->input('typeEventId');
            $eventsType = Events::with('eventType')->where('type_event_id', $typeEventId)->get();
            return response()->json($eventsType);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage(),'errors'=> $th->getMessage()],500);
        }
    }

    public function create(Request $request): mixed
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'subtitle' => 'required|string|max:255',
                'description' => 'required',
                'start_date' => 'required|string',
                'end_date' => 'required|string',
                'location' => 'required|string|max:255',
                'time' => 'required|string',
                'type_event_id' => 'sometimes|required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Invalid input', 'errors' => $validator->errors()], 400);
            }

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $event = Events::create([
                'title' => $request->input('title'),
                'subtitle' => $request->input('subtitle'),
                'description' => $request->input('description'),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'location' => $request->input('location'),
                'time' => $request->input('time'),
                'type_event_id' => $request->input('type_event_id'),
            ]);

            //Consulta para pegar todos os notification_token de todos os devices cujo o type_event_id seja o mesmo
            // do event_type_id do device_event_types
            $devices = Device_EventType::where('event_type_id', $request['type_event_id'])->get();

            $deviceIds = $devices->pluck('device_id');  // Pega todos os device_ids da coleção

            $notificationTokens = Device::whereIn('id', $deviceIds)->pluck('notification_token');
            if(empty($notificationTokens)){
                $titleNofitication = 'Atenção!';
                $messageNotification = 'O evento '.$request['title'].' está próximo';
                $playersId = $notificationTokens->toArray();
                $array=[];

                $startDate = Carbon::parse($request['start_date']);
                $dateToSend = 1; // 1 dia antes do evento
                $adjustedDate = Carbon::today()->addDays($dateToSend);
                $diffInDays = $adjustedDate->diffInDays($startDate);

                $this->notificationService->sendPushNotificationInTime(
                    $titleNofitication,
                    $messageNotification,
                    $playersId,
                    $array,
                    $diffInDays
                );
            }
            return response()->json($event, 201);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage(),'errors'=> $th->getMessage()],500);
        }
    }

    public function update(Request $request): mixed
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required','integer', Rule::exists('events')],
                'title' => 'sometimes|string|max:255',
                'subtitle' => 'sometimes|string|max:255',
                'description' => 'sometimes',
                'start_date' => 'sometimes|date',
                'end_date' => 'sometimes|date',
                'location' => 'sometimes|string|max:255',
                'time' => 'string',
                'type_event_id' => 'sometimes|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Invalid input', 'errors' => $validator->errors()], 400);
            }

            $event = Events::find($request['id']);

            if (!$event) {
                return response()->json(['message' => 'Event not found'], 404);
            }

            $event->update($request->only([
                'title',
                'subtitle',
                'description',
                'start_date',
                'end_date',
                'location',
                'time',
                'type_event_id'
            ]));

            return response()->json($event, 200);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage(),'errors'=> $th->getMessage()],500);
        }
    }

    public function delete(Request $request): mixed
    {
        try {
            $event = Events::find($request['id']);

            if (!$event) {
                return response()->json(['message' => 'Event not found'], 404);
            }

            $event->delete();

            return response()->json(['message' => 'Event deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage(),'errors'=> $th->getMessage()],500);
        }
    }
}
