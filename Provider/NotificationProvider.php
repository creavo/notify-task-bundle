<?php

namespace Creavo\NotifyTaskBundle\Provider;

use AppBundle\Entity\User;
use Creavo\NotifyTaskBundle\Entity\Notification;
use Creavo\NotifyTaskBundle\Transport\Dispatcher;
use Doctrine\Bundle\DoctrineBundle\Registry;

class NotificationProvider {

    /** @var \Doctrine\Common\Persistence\ObjectManager */
    protected $em;

    /** @var array */
    protected $config;

    /** @var Dispatcher */
    protected $dispatcher;

    public function __construct(array $config, Registry $registry, Dispatcher $dispatcher) {
        $this->em=$registry->getManager();
        $this->config=$config;
        $this->dispatcher=$dispatcher;
    }

    public function createNotification(User $user, $message, $title=null, $relations=[], $linkRoute=null, $linkRouteParams=[], $flush=false) {

        if(!is_array($relations)) {
            $relations=[$relations];
        }

        $notification=new Notification();
        $notification->setTitle($title);
        $notification->setMessage($message);
        $notification->setUser($user);
        $notification->setLinkRoute($linkRoute);
        $notification->setLinkRouteParams($linkRouteParams);

        foreach($relations AS $relation) {
            $notificationRelation=Helper::objectToNotificationRelation($relation);
            $notificationRelation->setNotification($notification);
            $notification->addNotificationRelation($notificationRelation);
        }

        if($flush) {
            $this->saveNotification($notification);
        }

        return $notification;
    }

    public function saveNotification(Notification $notification) {

        $this->em->persist($notification);

        foreach($notification->getNotificationRelations() AS $notificationRelation) {
            $this->em->persist($notificationRelation);
        }

        if($this->config['send_notification_immediately']===true) {
            $this->dispatcher->sendNotification($notification);
            $notification->setSent(true);
        }

        $this->em->flush();
    }

    public function saveNotifications(array $notifications) {
        foreach($notifications AS $notification) {
            $this->saveNotification($notification);
        }
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