<?php

namespace Creavo\NotifyTaskBundle\Provider;

use AppBundle\Entity\User;
use Creavo\NotifyTaskBundle\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Registry;

class TaskProvider {

    /** @var \Doctrine\Common\Persistence\ObjectManager */
    protected $em;

    public function __construct(Registry $registry) {
        $this->em=$registry->getManager();
    }

    public function createTask(User $user, $title, $message=null, $relations=[], \DateTime $deadline=null, $flush=true) {

        if(!is_array($relations)) {
            $relations=[$relations];
        }

        $task=new Task();
        $task->setTitle($title);
        $task->setMessage($message);
        $task->setUser($user);
        $task->setDeadline($deadline);
        $this->em->persist($task);

        foreach($relations AS $relation) {
            $taskRelation=Helper::objectToTaskRelation($relation);
            $taskRelation->setTask($task);
            $task->addTaskRelation($taskRelation);
            $this->em->persist($taskRelation);
        }

        if($flush) {
            $this->em->flush();
        }

        return $task;
    }



}