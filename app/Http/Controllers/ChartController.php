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

use Maatwebsite\Excel\Facades\Excel;

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

    public function generateXls($stationId, $start, $end, $lapse)
    {
        $tables = array();

        $tables['dynamic_level'] = $this->chartRepository
                                        ->getDynamicLevelValues($stationId, $start, $end, $lapse);

        $tables['voltage'] = $this->chartRepository
                                  ->getVoltageValues($stationId, $start, $end, $lapse);

        $tables['current'] = $this->chartRepository
                                  ->getCurrentValues($stationId, $start, $end, $lapse);

        $tables['power'] = $this->chartRepository
                                ->getPowerValues($stationId, $start, $end, $lapse);
        

        Excel::create('Station Report', function($excel) use ($tables)
        {
            $excel->sheet('Dynamic Level', function($sheet) use ($tables)
            {
                $sheet->fromArray($tables['dynamic_level']['values']);
            });

            $excel->sheet('Voltage', function($sheet) use ($tables)
            {
                $sheet->fromArray($tables['voltage']['values']);
            });

            $excel->sheet('Current', function($sheet) use ($tables)
            {
                $sheet->fromArray($tables['current']['values']);
            });

            $excel->sheet('Power', function($sheet) use ($tables)
            {
                $sheet->fromArray($tables['power']['values']);
            });
        })->export('xls');
    }
}
