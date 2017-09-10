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
class Task implements NotifyTaskInterface
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=2048)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="done", type="datetime", nullable=true)
     */
    private $done;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="datetime", nullable=true)
     */
    private $deadline;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $user;

    /**
     * @var TaskRelation[]
     *
     * @ORM\OneToMany(targetEntity="Creavo\NotifyTaskBundle\Entity\TaskRelation", mappedBy="task")
     */
    private $taskRelations;

    /**
     * @var string
     *
     * @ORM\Column(name="link_route", type="string", length=255, nullable=true)
     */
    private $linkRoute;

    /**
     * @var array
     *
     * @ORM\Column(name="link_route_params", type="json_array", nullable=true)
     */
    private $linkRouteParams;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="smallint")
     */
    private $priority=self::PRIORITY_MIDDLE;


    public function __construct(){
        $this->createdAt=new \DateTime('now');
        $this->taskRelations=new ArrayCollection();
    }

    public function getId(){
        return $this->id;
    }

    public function setTitle($title){
        $this->title = $title;
        return $this;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setMessage($message){
        $this->message = $message;
        return $this;
    }

    public function getMessage(){
        return $this->message;
    }

    public function setDone(\DateTime $done=null){
        $this->done = $done;
        return $this;
    }

    public function getDone(){
        return $this->done;
    }

    public function setCreatedAt(\DateTime $createdAt){
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function setDeadline($deadline){
        $this->deadline = $deadline;
        return $this;
    }

    public function getDeadline(){
        return $this->deadline;
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

    public function setUser(\AppBundle\Entity\User $user = null){
        $this->user = $user;
        return $this;
    }

    public function getUser(){
        return $this->user;
    }

    public function setLinkRoute($linkRoute){
        $this->linkRoute = $linkRoute;
        return $this;
    }

    public function getLinkRoute(){
        return $this->linkRoute;
    }

    public function setLinkRouteParams($linkRouteParams){
        $this->linkRouteParams = $linkRouteParams;
        return $this;
    }

    public function getLinkRouteParams(){
        return $this->linkRouteParams;
    }

    public function getPriority(){
        return $this->priority;
    }

    public function setPriority($priority){
        $this->priority = $priority;
        return $this;
    }


}
