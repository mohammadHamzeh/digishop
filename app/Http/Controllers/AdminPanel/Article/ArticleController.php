<?php

namespace App\Http\Controllers\AdminPanel\Article;

use App\Filters\AdminPanel\ArticleFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\MetaTag;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\MetaTagRepositoryInterface;
use App\Repositories\Contracts\TagRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    /**
     * @var ArticleRepositoryInterface
     */
    protected $articleRepository;
    protected $categoryRepository;
    protected $tagRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = resolve(CategoryRepositoryInterface::class);
        $this->tagRepository = resolve(TagRepositoryInterface::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $articles = $this->articleRepository->filters(new ArticleFilters())->with(['creator', 'editor'])->paginate(6);
        $articleStatues = $this->articleRepository->articleStatues();
        return view('admin.articles.index', compact('articles', 'articleStatues'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->getAllCategoriesGroupByParent();
        $tags = $this->tagRepository->all();
        $articleStatus = $this->articleRepository->articleStatues();
        return view('admin.articles.create', compact('categories', 'tags', 'articleStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleRequest $request
     * @return void
     */
    public function store(ArticleRequest $request)
    {

        $article = $this->StoreArticleAndImage($request);

        $ArticleTags = $this->tagStoreOrFind($request->tags);
        $article->tags()->sync($ArticleTags);

        $meta_datas = $this->StoreMetaDatasAndImage($request, $article);


        $categories = $this->storeCategories($request->categories, $article);

        return response()->json([
            'success' => true
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Article $article
     * @return void
     */
    public function edit(Article $article)
    {
        $article->load(['meta_tag']);
        $allCategories = $this->categoryRepository->all();
        $tags = '';
        foreach ($article->tags->pluck('title')->toArray() as $tag) {
            $tags .= ',' . $tag;
        }
        $tags = substr($tags, 1);
        $categories = $article->categories->pluck('id')->toArray();
        $articleStatus = $this->articleRepository->articleStatues();
        return view('admin.articles.edit', compact('categories', 'tags', 'article', 'articleStatus', 'allCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Article $article
     * @return void
     */
    public function update(Request $request, Article $article)
    {
        $resultUpdateArticle = $this->UpdateArticleAndImage($request, $article->id);

        $ArticleTags = $this->tagStoreOrFind($request->tags);
        $article->tags()->sync($ArticleTags);

        $meta_datas = $this->UpdateMetaDatasAndImage($request, $article);

        $categories = $this->storeCategories($request->categories, $article);

        return response()->json([
            'success' => true
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->categories()->sync([]);
        $article->tags()->sync([]);
        $article->meta_tag()->delete();
        $article->delete();
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
        $ArticleTags = [];
        foreach ($tags as $tag) {
            $tagTrim = Str::of($tag)->trim();
            $resultSearch = $this->tagRepository->findBy(['title' => $tagTrim]);
            if (is_null($resultSearch)) {
                $resultTagStore = $this->tagRepository->store([
                    'title' => $tagTrim
                ]);
                array_push($ArticleTags, $resultTagStore->id);
            } else {
                array_push($ArticleTags, $resultSearch->id);
            }
        }
        return $ArticleTags;
    }

    /**
     * @param Request $request
     * @return Article
     */
    private function StoreArticleAndImage(Request $request): Article
    {
        $article = $this->articleRepository->store([
            'title' => $request->title,
            'description' => $request->description,
            'text' => $request->text,
            'slug' => $request->title,
            'author_id' => $request->user('admin')->id,
            'status' => $request->articleStatus
        ]);
        /*Save image Article s*/
        $articleImage = $request->file('blog_img');
        $nameImage = $article->id . '.' . $articleImage->getClientOriginalExtension();
        $path = $articleImage->storeAs('articles', $nameImage);
        $article->update([
            'image' => $path
        ]);
        /*End Store Article image  */
        return $article;
    }

    /**
     * @param Request $request
     * @param Article $article
     * @return MetaTag
     */
    private function StoreMetaDatasAndImage(Request $request, Article $article): MetaTag
    {
        $meta_data = $article->meta_tag()->create([
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
     * @param Article $article
     */
    private function storeCategories($categories, Article $article)
    {
        $categories = $categories == null ? [] : array_values(explode(',', $categories));
        $article->categories()->sync($categories);
    }

    private function UpdateArticleAndImage(Request $request, $id)
    {
        $article = $this->articleRepository->update($id, [
            'title' => $request->title,
            'description' => $request->description,
            'text' => $request->text,
            'slug' => $request->title,
            'author_id' => $request->user('admin')->id,
            'status' => $request->articleStatus
        ]);
        /*Save image Article s*/
        $articleImage = $request->file('blog_img');
        if (!is_null($articleImage)) {
            $nameImage = $article->id . '.' . $articleImage->getClientOriginalExtension();
            $path = $articleImage->storeAs('articles', $nameImage);
            $article->update([
                'image' => $path
            ]);
        }
        /*End Store Article image  */
        return $article;
    }

    private function UpdateMetaDatasAndImage(Request $request, $article)
    {
        $meta_data = $article->meta_tag()->update([
            'title' => $request->meta_data_title,
            'description' => $request->meta_data_description,
            'keyword' => $request->meta_data_keyword,
            'author' => $request->meta_data_author
        ]);
        $meta_data_image = $request->file('meta_data_image');
        if (!is_null($meta_data_image)) {
            $nameImage = $article->meta_tag->id . '.' . $meta_data_image->getClientOriginalExtension();
            $path = $meta_data_image->storeAs('meta_datas', $nameImage);
            $meta_data->update([
                'image' => $path
            ]);
        }
        return $meta_data;
    }
}
