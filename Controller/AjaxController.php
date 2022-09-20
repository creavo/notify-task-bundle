<?php

namespace Creavo\NotifyTaskBundle\Controller;

use Creavo\NotifyTaskBundle\Entity\Notification;
use Creavo\NotifyTaskBundle\Entity\Task;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller {

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

    public function userTasksAction(Request $request) {

        $data=[
            'total'>0,
            'items'=>[],
        ];

        $user=$this->getUser();
        $limit=$request->query->getInt('limit',10)<26 ? $request->query->getInt('limit',10) : 10;

        /** @var QueryBuilder $qb */
        $qb=$this->getDoctrine()->getRepository('CreavoNotifyTaskBundle:Task')->createQueryBuilder('t');

        $qb
            ->andWhere('t.user = :user')
            ->setParameter('user',$user)
            ->setMaxResults($limit);

        /** @var Task $task */
        foreach($qb->getQuery()->getResult() AS $task) {
            $array=$task->toArray();
            $array['directLink']=$task->linkable() ? $this->generateUrl($task->getLinkRoute(),$task->getLinkRouteParams()) : null;
            $array['redirectLink']=$task->linkable() ? $this->generateUrl('creavo_notify_task_redirect_task',['id'=>$task->getId()]) : null;
            $data['items'][]=$array;
        }

        return new JsonResponse($data);
    }

    public function userNotificationsAction(Request $request) {

        $user=$this->getUser();
        $limit=$request->query->getInt('limit',10)<26 ? $request->query->getInt('limit',10) : 10;

        $data=[
            'total'=>$this->getDoctrine()->getRepository('CreavoNotifyTaskBundle:Notification')->totalUnReadNotificationsForUser($user),
            'items'=>[],
            'lastDateTime'=>null,
        ];

        $qb=$this->getDoctrine()->getRepository('CreavoNotifyTaskBundle:Notification')->getLastNotificationsForUser($user,$limit);
        $lastDateTime=null;

        /** @var Notification $notification */
        foreach($qb->getQuery()->getResult() AS $notification) {
            $array=$notification->toArray();
            $array['directLink']=$notification->linkable() ? $this->generateUrl($notification->getLinkRoute(),$notification->getLinkRouteParams()) : null;
            $array['redirectLink']=$notification->linkable() ? $this->generateUrl('creavo_notify_task_redirect_notification',['id'=>$notification->getId()]) : null;
            $data['items'][]=$array;

            if($lastDateTime<$notification->getCreatedAt()) {
                $lastDateTime=$notification->getCreatedAt();
            }
        }

        if($lastDateTime) {
            $data['lastDateTime']=$lastDateTime->format('Y-m-d H:i:s');
        }

        return new JsonResponse($data);
    }
}
