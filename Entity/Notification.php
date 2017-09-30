<?php

namespace Creavo\NotifyTaskBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="crv_ntb_notifications")
 * @ORM\Entity(repositoryClass="Creavo\NotifyTaskBundle\Repository\NotificationRepository")
 */
class Notification extends NotifyTask
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
     * @var bool
     *
     * @ORM\Column(name="is_sent", type="boolean")
     */
    private $sent=false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="is_read", type="datetime", nullable=true)
     */
    private $read;

    /**
     * @var NotificationRelation[]
     *
     * @ORM\OneToMany(targetEntity="Creavo\NotifyTaskBundle\Entity\NotificationRelation", mappedBy="notification")
     */
    private $notificationRelations;

    /**
     * @var User[]
     */
    private $users=[];

    public function __construct() {
        parent::__construct();

        $this->notificationRelations=new ArrayCollection();
    }

    public function toArray() {
        return [
            'id'=>$this->getId(),
            'title'=>$this->getTitle(),
            'message'=>$this->getMessage(),
            'createdAt'=>$this->getCreatedAt() ? $this->getCreatedAt()->format('Y-m-d H:i:s') : null,
            'user'=>$this->getUser() ? $this->getUser()->getId() : null,
            'linkRoute'=>$this->getLinkRoute(),
            'linkRouteParams'=>$this->getLinkRouteParams(),
            'linkTitle'=>$this->getLinkTitle(),
            'priority'=>$this->getPriority(),
            'sent'=>$this->getSent(),
            'read'=>$this->read,
        ];
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function isSent(){
        return $this->sent;
    }

    public function setSent($sent){
        $this->sent = $sent;
        return $this;
    }

    public function getRead(){
        return $this->read;
    }

    public function setRead($read){
        $this->read = $read;
        return $this;
    }

    public function getSent(){
        return $this->sent;
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

    public function getUsers(){
        return $this->users;
    }

    public function setUsers($users){
        $this->users = $users;
        return $this;
    }


}
