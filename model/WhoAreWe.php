<?php
class WhoAreWe
{
    private $id;
    private $title;
    private $description;
    private $img;

    /**
     * WhoAreWe constructor.
     * @param $id
     * @param $title
     * @param $description
     * @param $img
     */
    public function __construct($id, $title, $description, $img)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->img = $img;
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
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img): void
    {
        $this->img = $img;
    }


}

?>