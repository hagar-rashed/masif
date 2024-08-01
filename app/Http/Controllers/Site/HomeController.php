<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\MailListRequest;
use App\Models\Article;
use App\Repositories\Contract\ArticleRepositoryInterface;
use App\Repositories\Contract\BrandRepositoryInterface;
use App\Repositories\Contract\MailListRepositoryInterface;
use App\Repositories\Contract\SectorRepositoryInterface;
use App\Repositories\Contract\ServiceRepositoryInterface;
use App\Repositories\Contract\SolutionRepositoryInterface;
use App\Repositories\Contract\ValueRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $serviceRepo;
    protected $articleRepo;
    protected $brandRepo;
    protected $valueRepo;
    protected $solutionRepo;
    protected $sectorRepo;
    protected $mailListRepo;

    public function __construct(
        ServiceRepositoryInterface $serviceRepo,
        ArticleRepositoryInterface $articleRepo,
        BrandRepositoryInterface $brandRepo,
        ValueRepositoryInterface $valueRepo,
        SolutionRepositoryInterface $solutionRepo,
        SectorRepositoryInterface $sectorRepo,
        MailListRepositoryInterface $mailListRepo
    ) {
        $this->serviceRepo  = $serviceRepo;
        $this->articleRepo  = $articleRepo;
        $this->brandRepo    = $brandRepo;
        $this->valueRepo    = $valueRepo;
        $this->solutionRepo = $solutionRepo;
        $this->sectorRepo   = $sectorRepo;
        $this->mailListRepo = $mailListRepo;
    }

    public function index()
    {
        $services = $this->serviceRepo->getAll(['column' => 'id', 'dir' => 'ASC']);

        $news = $this->articleRepo->limit(5);

        $clients = $this->brandRepo->limitGetWhere([['type', 'client']], 12)->get();

        return view('site.home', compact('services', 'news', 'clients'));
    }

    public function about()
    {
        $values = $this->valueRepo->getAll();

        $clients = $this->brandRepo->limitGetWhere([['type', 'client']], 12)->get();

        return view('site.about', compact('values', 'clients'));
    }

    public function solutions()
    {
        $solutions = $this->solutionRepo->getAll(['column' => 'id', 'dir' => 'ASC']);

        $clients = $this->brandRepo->limitGetWhere([['type', 'client']], 12)->get();

        return view('site.solutions', compact('solutions', 'clients'));
    }

    public function sectors()
    {
        $sectors = $this->sectorRepo->getAll();

        return view('site.sectors', compact('sectors'));
    }

    // search
    public function search(Request $request)
    {
        $search = $request->search;

        $articles = Article::query()->where(function ($q) use ($search) {
            $q->where('title_ar', 'LIKE', "%{$search}%")
                ->orWhere('title_en', 'LIKE', "%{$search}%");
        })->get();

        return response()->json([
            'status' => 'success',
            'result' => $articles,
        ]);
    } // end of search

    public function mailList(MailListRequest $request)
    {
        $this->mailListRepo->create($request->all());

        return redirect()->back()->with('success', __('models.subscription_success'));
    } // end of mailList
}
