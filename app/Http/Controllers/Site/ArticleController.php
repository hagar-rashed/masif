<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Repositories\Contract\ArticleRepositoryInterface;
use App\Repositories\Contract\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $articleRepository;
    protected $categoryRepo;

    public function __construct(ArticleRepositoryInterface $articleRepository, CategoryRepositoryInterface $categoryRepo)
    {
        $this->articleRepository = $articleRepository;
        $this->categoryRepo      = $categoryRepo;
    }

    public function index()
    {
        $articles = $this->articleRepository->getAll();

        return view('site.news.index', compact('articles'));
    }

    public function show($id)
    {
        $article = $this->articleRepository->findOne($id);

        $latestArticles = $this->articleRepository->limit(3);

        $categories = $this->categoryRepo->getAll();

        return view('site.news.show', compact('article', 'categories', 'latestArticles'));
    }

    public function filter($id) // category id
    {
        $articles = $this->articleRepository->getWhere([['category_id', $id]]);

        return view('site.news.filter', compact('articles'));
    }
}
