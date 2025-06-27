<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Product::class);

        $products = Product::latest()->paginate(5);
        $publish = '';
        $approve = '';
        $archive = '';
        return view('products.index', compact('approve', 'products', 'archive', 'publish'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Product::class);

        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Product::class); // ✅ Fixed here

        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $this->authorize('view', $product);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $this->authorize('update', $product);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function approve(Product $product)
    {
        $this->authorize('approve', $product);

        // // Logic for approval
        // $product->status = 'approved';
        // $product->save();

        $products = Product::latest()->paginate(5);
        $approve = 'Approve';
        $publish = '';
        $archive = '';

        return view('products.index', compact('approve', 'products', 'archive', 'publish'));
    }
    public function publish(Product $product)
    {
        $this->authorize('publish', $product);

        $products = Product::latest()->paginate(5);
        $publish = 'Publish';
        $approve = '';
        $archive = '';

        return view('products.index', compact('approve', 'products', 'archive', 'publish'));
    }

    public function archive()
    {
        $this->authorize('archive', Product::class);

        $products = Product::latest()->paginate(5);
        $publish = '';
        $approve = '';
        $archive = 'Archive';

        return view('products.index', compact('approve', 'products', 'archive', 'publish'));
    }
}
