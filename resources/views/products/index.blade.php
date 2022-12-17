@extends('layouts.master')

@section('content')
  <div class="card">
    <div class="card-body">
        <div clas="d-flex">
            <a href="{{route('products.create')}}" class="btn btn-primary ms-auto">Add Product</a>
        </div>
      @if($products->isEmpty())
          <h3 class="text-center">You have not added any product.</h3>
      @else
          <div class="table-responsive">
              <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                  <tr>
                      <th width="100">#</th> 
                      <th class="text-wrap">Name</th>
                      <th class="text-wrap">Price</th>
                      <th class="text-wrap">Description</th>
                      <th class="text-wrap">Images</th>
                      <th width="100">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $count = 1; ?>
                  @foreach($products as $product)
                      <tr class="item-row-{{$product->id}}">
                            <td>{{$count}}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->name }}</td>
                            <td><a class="btn btn-primary btn-sm" href="{{ route('products.edit', $product->id) }}">
                            <i class="fa fa-pencil" title="Edit Product"></i></a>
                                <a class="btn btn-danger btn-sm" href="#product-delete-modal-{{$product->id}}" data-bs-toggle="modal">
                              <i class="fa fa-trash" title="Edit package"></i></a>
                            @include('common._confirm_modal', [
                                'modalId' => "product-delete-modal-{$product->id}",
                                'title' => "Delete confirmation",
                                'id' => $product->id,
                                'action' => route('products.destroy', $product->id),
                                'message' => "Do you want to delete an product?",
                                'warning' => "",
                                'type' => "danger"
                            ])
                            </td>
                      </tr>
                      <?php $count++ ?>
                  @endforeach
                  </tbody>
              </table>

              <div class="d-flex">{{$products->links()}}</div>
          </div>
      @endif
    </div>
  </div>
@endsection



