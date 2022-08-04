<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $query = Event::query();
        $query->when($request->q, function($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->q . '%');
        });
        $events = $query->orderBy('created_at', 'DESC')->paginate(2);
        return view('events', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        $event = new Event();
        $event->name = $request->name;
        $event->slug = Str::slug($request->slug ?? $request->name);
        $event->start_at = $request->start_at;
        $event->end_at = $request->end_at;
        $event->save();
        return redirect()->route('events.index')->with('success','Event has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('show',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cacheEvents = Redis::get('event_'.$id);
        if(isset($cacheEvents)) {
            $event = json_decode($cacheEvents, FALSE);
        }else {
            $event = Event::find($id);
            Redis::set('event_' . $id, $event);
        }
        return view('edit',compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $event->name = $request->name;
        $event->slug = Str::slug($request->slug ?? $request->name);
        $event->start_at = $request->start_at;
        $event->end_at = $request->end_at;
        if($event->save()){
            Redis::del('event_' . $event->id);

            Redis::set('event_' . $event->id, $event);
        }
        return redirect()->route('events.index')->with('success','Event Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        Redis::del('event_' . $event->id);
        return redirect()->route('events.index')->with('success','Event has been deleted successfully');
    }
}
