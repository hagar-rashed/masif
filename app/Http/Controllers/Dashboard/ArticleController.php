<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ArticleRequest;
use App\Repositories\Contract\ArticleRepositoryInterface;
use Illuminate\Http\Request;
use Alkoumi\LaravelHijriDate\Hijri;
use App\Jobs\NotifyEmailJob;
use App\Models\Article;
use App\Repositories\Contract\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    protected $articleRepository;
    protected $categoryRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->articleRepository  = $articleRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->articleRepository->getWith(['category']);

        return view('dashboard.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = $this->categoryRepository->getAll();

        return view('dashboard.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $data = $request->all();

        // if ($request->hasFile('image')) {
        //     $data['image'] = $request->file('image')->store('articles');
        // }

        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('articles');
            }
        }

        if (!empty($images)) {
            $data['images'] = json_encode($images); // Convert the array to a JSON string
        }

        $article = $this->articleRepository->create($data);

        if ($article) {
            return redirect()->route('admin.articles.index')->with('success', __('models.added_success'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإضافة');
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = $this->articleRepository->findOne($id);

        $categories = $this->categoryRepository->getAll();

        if ($article) {
            return view('dashboard.articles.edit', compact('article', 'categories'));
        } else {
            return view('dashboard.error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $article = $this->articleRepository->findOne($id);

        $data = $request->except('_token', '_method');

        // if ($request->hasFile('image')) {

        //     Storage::delete($article->image);

        //     $data['image'] = $request->file('image')->store('articles');
        // } else {

        //     $data['image'] = $article->image;
        // }


        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('articles');
            }

            if (!empty($images)) {
                $existingImages = json_decode($article->images, true) ?? []; // Retrieve existing images as an array
                $deletedImages = $request->input('deleted_images', []); // Get the deleted images from the request
                $updatedImages = array_merge($existingImages, $images); // Merge existing and new images
                $updatedImages = array_diff($updatedImages, $deletedImages); // Remove deleted images from the updated set
                $data['images'] = json_encode($updatedImages); // Convert the updated images array to a JSON string
            }
        }


        $article->update($data);

        if ($article) {
            return redirect()->route('admin.articles.index')->with('success', __('models.update_success'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ أثناء التعديل');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $article = $this->articleRepository->findOne($request->id);

        if ($article->image) {
            Storage::delete($article->image);
        }

        $article->delete();

        return \response()->json([
            'message' => 'تم الحذف بنجاح',
        ]);
    }

    public function deleteImage(Request $request)
    {
        $articleId = $request->article_id;
        $imageId = $request->image_id;

        // Retrieve the article
        $article = Article::find($articleId);

        if ($article) {
            // Find the image by ID within the 'images' column
            $images = json_decode($article->images, true);
            $updatedImages = [];
            $deletedImage = null;

            foreach ($images as $index => $image) {
                if ($index != $imageId) {
                    $updatedImages[] = $image;
                } else {
                    $deletedImage = $image;
                }
            }

            // Delete the image from storage
            if ($deletedImage && Storage::exists($deletedImage)) {
                Storage::delete($deletedImage);
            }

            // Update the 'images' column with the updated array
            $article->images = json_encode($updatedImages);
            $article->save();

            return response()->json(['message' => 'Image deleted successfully']);
        } else {
            return response()->json(['message' => 'Article not found'], 404);
        }
    }
}
