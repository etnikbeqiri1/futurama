<?php
class Visitor{
    private $id;
    private $browser;
    private $os;
    private $cookieId;
    private $date;

    /**
     * Visitor constructor.
     * @param $id
     * @param $browser
     * @param $os
     * @param $cookieId
     * @param $date
     */
    public function __construct($id, $browser, $os, $cookieId, $date)
    {
        $this->id = $id;
        $this->browser = $browser;
        $this->os = $os;
        $this->cookieId = $cookieId;
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
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * @param mixed $browser
     */
    public function setBrowser($browser): void
    {
        $this->browser = $browser;
    }

    /**
     * @return mixed
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * @param mixed $os
     */
    public function setOs($os): void
    {
        $this->os = $os;
    }

    /**
     * @return mixed
     */
    public function getCookieId()
    {
        return $this->cookieId;
    }

    /**
     * @param mixed $cookieId
     */
    public function setCookieId($cookieId): void
    {
        $this->cookieId = $cookieId;
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