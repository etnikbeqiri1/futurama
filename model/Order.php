<?php

/**
 * Class Order
 */
class Order
{

    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $user_id;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $product;
    /**
     * @var
     */
    private $budget;
    /**
     * @var
     */
    private $status;
    /**
     * @var
     */
    private $date;

    /**
     * Message constructor.
     * @param $order_id
     * @param $user_id
     * @param $name
     * @param $product
     * @param $budget
     * @param $status
     * @param $date
     */
    public function __construct($id, $user_id, $name, $product, $budget, $status, $date)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->name = $name;
        $this->product = $product;
        $this->budget = $budget;
        $this->status = $status;
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        if($product == null){
            throw new Exception("Product is required");
        }

        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param mixed $budget
     */
    public function setBudget($budget): void
    {
        $this->budget = $budget;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
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

}
?>
