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
            'created_at' =>  $object->created_at->format('d-m-Y @ H:i:s'),
            'reads' => $object->reads->toArray(),
        ];
    }
}