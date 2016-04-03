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
            'id' => (int) $object->id,
            'user_id' => (int) $object->user_id,
            'station_id' => (int) $object->station_id,
            'event_type_id' => (int) $object->event_type_id,
            'ip_address' => $object->ip_address,
            'created_at' => date('d-m-Y @ H:i:s', strtotime($object->created_at)),
            'user' => [
                'id' => (int) $object->user->id,
                'name' => $object->user->name,
            ],
            'station' => [
                'id' => (int) $object->station->id,
                'name' => $object->station->name,
            ],
            'event_type' => [
                'id' => (int) $object->event_type->id,
                'label' => $object->event_type->label,
            ],
        ];
    }
}