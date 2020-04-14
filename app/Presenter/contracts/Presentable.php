<?php


namespace App\Presenter\contracts;


use phpDocumentor\Reflection\Types\This;

trait Presentable
{
    protected $presetnerInstance;

    public function present()
    {
        if (!$this->presenter || !class_exists($this->presenter)) {
            throw  new \Exception('Presenter Not Found!');
        }

        if (!$this->presetnerInstance) {
            $this->presetnerInstance = new $this->presenter($this);
        }

        return $this->presetnerInstance;
    }
}
