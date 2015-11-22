<?php 
namespace Rea\Transformers;

abstract class Transformer 
{

	public function transformCollection($collection)
	{
		$transformedCollection = array();
		foreach ($collection as $element)
		{
			$element = $this->transform($element);
			$clonedElement = $element; // This needs to be done cause array_push add by reference
			array_push($transformedCollection, $clonedElement);
		}
		return $transformedCollection;
	}

	public abstract function transform($object);
}