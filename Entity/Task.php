<?php

namespace Creavo\NotifyTaskBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Creavo\NotifyTaskBundle\Interfaces\NotifyTaskInterface;

/**
 * Task
 *
 * @ORM\Table(name="crv_ntb_tasks")
 * @ORM\Entity(repositoryClass="Creavo\NotifyTaskBundle\Repository\TaskRepository")
 */
class Task extends NotifyTask
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="notify_after", type="datetime", nullable=true)
     */
    private $notifyAfter;

    /**
     * @var TaskRelation[]
     *
     * @ORM\OneToMany(targetEntity="Creavo\NotifyTaskBundle\Entity\TaskRelation", mappedBy="task")
     */
    private $taskRelations;


    public function __construct() {
        parent::__construct();

        $this->taskRelations=new ArrayCollection();
    }

    public function toArray() {
        $data=parent::toArray();
        $data['id']=$this->getId();
        $data['notifyAfter']=$this->getNotifyAfter();
        return $data;
    }

    public function createHash() {
        $data=[
            'title'=>$this->getTitle(),
            'message'=>$this->getMessage(),
            'user'=>$this->getUser() ? $this->getUser()->getId() : null,
            'linkRoute'=>$this->getLinkRoute(),
            'linkRouteParams'=>$this->getLinkRouteParams(),
            'linkTitle'=>$this->getLinkTitle(),
            'taskRelations'=>[],
        ];

        /** @var TaskRelation $taskRelation */
        foreach($this->getTaskRelations() AS $taskRelation) {
            $data['taskRelations'][]=$taskRelation->getHash();
        }

        $hash=md5(json_encode($data));
        $this->setHash($hash);
        return $this;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getNotifyAfter(){
        return $this->notifyAfter;
    }

    public function setNotifyAfter($notifyAfter){
        $this->notifyAfter = $notifyAfter;
        return $this;
    }

    public function addTaskRelation(\Creavo\NotifyTaskBundle\Entity\TaskRelation $taskRelation){
        $this->taskRelations[] = $taskRelation;
        return $this;
    }

    public function removeTaskRelation(\Creavo\NotifyTaskBundle\Entity\TaskRelation $taskRelation){
        $this->taskRelations->removeElement($taskRelation);
    }

    public function getTaskRelations(){
        return $this->taskRelations;
    }
}
