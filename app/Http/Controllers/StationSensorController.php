<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\StationSensor;
use Rea\Transformers\StationSensorTransformer;

class StationSensorController extends ApiController
{
    protected $stationSensorTransformer;

    public function __construct(StationSensorTransformer $stationSensorTransformer)
    {
        $this->stationSensorTransformer = $stationSensorTransformer;
    }

    public function index()
    {
        $stationSensors = StationSensor::all();

        if($stationSensors)
            return $this->respondOk($this->stationSensorTransformer->transformCollection($stationSensors));
        else
            $this->respondOk(null, 'No data available');
    }
}
