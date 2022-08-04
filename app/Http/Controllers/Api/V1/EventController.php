<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\SendMail;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateOrCreateEventRequest;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Event as EventFire;
class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $cacheEvents = Redis::get('events');
        if(isset($cacheEvents)) {
            $events = json_decode($cacheEvents, FALSE);
        }else {
            $events = $this->getAll();
            Redis::set('events', $events);
        }
        return response()->json(['ok' => true, 'data' => $events]);
    }

    public function getActiveEvents()
    {
        $events = Event::whereRaw('(now() between start_at and end_at)')->get();
        return response()->json(['ok' => true, 'data' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getAll()
    {
        return Event::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEventRequest $request
     * @return JsonResponse
     */
    public function store(StoreEventRequest $request): JsonResponse
    {

        $event = new Event();
        $event->name = $request->name;
        $event->start_at = $request->start_at ?? now();
        $event->end_at = $request->end_at ?? now();
        $event->slug = Str::slug($request->slug ?? $request->name);
        if($event->save()){
            Redis::del('events');
            $events = $this->getAll();
            Redis::set('events', $events);
        }
        event(new SendMail(auth()->id()));
        return response()->json(['ok' => true, 'data' => $event]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $event = Event::find($id);
        return response()->json(['ok' => true, 'data' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(UpdateOrCreateEventRequest $request, $id)
    {
        $event = Event::find($id);
        if(!$event){
            $event = new Event();
        }
        $event->name = $request->name;
        $event->start_at = $request->start_at ?? now();
        $event->end_at = $request->end_at ?? now();
        $event->slug = Str::slug($request->slug ?? $request->name);
        if($event->save()){
            Redis::del('events');
            $events = $this->getAll();
            Redis::set('events', $events);
        }

        return response()->json(['ok' => true, 'data' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrCreateEventRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateEvent(UpdateOrCreateEventRequest $request, $id): JsonResponse
    {
        $event = Event::find($id);
        $event->name = $request->name;
        $event->start_at = $request->start_at ?? now();
        $event->end_at = $request->end_at ?? now();
        $event->slug = Str::slug($request->slug ?? $request->name);
        if($event->save()){
            Redis::del('events');
            $events = $this->getAll();
            Redis::set('events', $events);
        }
        return response()->json(['ok' => true, 'data' => $event]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(Event $event)
    {
        if($event->delete()){
            // Delete blog_$id from Redis
            Redis::del('events');
            $events = $this->getAll();
            Redis::set('events', $events);
        }

        return response()->json(['ok' => true, 'message' => 'Event deleted']);
    }
}
