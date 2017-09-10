<?php

namespace Creavo\NotifyTaskBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Creavo\NotifyTaskBundle\Interfaces\NotifyTaskInterface;

/**
 * Notification
 *
 * @ORM\Table(name="crv_ntb_notifications")
 * @ORM\Entity(repositoryClass="Creavo\NotifyTaskBundle\Repository\NotificationRepository")
 */
class Notification implements NotifyTaskInterface
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
     * @var bool
     *
     * @ORM\Column(name="sent", type="boolean")
     */
    private $sent=false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="read", type="datetime", nullable=true)
     */
    private $read;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $user;

    /**
     * @var NotificationRelation[]
     *
     * @ORM\OneToMany(targetEntity="Creavo\NotifyTaskBundle\Entity\NotificationRelation", mappedBy="notification")
     */
    private $notificationRelations;

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


    public function __construct() {
        $this->createdAt=new \DateTime('now');
        $this->notificationRelations=new ArrayCollection();
    }

    public function getId()
    {
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

    public function setSent($sent){
        $this->sent = $sent;
        return $this;
    }

    public function getSent(){
        return $this->sent;
    }

    public function isRead(){
        return $this->read;
    }

    public function setRead(\DateTime $read=null){
        $this->read = $read;
        return $this;
    }

    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt){
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUser(){
        return $this->user;
    }

    public function setUser(\AppBundle\Entity\User $user){
        $this->user = $user;
        return $this;
    }

    public function getRead(){
        return $this->read;
    }

    public function addNotificationRelation(\Creavo\NotifyTaskBundle\Entity\NotificationRelation $notificationRelation){
        $this->notificationRelations[] = $notificationRelation;
        return $this;
    }

    public function removeNotificationRelation(\Creavo\NotifyTaskBundle\Entity\NotificationRelation $notificationRelation){
        $this->notificationRelations->removeElement($notificationRelation);
    }

    public function getNotificationRelations(){
        return $this->notificationRelations;
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
