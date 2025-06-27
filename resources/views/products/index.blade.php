@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Products</h2>
            </div>
            @can('create', App\Models\Product::class)
                <div class="pull-right">
                    <a class="btn btn-success btn-sm mb-2" href="{{ route('products.create') }}"><i class="fa fa-plus"></i> Create
                        New Product</a>
                </div>
            @endcan

            @can('archive', App\Models\Product::class)
                <div class="pull-right">
                    <a class="btn btn-success btn-sm mb-2" href="{{ route('product.archive') }}"><i class="fa fa-flag"></i>
                        Product Archive</a>
                </div>
            @endcan

            @if ($publish)
                <button type="button" class="btn btn-secondary btn-sm">
                    <i class="fa-solid fa-eye"></i>
                    You have authorized for <b>{{ $publish }}</b>
                </button>
            @endif

            @if ($approve)
                <button type="button" class="btn btn-info btn-sm">
                    <i class="fa-solid fa-pen"></i>
                    You have authorized for <b>{{ $approve }}</b>
                </button>
            @endif

            @if ($archive)
                <button type="button" class="btn btn-warning btn-sm">
                    <i class="fa-solid fa-flag"></i>
                    You have authorized for <b>{{ $archive }}</b>
                </button>
            @endif

        </div>
    </div>

    @session('success')
        <div class="alert alert-success" role="alert">
            {{ $value }}
        </div>
    @endsession
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Product Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($products as $i => $product)
            @can('viewAny', App\Models\Product::class)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->detail }}</td>
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @can('view', $product)
                                <a class="btn btn-info btn-sm" href="{{ route('products.show', $product->id) }}"><i
                                        class="fa-solid fa-list"></i> Show</a>
                            @endcan
                            @can('update', $product)
                                <a class="btn btn-primary btn-sm" href="{{ route('products.edit', $product->id) }}"><i
                                        class="fa-solid fa-pen-to-square"></i> Edit</a>
                            @endcan
                            @can('publish', $product)
                                <a class="btn btn-secondary btn-sm" href="{{ route('product.publish', $product->id) }}"><i
                                        class="fa-solid fa-eye-to-square"></i> Publish</a>
                            @endcan
                            @can('approve', $product)
                                <a class="btn btn-success btn-sm" href="{{ route('product.approve', $product->id) }}"><i
                                        class="fa-solid fa-recycle-to-square"></i> Approve</a>
                            @endcan
                            @csrf
                            @method('DELETE')
                            @can('delete', $product)
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                                    Delete</button>
                            @endcan
                        </form>
                    </td>
                </tr>
            @endcan
        @endforeach
    </table>
    {!! $products->links() !!}
@endsection
