<?php

namespace Creavo\NotifyTaskBundle\Controller;

use Creavo\NotifyTaskBundle\Entity\Task;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller {

    public function userTasksAction(User $user, Request $request) {
        $data=[];

        $limit=$request->query->getInt('limit',10)<26 ? $request->query->getInt('limit',10) : 10;

        /** @var QueryBuilder $qb */
        $qb=$this->getDoctrine()->getRepository('CreavoNotifyTaskBundle:Task')->createQueryBuilder('t');

        $qb
            ->andWhere('t.user = :user')
            ->setParameter('user',$user)
            ->setMaxResults($limit);

        /** @var Task $task */
        foreach($qb->getQuery()->getResult() AS $task) {
            $data[]=$task->toArray();
        }

        return new JsonResponse($data);
    }

    public function userNotificationsAction(User $user, Request $request) {
        $data=[];

        return new JsonResponse($data);
    }
}
