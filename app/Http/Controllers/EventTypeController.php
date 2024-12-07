<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;
use Illuminate\Support\Facades\Validator;
use App\Models\Events;

class EventTypeController extends Controller
{
    public function showAll(): mixed
    {
        $eventsType = EventType::all();
        return response()->json($eventsType);
    }

    public function create(Request $request): mixed
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input'], 400);
        }

        $name = $request->input('name');
        $image = $request->input('image');

        EventType::create([
            'name' => $name,
            'image' => $image
        ]);

        return response()->json(['message' => 'Event type created'], 201);
    }

    public function delete(Request $request): mixed
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input'], 400);
        }

        $id = $request->input('id');

        $eventType = EventType::find($id);

        if (!$eventType) {
            return response()->json(['message' => 'Event type not found'], 404);
        }

        $events = Events::where('type_event_id', $id)->get();
        foreach ($events as $event) {
            $event->delete();
        }

        $eventType->delete();

        return response()->json(['message' => 'Event type deleted'], 201);
    }
}
