<?php 
namespace Rea\Transformers;

class StationSensorTransformer extends Transformer
{
    public function transform($object)
    {
        return [
            'id' => (int) $object->id,
            'station_id' => (string) $object->station_id,
            'name' => (string) $object->name,
            'label' => (string) $object->label,
            'alarm_activated' => (bool) $object->alarm_activated,
            'alarm_cooldown' => (int) $object->alarm_cooldown,
            'alarm_turned_off_at' => date('c', strtotime($object->alarm_turned_off_at)),
            'notification_phones' => (string) $object->notification_phones,
            'notification_emails' => (string) $object->notification_emails,
            'notification_subject' => (string) $object->notification_subject,
            'notification_text' => (string) $object->notification_text,
        ];
    }
}