<?php 
namespace Rea\Transformers;

use Rea\Transformers\ReadTransformer;

class StationAlarmTransformer extends Transformer
{
    public function transform($object)
    {
        return [
            'id' => $object->id,
            'station_id' => $object->station_id,
            'alarm_type_id' => $object->alarm_type_id,
            'created_at' => date('d-m-Y @ H:i:s', strtotime($object->created_at)),
            'station' => [
            	'id' => $object->station->id,
            	'name' => $object->station->name,
            ],
            'alarm_type' => [
            	'id' => $object->alarm_type->id,
            	'label' => $object->alarm_type->label,
            ],
        ];
    }
}