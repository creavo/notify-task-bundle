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
     * @var bool
     *
     * @ORM\Column(name="memory_sent", type="boolean")
     */
    private $memorySent=false;

    /**
     * @var User[]
     */
    private $users=[];

    public function __construct() {
        parent::__construct();

        $this->notificationRelations=new ArrayCollection();
    }

    public function toArray() {
        $data=parent::toArray();
        $data['id']=$this->getId();
        $data['sent']=$this->getSent();
        $data['read']=$this->getRead();
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
            'notificationRelations'=>[],
        ];

        /** @var NotificationRelation $notificationRelation */
        foreach($this->getNotificationRelations() AS $notificationRelation) {
            $data['notificationRelations'][]=$notificationRelation->getHash();
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

    public function setRead(\DateTime $read=null){
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

    public function isMemorySent()
    {
        return $this->memorySent;
    }

    public function setMemorySent($memorySent)
    {
        $this->memorySent = $memorySent;
    }



}
