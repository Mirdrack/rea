<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\Station;
use Rea\Transformers\StationTransformer;

class StationController extends ApiController
{
    protected $stationTransformer;

    public function __construct(StationTransformer $stationTransformer)
    {
        $this->stationTransformer = $stationTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stations = Station::all()->lists('name', 'id');
        return $this->respondOk($this->stationTransformer->transformCollectionToList($stations));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $station = Station::with(
            array(
                'reads' => function($query) use ($id) 
                {
                    $query->where('station_id', '=', $id)
                           ->orderBy('id','desc')
                           ->limit(5);
                }
            )
        )
        ->where('id', '=', $id)
        ->first();

        if(!$station)
        {
            return $this->respondNotFound('Station not found');
        }
        return $this->respondOk($this->stationTransformer->transform($station));
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function turnOn(Request $request)
    {
        $id = $request->input('id');
        $station = Station::find($id);
        if(!$station)
            return $this->respondNotFound('Station not found.');
        else
        {
            $isValid = $station->turnOn();
            if($isValid)
                return $this->respondOk(null, 'Station turned on.');
            else
                return $this->respondUnprocessable('The station is on cool down.');
        }
    }

    public function turnOff(Request $request)
    {
        $id = $request->input('id');
        $station = Station::find($id);
        if(!$station)
            return $this->respondNotFound('Station not found.');
        else
        {
            $isValid = $station->turnOff();
            if($isValid)
                return $this->respondOk(null, 'Station turned off.');
            else
                return $this->respondWithError('Can not turn error.');
        }

    }
}
