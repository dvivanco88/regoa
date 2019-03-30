@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Inventario {{ $inventory->id }}</div>
                <div class="card-body">

                    <a href="{{ url('/inventory/inventories') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                    <a href="{{ url('/inventory/inventories/' . $inventory->id . '/edit') }}" title="Editar Inventario"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></i> Editar</button></a>
                    {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['inventory/inventories', $inventory->id],
                        'style' => 'display:inline'
                        ]) !!}

                        @if (Auth::user()->hasRole('Todo'))
                        {!! Form::button('<i class="fas fa-trash-alt"></i> Eliminar', array(
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-sm',
                            'title' => 'Eliminar Inventario',
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
                                            <th>ID</th><td>{{ $inventory->id }}</td>
                                        </tr>
                                        <tr><th> Almacén </th><td> {{ $inventory->warehouse->name }} </td></tr>
                                        <tr><th> Producto </th><td> {{ $inventory->product->name }} </td>
                                        </tr>
                                        <tr><th> Cantidad </th><td> {{ $inventory->quantity }} </td>
                                        </tr>
                                        <tr>
                                            <th> Activo? </th>
                                            <td> @if ($inventory->is_active == 1)
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
