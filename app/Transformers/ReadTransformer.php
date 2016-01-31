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

    public function transformChartValues($collection, $lapse, $column)
    {
        $transformedCollection = array();
        foreach ($collection as $element)
        {
            switch ($column) 
            {
                case 'dynamic_level':
                    $element = $this->transformDynamicLevelValue($element, $lapse);
                    break;
                case 'voltage':
                    $element = $this->transformVoltageValue($element, $lapse);
                    break;
                case 'current':
                    $element = $this->transformCurrentValue($element, $lapse);
                    break;
                case 'power':
                    $element = $this->transformPowerValue($element, $lapse);
                    break;
                
                default:
                    throw new Exception("Unkown column on station_reads table", 1);
                    
                    break;
            }
            $clonedElement = $element; // This needs to be done cause array_push add by reference
            array_push($transformedCollection, $clonedElement);
        }
        return $transformedCollection;
    }

    public function transformDynamicLevelValue($object, $lapse)
    {
        if($lapse == 'day')
        {
            return [
                'x' => (int) $object->hour,
                'y' => (float) $object->dynamic_level,
            ];
        }
        if($lapse == 'month')
        {
            return [
                'x' => (int) $object->day,
                'y' => (float) $object->dynamic_level,
            ];
        }
        if($lapse == 'year')
        {
            return [
                'x' => (int) $object->month,
                'y' => (float) $object->dynamic_level,
            ];
        }
    }

    public function transformVoltageValue($object, $lapse)
    {
        if($lapse == 'day')
        {
            return [
                'x' => (int) $object->hour,
                'y' => (float) $object->voltage,
            ];
        }
        if($lapse == 'month')
        {
            return [
                'x' => (int) $object->day,
                'y' => (float) $object->voltage,
            ];
        }
        if($lapse == 'year')
        {
            return [
                'x' => (int) $object->month,
                'y' => (float) $object->voltage,
            ];
        }
    }

    public function transformCurrentValue($object, $lapse)
    {
        if($lapse == 'day')
        {
            return [
                'x' => (int) $object->hour,
                'y' => (float) $object->current,
            ];
        }
        if($lapse == 'month')
        {
            return [
                'x' => (int) $object->day,
                'y' => (float) $object->current,
            ];
        }
        if($lapse == 'year')
        {
            return [
                'x' => (int) $object->month,
                'y' => (float) $object->current,
            ];
        }
    }

    public function transformPowerValue($object, $lapse)
    {
        if($lapse == 'day')
        {
            return [
                'x' => (int) $object->hour,
                'y' => (float) $object->power,
            ];
        }
        if($lapse == 'month')
        {
            return [
                'x' => (int) $object->day,
                'y' => (float) $object->power,
            ];
        }
        if($lapse == 'year')
        {
            return [
                'x' => (int) $object->month,
                'y' => (float) $object->power,
            ];
        }
    }
}
