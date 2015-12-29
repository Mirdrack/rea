<?php 
namespace Rea\Transformers;

use Rea\Transformers\ReadTransformer;

/**
* 
*/
class StationTransformer extends Transformer
{
    protected $readTransformer;

    public function __construct(ReadTransformer $readTransformer)
    {
        $this->readTransformer = $readTransformer;
    }

	public function transform($object)
    {
        return [
            'id' => (int) $object->id,
            'name' => $object->name,
            'created_at' =>  $object->created_at->format('d-m-Y @ H:i:s'),
            'reads' => $this->readTransformer->transformCollection($object->reads),
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