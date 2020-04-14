<?php


namespace App\Presenter\contracts;


class Presenter
{
    protected $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }

        return $this->object->{$property};
    }
}
