<?php 
namespace Rea\Transformers;

/**
* 
*/
class ReadTransformer extends Transformer
{
    public function transform($object)
    {
        return [
            'id' => $object->id,
            'station_id' => $object->station_id,
            'dynamic_level' => $object->dynamic_level,
            'voltage' => $object->voltage,
            'current' => $object->current,
            'power' => $object->power,
            'created_at' => date('d-m-Y @ H:i:s', strtotime($object->created_at)),
        ];
    }
}