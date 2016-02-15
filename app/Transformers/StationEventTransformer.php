<?php 
namespace Rea\Transformers;

/**
* 
*/
class StationEventTransformer extends Transformer
{
    public function transform($object)
    {
        return [
            'id' => $object->id,
            'user_id' => $object->user_id,
            'station_id' => $object->station_id,
            'event_type_id' => $object->event_type_id,
            'ip_address' => $object->ip_address,
            'created_at' => date('d-m-Y @ H:i:s', strtotime($object->created_at)),
        ];
    }
}