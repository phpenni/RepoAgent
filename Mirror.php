<?php
class Mirror
{
private string $repo;
private string $ISO;
private string $land;
private ?string $resultRepoCheck = null;
private ?string $resultISOCheck = null;

public function __construct(string $repo, string $ISO, string $land)
{
$this->setRepo($repo);
$this->setISO($ISO);
$this->setLand($land);
}

public function getRepo(): string
{
return $this->repo;
}

public function getISO(): string
{
return $this->ISO;
}

public function getLand(): string
{
return $this->land;
}

public function setRepo(string $repo): void
{
$this->repo = $repo;
}

public function setISO(string $ISO): void
{
$this->ISO = $ISO;
}

public function setLand(string $land): void
{
$this->land = $land;
}

private function checkRepo(): void
{
$repoContent = getWebsiteContent($this->getRepo());
$comparisonValue = getWebsiteContent('https://mirror.alpix.eu/endeavouros/repo/state');
$this->resultRepoCheck = ($repoContent == $comparisonValue) ? 'Up to date' : 'Not up to date';
}

private function checkISO(): void
{
$ISOContent = getWebsiteContent($this->getISO());
$comparisonValue = getWebsiteContent('https://mirror.alpix.eu/endeavouros/iso/state');
$this->resultISOCheck = ($ISOContent == $comparisonValue) ? 'Up to date' : 'Not up to date';
}

public function getResultRepoCheck(): ?string
{
$this->checkRepo();
return $this->resultRepoCheck;
}

public function getResultISOCheck(): ?string
{
$this->checkISO();
return $this->resultISOCheck;
}
}
?>

