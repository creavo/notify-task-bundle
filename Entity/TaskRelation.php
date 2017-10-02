<?php

namespace Creavo\NotifyTaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaskRelation
 *
 * @ORM\Table(name="crv_ntb_task_relations")
 * @ORM\Entity(repositoryClass="Creavo\NotifyTaskBundle\Repository\TaskRelationRepository")
 */
class TaskRelation
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
     * @var Task
     *
     * @ORM\ManyToOne(targetEntity="Creavo\NotifyTaskBundle\Entity\Task", inversedBy="taskRelations")
     * @ORM\JoinColumn(name="task_id", onDelete="CASCADE")
     */
    private $task;

    public function __construct() {

    }

    public function createHash() {
        $data=[
            'entityClass'=>$this->getEntityClass(),
            'entityId'=>$this->getEntityId(),
        ];

        return md5(json_encode($data));
    }

    public function getHash() {
        return $this->createHash();
    }

    public function getId(){
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

    public function setTask(\Creavo\NotifyTaskBundle\Entity\Task $task = null){
        $this->task = $task;
        return $this;
    }

    public function getTask(){
        return $this->task;
    }
}
