<?php

namespace Rea\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\Station;
use Rea\Entities\StationEvent;
use Rea\Entities\StationSensor;
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
            {
                $station->status = true;
                $station->save();

                // Mailing
                Mail::send('emails.turn-on', ['station' => $station], function ($m) use ($station) 
                {
                    $m->from('hello@app.com', 'System Mail');
                    $m->to('soporte@aitanastudios.com')->subject('Turn On!');
                });
            }
            
            if($data['event_type_id'] == 2)
            {
                $station->status = false;
                $station->save();
            }

            if($data['event_type_id'] == 3)
            {
                $sensor = StationSensor::where('station_id', $data['station_id'])
                                ->where('name', 'Maya')
                                ->first();
                $sensor->alarm_activated = true;
                $sensor->alarm_cooldown = 0;
                $sensor->save();
            }
            
            if($data['event_type_id'] == 4)
            {
                $sensor = StationSensor::where('station_id', $data['station_id'])
                                ->where('name', 'Maya')
                                ->first();
                $sensor->alarm_activated = false;
                $sensor->alarm_cooldown = $data['alarm_cooldown'];
                $sensor->save();
            }

            return $this->respondCreated(
                                    $this->stationEventTransformer->transform($stationEvent), 
                                    'Station Event '.$data['event_type_id'].' Created'
                                    );
        }
        else
            return $this->respondUnprocessable('Invalid fields');
    }
}
