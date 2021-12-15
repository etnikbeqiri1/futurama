<?php

class News{

    private $id;
    private $title;
    private $content;
    private $image;
    private $date;

    public function __construct($id, $title, $content, $image, $date)
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setContent($content);
        $this->setImage($image);
        $this->setDate($date);
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        if($title == null){
            throw new Exception("Title can't be empty");
        }
        if(strlen($title) < 5){
            throw new Exception("Title can't be shorter than 5 characters");
        }
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        if($content == null){
            throw new Exception("Content can't be empty");
        }
        if(strlen($content) < 6){
            throw new Exception("Content can't be shorted than 6 characters");
        }
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
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