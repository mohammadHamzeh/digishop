<?php

namespace App\Http\Controllers\Frontend;

use App\Filters\Frontend\ProductFilters;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->productFrontend()->filters(new ProductFilters())->paginate(6);
        return view('frontend.products', compact('products'));
    }
}
