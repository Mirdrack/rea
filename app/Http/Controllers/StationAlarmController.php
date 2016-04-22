<?php

namespace Rea\Http\Controllers;

use Log;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Rea\Http\Requests;
use Rea\Http\Controllers\Controller;
use Rea\Entities\StationAlarm;
use Rea\Entities\StationSensor;
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

            if($data['alarm_type_id'] == 1)
            {
                $sensor = StationSensor::where('station_id', $data['station_id'])
                                ->where('name', 'Maya')
                                ->first();
            }
            if($data['alarm_type_id'] == 2)
            {
                $sensor = StationSensor::where('station_id', $data['station_id'])
                                ->where('name', 'Electra')
                                ->first();
            }
            if($data['alarm_type_id'] == 3)
            {
                $sensor = StationSensor::where('station_id', $data['station_id'])
                                ->where('name', 'Hestia')
                                ->first();
            }
            if($data['alarm_type_id'] == 4)
            {
                $sensor = StationSensor::where('station_id', $data['station_id'])
                                ->where('name', 'Aretusa')
                                ->first();
            }

            Mail::send('emails.alarm', ['sensor' => $sensor], function ($m) use ($sensor) 
            {
                $m->from('aitanastudios@gmail.com', 'Sistema de Monitoreo');
                foreach (explode(',', $sensor->notification_emails) as $email)
                {
                    $m->to(trim($email))->subject($sensor->notification_subject);
                }
            });

            // Sending WhatsApp Messages
            foreach (explode(',', $sensor->notification_phones) as $phone)
            {
                try {

                    $message = urlencode($sensor->notification_text);
                    $cmd = 'curl "https://rest.nexmo.com/sms/json?api_key=fafb755e&api_secret=03839dee49047354&from=MONITOREO&to=52'.trim($phone).'&text='.$message.'"';

                    Log::info($cmd);
                    shell_exec($cmd);

                    } catch (Exception $e) {

                    $this->respondWithError('Failed to send whatsapp notification.');
                }
            }


            return $this->respondCreated(
                                    $this->stationAlarmTransformer->transform($stationAlarm), 
                                    'Alarm '.$data['alarm_type_id'].' Created'
                                    );
        }
        else
            return $this->respondUnprocessable('Invalid fields');
    }
}
