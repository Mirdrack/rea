<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\Station;
use Rea\Entities\StationEvent;
use Rea\Transformers\StationEventTransformer;
use Rea\Validators\CreateStationEventValidator;

class StationEventController extends ApiController
{
    protected $stationEventTransformer;
    protected $createStationEventValidator;

    public function __construct(
        StationEventTransformer $stationEventTransformer,
        CreateStationEventValidator $createStationEventValidator)
    {
        $this->stationEventTransformer = $stationEventTransformer;
        $this->createStationEventValidator = $createStationEventValidator;
    }

    public function index()
    {
        $limit = Input::get('limit') ?: self::PAGE_LIMIT;
        $stationEvents = StationEvent::paginate($limit);

        if($stationEvents)
        {
            $data = array('station_events' => $this->stationEventTransformer->transformCollection($stationEvents));
            return $this->respondOkWithPagination($stationEvents, $data);
        }
        else
            $this->respondOk(null, 'No data available');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Input::all();
        $isValid = $this->createStationEventValidator->with($data)->passes();
        if($isValid)
        {
            $stationEvent = StationEvent::create($data);
            $station = Station::find($data['station_id']);
            
            if($data['event_type_id'] == 1)
                $station->status = true;
            
            if($data['event_type_id'] == 2)
                $station->status = false;

            if($data['event_type_id'] == 3)
                $station->alarm_activated = true;
            
            if($data['event_type_id'] == 4)
                $station->alarm_activated = false;
            
            $station->save();

            return $this->respondCreated(
                                    $this->stationEventTransformer->transform($stationEvent), 
                                    'Station Event '.$data['event_type_id'].' Created'
                                    );
        }
        else
            return $this->respondUnprocessable('Invalid fields');
    }
}
