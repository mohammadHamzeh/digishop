<?php


namespace App\Presenter\contracts;

trait Presentable
{
    protected $presenterInstance;

    public function present()
    {
        if (!$this->presenter || !class_exists($this->presenter)) {
            throw  new \Exception('Presenter Not Found!');
        }

        if (!$this->presenterInstance) {
            $this->presenterInstance = new $this->presenter($this);
        }

        return $this->presenterInstance;
    }
}
