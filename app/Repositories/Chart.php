<?php 
namespace Rea\Repositories;

use Rea\Entities\Read;
use DB;
use Rea\Transformers\ReadTransformer;

class Chart {

	protected $chartStrokeWidth;
    protected $chartArea;
    protected $chartColor;

    protected $querySelect;
    protected $queryGroupBy;

	public function __construct(
        ReadTransformer $readTransformer)
    {
    	$this->readTransformer = $readTransformer;

        $this->chartStrokeWidth = 2;
        $this->chartArea = true;
        $this->chartColor = '#80cbc4';
    }

    public function getDynamicLevelChartValues($stationId, $start, $end, $lapse)
    {
		$this->setQuery($lapse, 'dynamic_level');
		$reads = $this->exeQuery($stationId, $start, $end);

		if($reads)
        {
            $chart = array();
            $chart['values'] = $this->readTransformer->transformChartValues($reads, $lapse, 'dynamic_level');
            $chart['key'] = 'Dynamic Level';
            $chart['strokeWidth'] = $this->chartStrokeWidth;
            $chart['area'] = $this->chartArea;
            $chart['color'] = $this->chartColor;
            return $chart;
        }
        else
            return null;
    }

    public function getVoltageChartValues($stationId, $start, $end, $lapse)
    {
    	$this->setQuery($lapse, 'voltage');
		$reads = $this->exeQuery($stationId, $start, $end);

		if($reads)
        {
            $chart = array();
            $chart['values'] = $this->readTransformer->transformChartValues($reads, $lapse, 'voltage');
            $chart['key'] = 'Voltage';
            $chart['strokeWidth'] = $this->chartStrokeWidth;
            $chart['area'] = $this->chartArea;
            $chart['color'] = $this->chartColor;
            return $chart;
        }
        else
            return null;
    }

    public function getCurrentChartValues($stationId, $start, $end, $lapse)
    {
    	$this->setQuery($lapse, 'current');
		$reads = $this->exeQuery($stationId, $start, $end);

		if($reads)
        {
            $chart = array();
            $chart['values'] = $this->readTransformer->transformChartValues($reads, $lapse, 'current');
            $chart['key'] = 'Current';
            $chart['strokeWidth'] = $this->chartStrokeWidth;
            $chart['area'] = $this->chartArea;
            $chart['color'] = $this->chartColor;
            return $chart;
        }
        else
            return null;
    }

    public function getPowerChartValues($stationId, $start, $end, $lapse)
    {
    	$this->setQuery($lapse, 'power');
		$reads = $this->exeQuery($stationId, $start, $end);

		if($reads)
        {
            $chart = array();
            $chart['values'] = $this->readTransformer->transformChartValues($reads, $lapse, 'power');
            $chart['key'] = 'Power';
            $chart['strokeWidth'] = $this->chartStrokeWidth;
            $chart['area'] = $this->chartArea;
            $chart['color'] = $this->chartColor;
            return $chart;
        }
        else
            return null;
    }

    protected function setQuery($lapse, $column)
    {
    	if($lapse == 'day')
    	{
    		if(env('APP_ENV') == 'testing')
            	$rawSelect = DB::raw('strftime("%H", created_at) AS hour, AVG('.$column.') AS '.$column.' '); // Test env
	        else
	            $rawSelect = DB::raw('HOUR(created_at) AS hour, AVG('.$column.') AS '.$column.' '); // Others env

	        $groupBy = 'hour';
    	}
    	if($lapse == 'month')
    	{
    		if(env('APP_ENV') == 'testing')
            	$rawSelect = DB::raw('strftime("%d", created_at) AS day, AVG(dynamic_level) AS dynamic_level'); // Test env
	        else
	            $rawSelect = DB::raw('DAY(created_at) AS day, AVG(dynamic_level) AS dynamic_level'); // Others env

	        $groupBy = 'day';
    	}
    	if($lapse == 'year')
    	{
    		if(env('APP_ENV') == 'testing')
            	$rawSelect = DB::raw('strftime("%m", created_at) AS month, AVG(dynamic_level) AS dynamic_level'); // Test env
	        else
	            $rawSelect = DB::raw('MONTH(created_at) AS month, AVG(dynamic_level) AS dynamic_level'); // Others env

	        $groupBy = 'month';
    	}

    	$this->querySelect = $rawSelect;
    	$this->queryGroupBy = $groupBy;
    }

    protected function exeQuery($stationId, $start, $end)
    {
		$reads = DB::table('station_reads')
                    ->select($this->querySelect)
                    ->where('station_id', $stationId)
                    ->where('created_at', '>', $start.' 00:00:00')
                    ->where('created_at', '<', $end.' 23:59:59')
                    ->groupBy($this->queryGroupBy)
                    ->get();
        return $reads;
    }
}