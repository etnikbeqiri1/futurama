<?php

class Message
{

    private $message_id;
    private $message_sender;
    private $text;
    private $date;
    private $order;

    /**
     * News constructor.
     * @param $message_id
     * @param $message_sender
     * @param $text
     * @param $date
     * @param $order
     */
    public function __construct($message_id, $message_sender, $text, $date, $order)
    {
        $this->message_id = $message_id;
        $this->message_sender = $message_sender;
        $this->text = $text;
        $this->date = $date;
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getMessageId()
    {
        return $this->message_id;
    }

    /**
     * @param mixed $message_id
     */
    public function setMessageId($message_id): void
    {
        $this->message_id = $message_id;
    }

    /**
     * @return mixed
     */
    public function getMessageSender()
    {
        return $this->message_sender;
    }

    /**
     * @param mixed $message_sender
     */
    public function setMessageSender($message_sender): void
    {
        $this->message_sender = $message_sender;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
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

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order): void
    {
        $this->order = $order;
    }

}
?>