<?php

namespace Creavo\NotifyTaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="crv_ntb_notifications")
 * @ORM\Entity(repositoryClass="Creavo\NotifyTaskBundle\Repository\NotificationRepository")
 */
class Notification
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=2048, nullable=true)
     */
    private $message;

    /**
     * @var bool
     *
     * @ORM\Column(name="sent", type="boolean")
     */
    private $sent=false;

    /**
     * @var bool
     *
     * @ORM\Column(name="read", type="boolean")
     */
    private $read=false;

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


    public function __construct() {
        $this->createdAt=new \DateTime('now');
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

    public function setRead($read){
        $this->read = $read;
        return $this;
    }

    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt){
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


}

