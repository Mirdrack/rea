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

    public function transformCollectionToList($collection)
    {
    	$transformedCollection = array();
		foreach ($collection as $key => $value)
		{
			$element = array();
			$element['id'] = $key;
			$element['name'] = $value;
			$clonedElement = $element; // This needs to be done cause array_push add by reference
			array_push($transformedCollection, $clonedElement);
		}
		return $transformedCollection;
    }
}