<?php

namespace Creavo\NotifyTaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotificationRelation
 *
 * @ORM\Table(name="crv_ntb_notification_relations")
 * @ORM\Entity(repositoryClass="Creavo\NotifyTaskBundle\Repository\NotificationRelationRepository")
 */
class NotificationRelation
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
     * @ORM\Column(name="entity_class", type="string", length=255)
     */
    private $entityClass;

    /**
     * @var int
     *
     * @ORM\Column(name="entity_id", type="integer")
     */
    private $entityId;

    /**
     * @var Notification
     *
     * @ORM\ManyToOne(targetEntity="Creavo\NotifyTaskBundle\Entity\Notification", inversedBy="notificationRelations")
     * @ORM\JoinColumn(name="notification_id", onDelete="CASCADE")
     */
    private $notification;


    public function __construct() {

    }

    public function getId() {
        return $this->id;
    }

    public function setEntityClass($entityClass){
        $this->entityClass = $entityClass;
        return $this;
    }

    public function getEntityClass(){
        return $this->entityClass;
    }

    public function setEntityId($entityId){
        $this->entityId = $entityId;
        return $this;
    }

    public function getEntityId(){
        return $this->entityId;
    }

    public function getNotification(){
        return $this->notification;
    }

    public function setNotification(\Creavo\NotifyTaskBundle\Entity\Notification $notification){
        $this->notification = $notification;
        return $this;
    }


}
