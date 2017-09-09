<?php

namespace Creavo\NotifyTaskBundle\Provider;

use Creavo\NotifyTaskBundle\Entity\NotificationRelation;
use Creavo\NotifyTaskBundle\Entity\TaskRelation;

class Helper {

    public static function objectToNotificationRelation($object) {

        $data=self::getEntityData($object);

        $notificationRelation=new NotificationRelation();
        $notificationRelation->setEntityClass($data['entityClass']);
        $notificationRelation->setEntityId($data['entityId']);
        return $notificationRelation;
    }

    public static function objectToTaskRelation($object) {

        $data=self::getEntityData($object);

        $taskRelation=new TaskRelation();
        $taskRelation->setEntityClass($data['entityClass']);
        $taskRelation->setEntityId($data['entityId']);
        return $taskRelation;
    }

    public static function getEntityData($object) {
        $data=[
            'entityId'=>null,
            'entityClass'=>null,
        ];

        if(!is_object($object)) {
            throw new \Exception('can only convert objects');
        }

        if(!method_exists($object,'getId')) {
            throw new \Exception(sprintf('object %s has no method "getId()"',get_class($object)));
        }

        $data['entityClass']=get_class($object);
        $data['entityId']=$object->getId();

        return $data;
    }

}