<?php

namespace Creavo\NotifyTaskBundle\Provider;

use AppBundle\Entity\User;
use Creavo\NotifyTaskBundle\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Registry;

class NotificationProvider {

    /** @var \Doctrine\Common\Persistence\ObjectManager */
    protected $em;

    public function __construct(Registry $registry) {
        $this->em=$registry->getManager();
    }

    public function createNotification(User $user, $message, $title=null, $relations=[], $flush=true) {

        if(!is_array($relations)) {
            $relations=[$relations];
        }

        $notification=new Notification();
        $notification->setTitle($title);
        $notification->setMessage($message);
        $notification->setUser($user);
        $this->em->persist($notification);

        foreach($relations AS $relation) {
            $notificationRelation=Helper::objectToNotificationRelation($relation);
            $notificationRelation->setNotification($notification);
            $notification->addNotificationRelation($notificationRelation);
            $this->em->persist($notificationRelation);
        }

        if($flush) {
            $this->em->flush();
        }

        return $notification;
    }

    public function setAllNotificationsRead(User $user) {
        $this->em->getRepository('CreavoNotifyTaskBundle:Notification')->setAllNotificationsReadForUser($user);
    }

    public function setNotificationRead($objectOrId, $flush=true) {

        /** @var Notification $notification */
        $notification=$this->getNotificationEntity($objectOrId);

        $notification->setRead(new \DateTime('now'));
        $this->em->persist($notification);

        if($flush) {
            $this->em->flush();
        }
        return $notification;
    }

    protected function getNotificationEntity($notification) {
        if($notification instanceof Notification) {
            return $notification;
        }

        if($entity=$this->em->getRepository('CreavoNotifyTaskBundle:Notification')->find($notification)) {
            return $entity;
        }

        throw new \Exception('cannot find notification');
    }



}