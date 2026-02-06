<?php

namespace App\Traits;

trait indexDirect
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
