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
            'id' => (int) $object->id,
            'station_id' => (int) $object->station_id,
            'dynamic_level' => (float) $object->dynamic_level,
            'voltage' => (float) $object->voltage,
            'current' => (float) $object->current,
            'power' => (float) $object->power,
            'created_at' => date('d-m-Y @ H:i:s', strtotime($object->created_at)),
        ];
    }
}