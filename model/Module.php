<?php
class Module{
    private $id;
    private $name;
    private $icon;
    private $path;

    /**
     * Module constructor.
     * @param $id
     * @param $name
     * @param $icon
     * @param $path
     */
    public function __construct($id, $name, $icon, $path)
    {
        $this->id = $id;
        $this->name = $name;
        $this->icon = $icon;
        $this->path = $path;
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
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }



}