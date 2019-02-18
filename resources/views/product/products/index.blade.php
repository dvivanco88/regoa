@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Productos</div>
                    <div class="card-body">
                        <a href="{{ url('/product/products/create') }}" class="btn btn-success btn-sm" title="Add New Product">
                            <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/product/products', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Precio de Compra</th>
                                        <th>Venta Base</th>
                                        <th>Venta Mayoreo</th>
                                        <th>Activo?</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>${{ $item->price_business }}</td>
                                        <td>${{ $item->price_wholesale }}</td>
                                        <td>${{ $item->price_retail }}</td>
                                        <td>@if ($item->is_active == 1)
                                            SI
                                            @else
                                            NO
                                        @endif</td>                                        
                                        <td>
                                            <a href="{{ url('/product/products/' . $item->id) }}" title="View Product"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                            <a href="{{ url('/product/products/' . $item->id . '/edit') }}" title="Edit Product"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></i></button></a>
                                            
                                            @if (Auth::user()->hasRole('Todo'))
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'url' => ['/product/products', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fas fa-trash-alt"></i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Product',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $products->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
