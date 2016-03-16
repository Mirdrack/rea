<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\StationSensor;
use Rea\Transformers\StationSensorTransformer;
use Rea\Validators\UpdateStationSensorValidator; 

class StationSensorController extends ApiController
{
    protected $stationSensorTransformer;
    protected $updateStationSensorValidator;

    public function __construct(
        StationSensorTransformer $stationSensorTransformer,
        UpdateStationSensorValidator $updateStationSensorValidator 
        )
    {
        $this->stationSensorTransformer = $stationSensorTransformer;
        $this->updateStationSensorValidator = $updateStationSensorValidator;
    }

    public function index()
    {
        $stationSensors = StationSensor::all();

        if($stationSensors)
            return $this->respondOk($this->stationSensorTransformer->transformCollection($stationSensors));
        else
            $this->respondOk(null, 'No data available');
    }

    public function show($id)
    {
        $stationSensor = StationSensor::find($id);
        if(!$stationSensor)
        {
            return $this->respondNotFound('Station Sensor not found');
        }
        return $this->respondOk($this->stationSensorTransformer->transform($stationSensor));
    }

    public function update($id)
    {
        $stationSensor = StationSensor::find($id);

        if(!$stationSensor)
            return $this->respondNotFound('Station Sensor not found');
        else
        {
            $isValid = $this->updateStationSensorValidator->with(Input::all())->passes();
            if($isValid)
            {
                $stationSensor->fill(Input::all())->save();
                return $this->respondOk(null, 'Station Sensor updated');
            }
            else
            {
                return $this->respondUnprocessable('Invalid fields');
            }
        }
    }
}
