<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;
use Illuminate\Support\Facades\Validator;

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
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input'], 400);
        }

        $name = $request->input('name');

        EventType::create([
            'name' => $name,
        ]);

        return response()->json(['message' => 'Event type created'], 201);
    }
}
