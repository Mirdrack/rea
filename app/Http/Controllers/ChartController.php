<?php

namespace Rea\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;

use Rea\Entities\Read;
use DB;
use Rea\Transformers\ReadTransformer;
use Rea\Repositories\Chart;

class ChartController extends ApiController
{
    protected $readTransformer;
    protected $chartRepository;

    protected $chartStrokeWidth;
    protected $chartArea;
    protected $chartColor;

    public function __construct(
        ReadTransformer $readTransformer,
        Chart $chartRepository)
    {
        $this->readTransformer = $readTransformer;
        $this->chartRepository = $chartRepository;

        $this->chartStrokeWidth = 2;
        $this->chartArea = true;
        $this->chartColor = '#80cbc4';
    }

    public function dynamicLevelChart(Request $request)
    {
        $stationId = $request->input('station_id'); 
        $lapse = $request->input('lapse'); 
        $start = $request->input('start'); 
        $end = $request->input('end');

        $chart = $this->chartRepository->getDynamicLevelChartValues($stationId, $start, $end, $lapse);
        if($chart)
            return $this->respondOk($chart);
        else
           return $this->respondNotFound('No data available for the interval given.');
    }

    public function generate(Request $request)
    {
        $stationId = $request->input('station_id'); 
        $lapse = $request->input('lapse'); 
        $start = $request->input('start'); 
        $end = $request->input('end');
        $column = $request->input('column');

        switch ($column) 
        {
            case 'dynamic_level':
                $chart = $this->chartRepository->getDynamicLevelChartValues($stationId, $start, $end, $lapse);
                break;
            case 'voltage':
                $chart = $this->chartRepository->getVoltageChartValues($stationId, $start, $end, $lapse);
                break;
            case 'current':
                $chart = $this->chartRepository->getCurrentChartValues($stationId, $start, $end, $lapse);
                break;
            case 'power':
                $chart = $this->chartRepository->getPowerChartValues($stationId, $start, $end, $lapse);
                break;
            
            default:
                return $this->respondUnprocessable('Unknow Chart requested!');
                break;
        }

        if($chart)
            return $this->respondOk($chart);
        else
           return $this->respondNotFound('No data available for the interval given.');
    }

    
}
