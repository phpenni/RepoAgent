<?php
class Mirror
{
    private $repo;
    private $ISO;
    private $land;
    //short Form

    public function __construct($repo, $ISO, $land)
    {
        $this->setrepo($repo);
        $this->setISO($ISO);
        $this->setLand($land);
    }

    public function getISO()
    {
        return $this->ISO;
    }
    public function getLand()
    {
        return $this->land;
    }

    public function setrepo($repo)
    {
        $this->repo = $repo;
    }

    public function setISO($ISO)
    {
        $this->ISO = $ISO;
    }
    public function setLand($land)
    {
        $this->land = $land;
    }

    public function check($checkURL) {

    }

}
// Wenn der Server ISO (dafür brauchst du auch ne Klassenvariable) hat, dann ISO checkne
// Wenn der Server Repo hat, dann REPO checken
//Ergebnisse in Klassenvariablen setzen