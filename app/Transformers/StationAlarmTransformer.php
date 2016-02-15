<?php 
namespace Rea\Transformers;

class StationAlarmTransformer extends Transformer
{
    public function transform($object)
    {
        return [
            'id' => $object->id,
            'station_id' => $object->station_id,
            'created_at' => date('d-m-Y @ H:i:s', strtotime($object->created_at)),
        ];
    }
}