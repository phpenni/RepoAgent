<?php
class Mirror {
    private string $repo;
    private string $ISO;
    private string $land;
    private string $name;

    private ?string $resultRepoCheck = null;
    private ?string $resultISOCheck = null;

    public function __construct(string $repo, string $ISO, string $land, string $name)
    {
        $this->setRepoUrl($repo);
        $this->setISOUrl($ISO);
        $this->setLand($land);
        $this->setName($name);
    }

    public function getRepo(): string
    {
        return $this->repo;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getISO(): string
    {
        return $this->ISO;
    }

    public function getLand(): string
    {
        return $this->land;
    }

    public function setRepoUrl(string $repo): void
    {
        $this->repo = $repo;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setISOUrl(string $ISO): void
    {
        $this->ISO = $ISO;
    }

    public function setLand(string $land): void
    {
        $this->land = $land;
    }

    public function getResultRepo(): ?string
    {
        $this->checkRepo();
        return $this->resultRepoCheck;
    }

    public function getResultISO(): ?string
    {
        $this->checkISO();
        return $this->resultISOCheck;
    }

    public function checkISO(): void
    {
        if ($this->resultISOCheck !== null) {
            return;
        }
        $ISOContent = $this->getWebsiteContent($this->getISO());
        $comparisonValue = $this->getWebsiteContent('https://mirror.alpix.eu/endeavouros/iso/state');
        $this->resultISOCheck = ($ISOContent == $comparisonValue) ? 'up to date' : 'not up to date';
    }

    public function checkRepo(): void
    {
        if ($this->resultRepoCheck !== null) {
            return;
        }
        $repoContent = $this->getWebsiteContent($this->getrepo());
        $comparisonValue = $this->getWebsiteContent('https://mirror.alpix.eu/endeavouros/repo/state');
        $this->resultISOCheck = ($repoContent == $comparisonValue) ? 'up to date' : 'not up to date';
    }
    private function getWebsiteContent(string $url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

}

?>
