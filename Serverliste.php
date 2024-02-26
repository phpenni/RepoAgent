<?php

class Server
{
    public $Server;
    public $land;

    public function __construct($Server, $land)
    {
        $this->setServer($Server);
        $this->setland($land);
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->Server;
    }

    /**
     * @return mixed
     */
    public function getLand()
    {
        return $this->land;
    }

    /**
     * @param mixed $Server
     */
    public function setServer($Server): void
    {
        $this->Server = $Server;
    }

    /**
     * @param mixed $land
     */
    public function setLand($land): void
    {
        $this->land = $land;
    }
}