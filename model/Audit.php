<?php
class Audit{
    private $id;
    private $user;
    private $action;
    private $entity;
    private $entityPk;
    private $message;
    private $date;

    /**
     * Audit constructor.
     * @param $id
     * @param $user
     * @param $action
     * @param $entity
     * @param $entityPk
     * @param $message
     * @param $date
     */
    public function __construct($id, $user, $action, $entity, $entityPk, $message, $date)
    {
        $this->id = $id;
        $this->user = $user;
        $this->action = $action;
        $this->entity = $entity;
        $this->entityPk = $entityPk;
        $this->message = $message;
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity): void
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getEntityPk()
    {
        return $this->entityPk;
    }

    /**
     * @param mixed $entityPk
     */
    public function setEntityPk($entityPk): void
    {
        $this->entityPk = $entityPk;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function __toString()
    {
        return "User with id <b>".$this->getUser()."</b> has <b>".$this->getAction()."</b> an <b>".lcfirst($this->getEntity())."</b> with id <b>".$this->getEntityPk()."</b> on date: <b>".$this->getDate()."</b>.";
    }
}