<?php
class OurTeam
{
    private $id;
    private $name;
    private $jobDescription;
    private $img;

    /**
     * OurTeam constructor.
     * @param $id
     * @param $name
     * @param $jobDescription
     * @param $img
     */
    public function __construct($id, $name, $jobDescription, $img)
    {
        $this->id = $id;
        $this->name = $name;
        $this->jobDescription = $jobDescription;
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
    public function getJobDescription()
    {
        return $this->jobDescription;
    }

    /**
     * @param mixed $jobDescription
     */
    public function setJobDescription($jobDescription): void
    {
        $this->jobDescription = $jobDescription;
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