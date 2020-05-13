<?php


namespace App\Support\Storage;


use App\Repositories\Contracts\CartRepositoryInterface;
use App\Support\Storage\contracts\StorageInterface;
use phpDocumentor\Reflection\Types\Null_;

class DatabaseStorage implements StorageInterface
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    public function __construct()
    {
        $this->cartRepository = resolve(CartRepositoryInterface::class);
    }

    public function all()
    {
        $cart_items = $this->getCart()->cart_items;
        $product_id = [];
        foreach ($cart_items as $item) {
            $product_id[$item->product_id] = [];
        }
        return $product_id;
    }

    public function get($index)
    {

        return $this->getCart()->cart_items->where('product_id', $index)->first();
    }

    public function exists($index)
    {
        return $this->getCart()->cart_items()->where('product_id', $index)->exists();
    }

    public function set($index, $value)
    {
        if ($this->getCart()->cart_items()->where('product_id', $index)->exists()) {
            return $this->getCart()->cart_items()->where('product_id', $index)->update([
                'quantity' => $value['quantity']
            ]);
        }
        return $this->getCart()->cart_items()->create([
            'product_id' => $index,
            'quantity' => $value['quantity']
        ]);
    }

    public function unset($index)
    {
        return $this->getCart()->cart_items()->where('product_id', $index)->delete();
    }

    public function clear()
    {
        return $this->getCart()->cart_items()->where('cart_id', $this->getCart()->id)->delete();
    }

    public function count()
    {
        return $this->getCart()->cart_items()->where('cart_id', $this->getCart()->id)->count();
    }

    /**
     * @return mixed
     */
    private function getCart()
    {
        $cart = $this->cartRepository->findBy(['user_id' => auth()->user()->id], ['id'], true);
        return $cart;
    }
}
