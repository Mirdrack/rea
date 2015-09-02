<?php 
namespace Rea\Transformers;

/**
* 
*/
class UserTransformer extends Transformer
{
	public function transform($object)
    {
        return [
            'id' => $object['id'],
            'name' => $object['name'],
            'email' => $object['email'],
            'created_at' => date('d-m-Y @ H:i:s', strtotime($object['created_at']))
        ];
    }
}