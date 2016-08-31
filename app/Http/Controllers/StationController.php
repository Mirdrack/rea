<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\Station;
use Rea\Transformers\StationTransformer;
use Rea\Validators\UpdateStationValidator;

class StationController extends ApiController
{
    protected $stationTransformer;
    protected $updateStationValidator;

    public function __construct(
        StationTransformer $stationTransformer,
        UpdateStationValidator $updateStationValidator)
    {
        $this->stationTransformer = $stationTransformer;
        $this->updateStationValidator = $updateStationValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stations = Station::with(
            array(
                'reads' => function($query)
                {
                    $query->orderBy('id', 'desc')
                           ->limit(5);
                }
            )
        )
        ->where('id', '>', 0)
        ->get();
        $this->stationTransformer->transformCollection($stations);
        return $this->respondOk($this->stationTransformer->transformCollection($stations));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $station = Station::find($id);
        if(!$station)
            return $this->respondNotFound('Station not found');
        else
        {
            $isValid = $this->updateStationValidator->with(Input::all())->passes();
            if($isValid)
            {
                $station->fill(Input::all())->save();
                return $this->respondOk(null, 'Station updated');
            }
            else
            {
                return $this->respondUnprocessable('Invalid fields');
            }
        }
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

    public function basicList()
    {
        $stations = Station::all()->lists('name', 'id');
        return $this->respondOk($this->stationTransformer->transformCollectionToList($stations));
    }
}
