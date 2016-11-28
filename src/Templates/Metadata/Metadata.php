<?php

namespace Labcoat\Templates\Metadata;

class Metadata implements MetadataInterface
{
    protected $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
