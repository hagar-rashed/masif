<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Repositories\Contract\BrandRepositoryInterface;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandRepo;

    public function __construct(BrandRepositoryInterface $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    public function partners()
    {
        $partners = $this->brandRepo->getWhere([['type', 'partner']]);

        $clients = $this->brandRepo->limit(12);

        return view('site.partners', compact('partners', 'clients'));
    }

    public function clients()
    {
        $clients = $this->brandRepo->paginateGetWhere([['type', 'client']], 24);

        return view('site.clients', compact('clients'));
    }
}
