<?php

namespace Creavo\NotifyTaskBundle\Controller;

use Creavo\NotifyTaskBundle\Entity\Notification;
use Creavo\NotifyTaskBundle\Entity\Task;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
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
            $data['items'][]=$task->toArray();
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

        /** @var QueryBuilder $qb */
        $qb=$this->getDoctrine()->getRepository('CreavoNotifyTaskBundle:Notification')->createQueryBuilder('n');

        $qb
            ->andWhere('n.user = :user')
            ->setParameter('user',$user)
            ->andWhere('n.read IS NULL')
            ->orderBy('n.createdAt','desc')
            ->setMaxResults($limit);

        $lastDateTime=null;

        /** @var Notification $notification */
        foreach($qb->getQuery()->getResult() AS $notification) {
            $data['items'][]=$notification->toArray();

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
