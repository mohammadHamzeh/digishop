<?php


namespace App\Support\Basket;


use App\Exceptions\Basket\QuantityExeededException;
use App\Models\Shop\Product;
use App\Presenter\contracts\Presentable;
use App\Presenter\Frontend\BasketPresenter;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Support\Storage\contracts\StorageInterface;

class Basket
{
    use Presentable;
    protected $presenter = BasketPresenter::class;

    /**
     * @var ProductRepositoryInterface
     */
    private $storage;
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->storage = resolve(StorageInterface::class);
        $this->productRepository = $productRepository;
    }

    public function add(Product $product, $quantity)
    {
        if ($this->has($product)) {
            $quantity = $this->storage->get($product->id)['quantity'] + $quantity;
        }
        $this->update($product, $quantity);
    }

    public function has(Product $product)
    {
        return $this->storage->exists($product->id);
    }

    public function all()
    {
        $products = $this->productRepository->find(array_keys($this->storage->all()));
        foreach ($products as $product) {
            $product->quantity = $this->storage->get($product->id)['quantity'];
        }
        return $products;
    }

    public function itemCount()
    {
        return $this->storage->count();
    }

    public function subTotal()
    {
        $products = $this->all();
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $product->quantity;
        }
        return $total;
    }


    public function update(Product $product, $quantity)
    {
        if (!$product->hasStock($quantity)) {
            throw  new QuantityExeededException();
        }
        if ($quantity == 0)
            return $this->storage->unset($product->id);
        return $this->storage->set($product->id, [
            'quantity' => $quantity
        ]);
    }

    public function clear()
    {
        return $this->storage->clear();
    }

}
