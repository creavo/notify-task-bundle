<?php

namespace Creavo\NotifyTaskBundle\Controller;

use AppBundle\Entity\User;
use Creavo\NotifyTaskBundle\Entity\Notification;
use Creavo\NotifyTaskBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RedirectController extends Controller {

    public function redirectNotificationAction(Notification $notification) {

        if($notification->getUser()!==$this->getUser()) {
            throw $this->createAccessDeniedException('user mismatch');
        }

        if(!$notification->linkable()) {
            throw $this->createNotFoundException('notification is not linkable');
        }

        if(!$notification->getRead()) {
            $notification->setRead(true);
            $this->getDoctrine()->getManager()->persist($notification);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute($notification->getLinkRoute(),$notification->getLinkRouteParams());
    }

    public function redirectTaskAction(Task $task) {

        if($task->getUser()!==$this->getUser()) {
            throw $this->createAccessDeniedException('user mismatch');
        }

        if(!$task->linkable()) {
            throw $this->createNotFoundException('notification is not linkable');
        }

        return $this->redirectToRoute($task->getLinkRoute(),$task->getLinkRouteParams());
    }

    /**
     * @return User
     */
    protected function getUser() {
        $user=parent::getUser();

        if(!$user instanceof User) {
            throw $this->createAccessDeniedException('not logged in');
        }

        return $user;
    }

}
