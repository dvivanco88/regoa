@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Producto {{ $product->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/product/products') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                        <a href="{{ url('/product/products/' . $product->id . '/edit') }}" title="Edit Product"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></i> Editar</button></a>
                        
                        @if (Auth::user()->hasRole('Todo'))
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['product/products', $product->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fas fa-trash-alt"></i> Eliminar', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete Product',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        @endif
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $product->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Nombre </th>
                                        <td> {{ $product->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Precio de Compra </th>
                                        <td> ${{ $product->price_business }} </td>
                                    </tr>
                                    <tr>
                                        <th> Venta Base </th>
                                        <td> ${{ $product->price_wholesale }} </td>
                                    </tr>
                                    <tr>
                                        <th> Venta Mayoreo </th>
                                        <td> ${{ $product->price_retail }} </td>
                                    </tr>
                                    <tr>
                                        <th> Activo? </th>
                                        <td> @if ($product->is_active == 1)
                                            SI
                                            @else
                                            NO
                                        @endif </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
