<?php

namespace Creavo\NotifyTaskBundle\Provider;

use AppBundle\Entity\User;
use Creavo\NotifyTaskBundle\Entity\Notification;
use Creavo\NotifyTaskBundle\Transport\Dispatcher;
use Doctrine\ORM\EntityManagerInterface;

class NotificationProvider {

    /** @var EntityManagerInterface */
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

    /**
     * creates a notification
     *
     * @param User|array $user
     * @param string $message
     * @param string $title
     * @param array $relations
     * @param string $linkRoute
     * @param array $linkRouteParams
     * @param bool $flush
     * @throws \Exception
     * @return Notification
     */
    public function create($user, $message, $title=null, $relations=[], $linkRoute=null, $linkRouteParams=[], $flush=false) {

        if(!is_array($relations)) {
            $relations=[$relations];
        }

        $notification=new Notification();
        $notification->setTitle($title);
        $notification->setMessage($message);
        $notification->setLinkRoute($linkRoute);
        $notification->setLinkRouteParams($linkRouteParams);

        if($user instanceof User) {
            $notification->setUser($user);
        }elseif(is_array($user)) {
            $notification->setUsers($user);
        }else{
            throw new \Exception('$user must be an instance of User or an array');
        }

        foreach($relations AS $relation) {
            $notificationRelation=Helper::objectToNotificationRelation($relation);
            $notificationRelation->setNotification($notification);
            $notification->addNotificationRelation($notificationRelation);
        }

        if($flush) {
            $this->save($notification);
        }

        return $notification;
    }

    /**
     * saves one or an array of notifications
     *
     * @param array|Notification $notifications
     * @return array
     */
    public function save($notifications=[]) {

        if(!is_array($notifications)) {
            $notifications=[$notifications];
        }

        /** @var Notification $notification */
        foreach($notifications AS $key=>$notification) {

            if(count($notification->getUsers())>0) {

                /** @var User $user */
                foreach($notification->getUsers() AS $user) {
                    $n=clone $notification;
                    $n->setUser($user);
                    $n->setUsers([]);
                    $notifications[]=$n;
                }

                unset($notifications[$key]);
            }
        }

        /** @var Notification $notification */
        foreach($notifications AS $notification) {

            $notification->createHash();
            $this->em->persist($notification);

            foreach ($notification->getNotificationRelations() AS $notificationRelation) {
                $this->em->persist($notificationRelation);
            }

            if ($this->config['send_notification_immediately'] === true) {
                $this->dispatcher->sendNotification($notification);
                $notification->setSent(true);
            }
        }

        $this->em->flush();
        return $notifications;
    }

    /**
     * mark all notifications as read for a given user
     *
     * @param User $user
     */
    public function setAllRead(User $user) {
        $this->em->getRepository('CreavoNotifyTaskBundle:Notification')->setAllNotificationsReadForUser($user);
    }

    /**
     * marks one notification as read, given the object or the ID
     *
     * @param $objectOrId
     * @param bool $flush
     * @return Notification
     */
    public function setRead($objectOrId, $flush=true) {

        /** @var Notification $notification */
        $notification=$this->getNotificationEntity($objectOrId);

        $notification->setRead(new \DateTime('now'));
        $this->em->persist($notification);

        if($flush) {
            $this->em->flush();
        }
        return $notification;
    }

    /**
     * returns a notification-object
     *
     * @param Notification|int $notification
     * @return Notification
     * @throws \Exception
     */
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
