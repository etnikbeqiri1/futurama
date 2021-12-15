<?php

class Ticket{

    private $id;
    private $email;
    private $sex;
    private $country;
    private $name;
    private $message;
    private $date;

    /**
     * Ticket constructor.
     * @param integer $id
     * @param string $email
     * @param integer $sex
     * @param string $country
     * @param string $name
     * @param string $message
     * @param string $date
     * @throws Exception
     */
    public function __construct($id, $email, $sex, $country, $name, $message, $date)
    {
        $this->setId($id);
        $this->setEmail($email);
        $this->setSex($sex);
        $this->setCountry($country);
        $this->setName($name);
        $this->setMessage($message);
        $this->setDate($date);
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new Exception("Invalid e-mail address provided.");
        $this->email = $email;
    }

    /**
     * @return integer
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param integer $sex
     */
    public function setSex($sex): void
    {
        if(!is_numeric($sex) || $sex < 0 || $sex > 1)
            throw new Exception("Invalid sex selected.");
        $this->sex = $sex;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country): void
    {
        if(empty($country))
            throw new Exception("Please select your country");
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        if(empty($name))
            throw new Exception("Please write your name.");
        else if(strlen($name) < 3)
            throw new Exception("Please write your name.");

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message): void
    {
        if(empty($message))
            throw new Exception("Please write your message");
        else if(strlen($message) < 10)
            throw new Exception("The message needs to be 15 characters or longer");

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


}