<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Trip;
use Carbon\Carbon;

class FlaggedController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $businesses = User::whereIn('userType', ['business', 'branch'])->get();
        // $configs = Config::all();
        // Get flagged trips
        $flaggedTrips = Trip::where(['tripRequest' => 'approved', 'flag' => 1])->whereMonth('created_at', Carbon::now()->month)->with('user', 'driver')->get();
        return view('flagged.index', compact('flaggedTrips'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'basefare'=>'required',
        //     'perkm'=>'required',
        //     'permin'=>'required',
        //     'unique_code'=>'required',
        // ]);

        // $formInput = $request->all();

        // Config::create($formInput);

        //  return redirect()->back()->with('message','Payment Settings added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $trip = Trip::where('id', $id)->first();

        return view('flagged.edit', compact('trip'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $trip = Trip::where('id', $id)->first();

        $trip->tripAmt = $request->trip_cost;
        $trip->travelTime = $request->trip_time;
        $trip->tripDist = $request->trip_distance;
        $trip->pickUpAddress = $request->pickup;
        $trip->destAddress = $request->destination;
        $trip->save();

        return redirect()->back()->with('message','Trip updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Unflag Trip
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unflagTrip(Request $request, $id)
    {
        $trip = Trip::where('id', $id)->first();
        $trip->flag = 0;
        $trip->save();
        return redirect()->back()->with('message','Trip unflagged successfully');
        //
        // $this->validate($request,[
        //     'basefare'=>'required',
        //     'perkm'=>'required',
        //     'permin'=>'required',
        //     'unique_code'=>'required',
        // ]);

        // $formInput = $request->all();

        // Config::create($formInput);

        //  return redirect()->back()->with('message','Payment Settings added successfully');
    }
}
