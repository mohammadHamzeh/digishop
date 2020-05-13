<?php


namespace App\Support\Storage\contracts;


interface StorageInterface
{
    public function all();

    public function get($index);

    public function exists($index);

    public function set($index, $value);

    public function unset($index);

    public function clear();

    public function count();
}
