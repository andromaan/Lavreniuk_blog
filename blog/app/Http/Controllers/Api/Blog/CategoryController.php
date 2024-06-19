<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Blog\BaseController;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    public function index()
    {
        return BlogCategory::with('parentCategory')->get();
    }

    public function show(string $id)
    {
        $item = BlogCategory::with('parentCategory')->find($id);
        if (empty($item)) {
            abort(404);
        }
        return $item;
    }

    public function create(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        $item = (new BlogCategory())->create($data);
        return response()->json(['success' => 'Category created successfully', 'category' => $item], 201);
    }

    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запис id=[{$id}] не знайдено"])
                ->withInput();
        }

        $data = $request->all();
        $result = $item->update($data);

        if ($result) {
            return response()->json(['success' => 'Category updated successfully'], 200);
        } else {
            return response()->json(['error' => "The update could not be completed due to a conflict with the current state of the resource."], 409);
        }
    }
}
