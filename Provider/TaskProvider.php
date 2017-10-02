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

    /**
     * creates a new task
     *
     * @param User $user
     * @param $message
     * @param null $title
     * @param array $relations
     * @param null $linkRoute
     * @param array $linkRouteParams
     * @param bool $flush
     * @return Task
     */
    public function create(User $user, $message, $title=null, $relations=[], $linkRoute=null, $linkRouteParams=[], $flush=false) {

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
            $this->save($task);
        }

        return $task;
    }

    /**
     * saves one or an array of tasks
     *
     * @param array|Task $tasks
     * @return array
     */
    public function save($tasks=[]) {

        if(!is_array($tasks)) {
            $tasks=[$tasks];
        }

        /** @var Task $task */
        foreach($tasks AS $task) {
            $task->createHash();
            $this->em->persist($task);

            foreach($task->getTaskRelations() AS $taskRelation) {
                $this->em->persist($taskRelation);
            }
        }

        $this->em->flush();
        return $tasks;
    }




}
