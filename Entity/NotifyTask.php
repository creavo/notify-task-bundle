<?php

namespace Creavo\NotifyTaskBundle\Entity;

use Creavo\NotifyTaskBundle\Interfaces\NotifyTaskInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class NotifyTask
 * @package Creavo\NotifyTaskBundle\Entity
 * @ORM\MappedSuperclass
 */
class NotifyTask implements NotifyTaskInterface {

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
     * @var string
     *
     * @ORM\Column(name="link_title", type="string", length=255, nullable=true)
     */
    private $linkTitle;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="smallint")
     */
    private $priority=self::PRIORITY_MIDDLE;

    /**
     * @var int
     *
     * @ORM\Column(name="send_via_email", type="smallint")
     */
    private $sendViaEmail=self::SEND_STATUS_DO_NOT_SEND;

    /**
     * @var int
     *
     * @ORM\Column(name="send_via_push_over", type="smallint")
     */
    private $sendViaPushOver=self::SEND_STATUS_DO_NOT_SEND;

    /**
     * @var string
     *
     * @ORM\Column(name="hashed_key", type="string", length=32, nullable=true)
     */
    private $hash;

    public function __construct() {
        $this->createdAt=new \DateTime('now');
    }

    public function toArray() {
        return [
            'id'=>null,
            'title'=>$this->getTitle(),
            'message'=>$this->getMessage(),
            'createdAt'=>$this->getCreatedAt() ? $this->getCreatedAt()->format('Y-m-d H:i:s') : null,
            'user'=>$this->getUser() ? $this->getUser()->getId() : null,
            'linkRoute'=>$this->getLinkRoute(),
            'linkRouteParams'=>$this->getLinkRouteParams(),
            'linkTitle'=>$this->getLinkTitle(),
            'priority'=>$this->getPriority(),
        ];
    }

    public function setLink($routeName,$routeParameters=[],$title=null) {
        $this->setLinkRoute($routeName);
        $this->setLinkRouteParams($routeParameters);
        $this->setLinkTitle($title);
        return $this;
    }

    public function linkable() {
        return $this->getLinkRoute() ? true : false;
    }

    public function sendViaEmail() {
        $this->setSendViaEmail(self::SEND_STATUS_OPEN);
        return $this;
    }

    public function sendViaPushOver() {
        $this->setSendViaPushOver(self::SEND_STATUS_OPEN);
        return $this;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
        return $this;
    }

    public function getMessage(){
        return $this->message;
    }

    public function setMessage($message){
        $this->message = $message;
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

    public function setUser($user){
        $this->user = $user;
        return $this;
    }

    public function getLinkRoute(){
        return $this->linkRoute;
    }

    public function setLinkRoute($linkRoute){
        $this->linkRoute = $linkRoute;
        return $this;
    }

    public function getLinkRouteParams(){
        return $this->linkRouteParams;
    }

    public function setLinkRouteParams($linkRouteParams){
        $this->linkRouteParams = $linkRouteParams;
        return $this;
    }

    public function getLinkTitle(){
        return $this->linkTitle;
    }

    public function setLinkTitle($linkTitle){
        $this->linkTitle = $linkTitle;
        return $this;
    }

    public function getPriority(){
        return $this->priority;
    }

    public function setPriority($priority){
        $this->priority = $priority;
        return $this;
    }

    public function getSendViaEmail(){
        return $this->sendViaEmail;
    }

    public function setSendViaEmail($sendViaEmail){
        $this->sendViaEmail = $sendViaEmail;
        return $this;
    }

    public function getSendViaPushOver(){
        return $this->sendViaPushOver;
    }

    public function setSendViaPushOver($sendViaPushOver){
        $this->sendViaPushOver = $sendViaPushOver;
        return $this;
    }

    public function getHash(){
        return $this->hash;
    }

    public function setHash($hash){
        $this->hash = $hash;
        return $this;
    }

}
