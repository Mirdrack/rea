<?php 
namespace Rea\Transformers;

/**
* 
*/
class StationTransformer extends Transformer
{
	public function transform($object)
    {
        return [
            'id' => $object->id,
            'name' => $object->name,
            'created_at' => date('d-m-Y @ H:i:s', strtotime($object->created_at)),
            'reads' => $object->reads->toArray(),
        ];
    }
}