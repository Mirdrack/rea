<?php 
namespace Rea\Transformers;

/**
* 
*/
class RoleTransformer extends Transformer
{
	public function transform($object)
    {
        return [
            'id' => $object['id'],
            'name' => $object['name'],
            'label' => $object['label'],
            'created_at' => date('d-m-Y @ H:i:s', strtotime($object['created_at']))
        ];
    }
}