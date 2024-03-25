<?php
class MirrorList
{
    private array $mirrors = [];

    public function getMirrors(): array
    {
        return $this->mirrors;
    }

    public function add(Mirror $mirror): void
    {
        $this->mirrors[] = $mirror;
    }
}