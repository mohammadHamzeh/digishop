<?php


namespace App\Support\Storage;


use App\Support\Storage\contracts\StorageInterface;
use Illuminate\Support\Facades\Redis;

class RedisStorage implements StorageInterface, \Countable
{

    private $bucket;

    public function __construct($bucket = null)
    {
        $this->bucket = $bucket;
        /*use the lists for store Basket
         prefix=>[
            user_id=> product_id quantity product_id2 quantity2
        ];
        */
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function get($index)
    {
        // TODO: Implement get() method.
    }

    public function exists($index)
    {
        // TODO: Implement exists() method.
    }

    public function set($index, $value)
    {
        // TODO: Implement set() method.
    }

    public function unset($index)
    {
        // TODO: Implement unset() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }

    public function count()
    {
        // TODO: Implement count() method.
    }
}


