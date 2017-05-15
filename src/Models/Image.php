<?php

namespace SampleGalleryPhp\Models;

class Image
{
    protected $id;
    protected $name;
    protected $path;
    protected $thumbnail;
    protected $description;
    protected $mime;
    protected $created_at;
    protected $updated_at;

    public function __construct($attrs = [])
    {
        foreach ($attrs as $attr => $value) {
            $this->$attr = $value;
        }
    }

    public function __get($key) {
        ////TODO whitelist visible properties
        return $this->$key;
    }
}
