<?php

namespace App\Http\Controllers\AdminPanel\Shop;

use App\Filters\AdminPanel\ProductFilter;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\MetaTag;
use App\Models\Shop\Product;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\TagRepositoryInterface;
use http\Env\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    protected $categoryRepository;
    protected $tagRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = resolve(CategoryRepositoryInterface::class);
        $this->tagRepository = resolve(TagRepositoryInterface::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->filters(new ProductFilter())->paginate(config('paginate.per_page'));
        $productStatues  = $this->productRepository->productStatuses();
        return view('admin.products.index', compact('products', 'productStatues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->getAllCategoriesGroupByParent();
        $tags = $this->productRepository->all();
        $productStatus = $this->productRepository->productStatuses();
        return view('admin.products.create', compact('categories', 'tags', 'productStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $this->StoreProductAndImage($request);

        $productTags = $this->tagStoreOrFind($request->tags);
        $product->tags()->sync($productTags);

        $meta_datas = $this->StoreMetaDatasAndImage($request, $product);


        $categories = $this->storeCategories($request->categories, $product);

        return response()->json([
            'success' => true
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product->load(['meta_tag']);
        $allCategories = $this->categoryRepository->all();
        $tags = '';
        foreach ($product->tags->pluck('title')->toArray() as $tag) {
            $tags .= ',' . $tag;
        }
        $tags = substr($tags, 1);
        $categories = $product->categories->pluck('id')->toArray();
        $productStatus = $this->productRepository->productStatuses();
        return view('admin.products.edit', compact('categories', 'tags', 'product', 'productStatus', 'allCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return void
     */
    public function update(Request $request, Product $product)
    {

        //        try {
        $this->productRepository->beginTransaction();
        $resultUpdateProduct = $this->UpdateProductAndImage($request, $product->id);

        $ProductTags = $this->tagStoreOrFind($request->tags);
        $product->tags()->sync($ProductTags);

        $meta_datas = $this->UpdateMetaDatasAndImage($request, $product);

        $categories = $this->storeCategories($request->categories, $product);
        $this->productRepository->commit();
        //        } catch (\Exception $e) {
        //            $this->productRepository->rollback();
        //            throw new HttpResponseException(
        //                response()->json([
        //                    'error' => __('response.errorTransaction'),
        //                    'error_type' => 'test',
        //                ], 422)
        //            );
        //        }


        return response()->json([
            'success' => true
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        try {
            $this->productRepository->beginTransaction();
            $product->categories()->sync([]);
            $product->tags()->sync([]);
            $product->meta_tag()->delete();
            Storage::delete($product->image);
            $product->delete();
            $this->productRepository->commit();
        } catch (\Exception $e) {
            $this->productRepository->rollback();
            return response()->json([
                'error' => 'مشکلی در هنگام عملیات پیش آمده لطفا بعدا امتحان کنید'
            ], 422);
        }

        return \response()->json([
            'success' => true
        ], 200);
    }

    private function getAllCategoriesGroupByParent()
    {
        $allCategories = $this->categoryRepository->all();
        $categories = $allCategories->groupBy('parent_id');
        if (!$categories->isEmpty()) {
            $categories['root'] = $categories[''];
            unset($categories['']);
        }
        return $categories;
    }

    /**
     * @param $tags
     * @return array
     */
    private function tagStoreOrFind($tags)
    {
        $tags = Str::of($tags)->explode(',');
        $productTags = [];
        foreach ($tags as $tag) {
            $tagTrim = Str::of($tag)->trim();
            $resultSearch = $this->tagRepository->findBy(['title' => $tagTrim]);
            if (is_null($resultSearch)) {
                $resultTagStore = $this->tagRepository->store([
                    'title' => $tagTrim
                ]);
                array_push($productTags, $resultTagStore->id);
            } else {
                array_push($productTags, $resultSearch->id);
            }
        }
        return $productTags;
    }

    /**
     * @param Request $request
     * @return Product
     */
    private function StoreProductAndImage(Request $request): Product
    {
        $product = $this->productRepository->store([
            'title' => $request->title,
            'description' => $request->description,
            'text' => $request->text,
            'slug' => Str::of($request->title)->replace(' ', '-'),
            'stock' => $request->stock,
            'price' => Str::of($request->price)->replace(',', ''),
            'status' => $request->status
        ]);
        /*Save image Product s*/
        $productImage = $request->file('product_img');
        $nameImage = $product->id . '.' . $productImage->getClientOriginalExtension();
        $path = $productImage->storeAs('products', $nameImage);
        $product->update([
            'image' => $path
        ]);
        /*End Store Product image  */
        return $product;
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return MetaTag
     */
    private function StoreMetaDatasAndImage(Request $request, Product $product): MetaTag
    {
        $meta_data = $product->meta_tag()->create([
            'title' => $request->meta_data_title,
            'description' => $request->meta_data_description,
            'keyword' => $request->meta_data_keyword,
            'author' => $request->meta_data_author
        ]);
        $meta_data_image = $request->file('meta_data_image');
        $nameImage = $meta_data->id . '.' . $meta_data_image->getClientOriginalExtension();
        $path = $meta_data_image->storeAs('meta_datas', $nameImage);
        $meta_data->update([
            'image' => $path
        ]);
        return $meta_data;
    }

    /**
     * @param $categories
     * @param Product $product
     */
    private function storeCategories($categories, Product $product)
    {
        $categories = $categories == null ? [] : array_values(explode(',', $categories));
        $product->categories()->sync($categories);
    }

    private function UpdateProductAndImage(Request $request, $id)
    {
        $product = $this->productRepository->update($id, [
            'title' => $request->title,
            'description' => $request->description,
            'text' => $request->text,
            'slug' => Str::of($request->title)->replace(' ', '-'),
            'stock' => $request->stock,
            'price' => Str::of($request->price)->replace(',', ''),
            'status' => $request->status
        ]);
        $product = $this->productRepository->find($id);
        /*Save image Product s*/
        $productImage = $request->file('product_img');
        if (!is_null($productImage)) {
            $nameImage = $product->id . '.' . $productImage->getClientOriginalExtension();
            $path = $productImage->storeAs('products', $nameImage);
            $product->update([
                'image' => $path
            ]);
        }
        /*End Store Product image  */
        return $product;
    }

    private function UpdateMetaDatasAndImage(Request $request, $product)
    {
        $meta_data = $product->meta_tag()->update([
            'title' => $request->meta_data_title,
            'description' => $request->meta_data_description,
            'keyword' => $request->meta_data_keyword,
            'author' => $request->meta_data_author
        ]);
        $meta_data_image = $request->file('meta_data_image');
        if (!is_null($meta_data_image)) {
            $nameImage = $product->meta_tag->id . '.' . $meta_data_image->getClientOriginalExtension();
            $path = $meta_data_image->storeAs('meta_datas', $nameImage);
            $meta_data->update([
                'image' => $path
            ]);
        }
        return $meta_data;
    }

    public function changeStatus(Request $request, Product $product)
    {
        $product->update(['status' => $product->status ? 2 : 1]);
        return response(['success' => true, 'state' => $product->status]);
    }
}
