<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\admin\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =  Category::Admin()->paginate(10);
        $data = CategoryResource::collection($data)->resource;
        return $this->helper()->response(
            Message::FETCH(),
            $data
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        DB::beginTransaction();
        $category =  Category::create($request->validated());
        if ($image = $request->banner_image){
            $this->fileUpload([
                'model' => $category,
                'request_type' => 'base64',
                'collection_name' => Category::BANNER_COLLECTION()->name,
                'file' => $image,
            ]);
        }
        if ($image = $request->icon_image){
            $this->fileUpload([
                'model' => $category,
                'request_type' => 'base64',
                'collection_name' => Category::ICON_COLLECTION()->name,
                'file' => $image
            ]);
        }
        DB::commit();
        return $this->helper()->response(
            Message::CREATED(),
            CategoryResource::make($category)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        if ($image = $request->banner_image){
            $collection = Category::BANNER_COLLECTION()->name;
            $this->deleteAllMedia($category, $collection);
            $this->fileUpload([
                'model' => $category,
                'request_type' => 'base64',
                'collection_name' => $collection,
                'file' => $image,
            ]);
        }
        if ($image = $request->icon_image){
            $collection = Category::ICON_COLLECTION()->name;
            $this->deleteAllMedia($category, $collection);
            $this->fileUpload([
                'model' => $category,
                'request_type' => 'base64',
                'collection_name' => $collection,
                'file' => $image
            ]);
        }
        return $this->helper()->response(
            Message::UPDATED(),
            CategoryResource::make($category)
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return $this->helper()->response(
                Message::DELETED(),
                CategoryResource::make($category)
            );
        }
        catch (\Exception $exception){
            return 'hello';
        }
    }

    /**
     *show the specified resource from storage.
     */
    public function show(Category $category)
    {
        try {
            $category = CategoryResource::make($category);
            return $this->helper()->response(
                Message::FETCH(),
                $category
            );
        }
        catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

}
