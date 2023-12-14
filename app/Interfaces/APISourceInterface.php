<?php

namespace App\Interfaces;

interface APISourceInterface
{
    public function getPublication(string $doi);
}