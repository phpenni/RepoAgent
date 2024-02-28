<?php
$comparisonUrl = 'https://mirror.alpix.eu/endeavouros/repo/state';

class MirrorList
{
    public array $mirrors = [];
    //tier1

    public function getMirrors(): array
    {
        return $this->mirrors;
    }

    public function add(Mirror $param): void
    {
        $this->mirrors[] = $param;
    }
}



