<?php

namespace Creavo\NotifyTaskBundle\Provider;

use AppBundle\Entity\User;
use Creavo\NotifyTaskBundle\Entity\Task;
use Creavo\NotifyTaskBundle\Transport\Dispatcher;
use Doctrine\Bundle\DoctrineBundle\Registry;

class TaskProvider {

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

    public function createTask(User $user, $message, $title=null, $relations=[], $linkRoute=null, $linkRouteParams=[], $flush=false) {

        if(!is_array($relations)) {
            $relations=[$relations];
        }

        $task=new Task();
        $task->setTitle($title);
        $task->setMessage($message);
        $task->setUser($user);
        $task->setLinkRoute($linkRoute);
        $task->setLinkRouteParams($linkRouteParams);

        foreach($relations AS $relation) {
            $taskRelation=Helper::objectToTaskRelation($relation);
            $taskRelation->setTask($task);
            $task->addTaskRelation($taskRelation);
        }

        if($flush) {
            $this->saveTask($task);
        }

        return $task;
    }

    public function saveTask(Task $task) {

        $this->em->persist($task);

        foreach($task->getTaskRelations() AS $taskRelation) {
            $this->em->persist($taskRelation);
        }

        $this->em->flush();
    }

    public function saveTasks(array $tasks) {
        foreach($tasks AS $task) {
            $this->saveTask($task);
        }
    }



}