<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Storage;
use App\Services\Back\Educations\ProductAdminService;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductAdminService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->service->index();
        return $this->service->view('index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->service->view('form', $this->service->create());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $productData = $request->validated();
        $categoryIds = $productData['category_id'];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
            $productData['image'] = $imagePath;
        }

        unset($productData['category_id']);
        $product = $this->service->store($productData);

        $product->categories()->attach($categoryIds);
        return $this->service->redirect();
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
        return $this->service->view('form', $this->service->edit($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrfail($id);
        $productData = $request->validated();
        $categoryIds = $productData['category_id'];
        unset($productData['category_id']);

        if ($request->hasFile('image')) {
            // Store the new image and update the image path
            $imagePath = $request->file('image')->store('product_images', 'public');
            $productData['image'] = $imagePath;

            // Delete the old image if it exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
        }

        $this->service->update($productData, $product->id);
        $product->categories()->sync($categoryIds);

        return $this->service->redirect();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete associated file
        if ($product->image) {
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
        }

        $product->delete();
        return response()->json(['success' => true]);
    }
}
