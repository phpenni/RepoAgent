<?php

class Mirrorlist
{

    // Array pflegen

    public array $mirrors = array();

    public function getMirrors(): array
    {
        return $this->mirrors;
    }

    public function setMirrors(array $mirrors): void
    {
        $this->mirrors = $mirrors;
    }

    public function addMirror(Mirror $mirror): void
    {
        $this->mirrors[] = $mirror;
    }

    public function add(Mirror $param)
    {
        $this->mirrors [] = $param;
    }
}