<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\StationAlarm;
use Rea\Transformers\StationAlarmTransformer;
use Rea\Validators\CreateStationAlarmValidator;

class StationAlarmController extends ApiController
{
    protected $stationAlarmTransformer;
    protected $createStationAlarmValidator;

    public function __construct(
        StationAlarmTransformer $stationAlarmTransformer,
        CreateStationAlarmValidator $createStationAlarmValidator)
    {
        $this->stationAlarmTransformer = $stationAlarmTransformer;
        $this->createStationAlarmValidator = $createStationAlarmValidator;
    }

    public function index()
    {
        $limit = Input::get('limit') ?: self::PAGE_LIMIT;
        $stationAlarms = StationAlarm::paginate($limit);

        if($stationAlarms)
        {
            $data = array('station_alarms' => $this->stationAlarmTransformer->transformCollection($stationAlarms));
            return $this->respondOkWithPagination($stationAlarms, $data);
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
        $isValid = $this->createStationAlarmValidator->with($data)->passes();
        if($isValid)
        {
            $stationAlarm = StationAlarm::create($data);
            return $this->respondCreated(
                                    $this->stationAlarmTransformer->transform($stationAlarm), 
                                    'Alarm '.$data['alarm_type_id'].' Created'
                                    );
        }
        else
            return $this->respondUnprocessable('Invalid fields');
    }
}
