<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Repositories\Contract\VideoRepositoryInterface;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected $videoRepository;

    public function __construct(VideoRepositoryInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function index()
    {
        $videos = $this->videoRepository->paginate(3);

        return view('site.videos.index', compact('videos'));
    }

    public function show($id)
    {
        $video = $this->videoRepository->findOne($id);

        $videos = $this->videoRepository->limit(3);

        return view('site.videos.show', compact('video', 'videos'));
    }
}
