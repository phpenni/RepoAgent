<?php

class Mirror
{
    private $repo;
    private $ISO;
    private $land;
    private $resultRepoCheck;
    private $resultISOCheck;

    public function __construct($repo, $ISO, $land)
    {
        $this->setRepo($repo);
        $this->setISO($ISO);
        $this->setLand($land);
    }

    public function getRepo()
    {
        return $this->repo;
    }

    public function getISO()
    {
        return $this->ISO;
    }

    public function getLand()
    {
        return $this->land;
    }

    public function setRepo($repo)
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

    public function checkRepo()
    {
        $repoContent = getWebsiteContent($this->getRepo());
        $someValue = 'UpToDateMarker';
        $this->resultRepoCheck = ($repoContent == $someValue) ? 'Up to date' : 'Not up to date';
    }

    public function checkISO()
    {
        $ISOContent = getWebsiteContent($this->getISO());
        $someValue = 'UpToDateISO';
        $this->resultISOCheck = ($ISOContent == $someValue) ? 'Up to date' : 'Not up to date';
    }

    public function getResultRepoCheck()
    {
        return $this->resultRepoCheck;
    }

    public function getResultISOCheck()
    {
        return $this->resultISOCheck;
    }
}
?>


// Wenn der Server ISO (dafür brauchst du auch ne Klassenvariable) hat, dann ISO checkne
// Wenn der Server Repo hat, dann REPO checken
//Ergebnisse in Klassenvariablen setzen