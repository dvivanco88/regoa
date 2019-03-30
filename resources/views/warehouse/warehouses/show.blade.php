@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Warehouse {{ $warehouse->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/warehouse/warehouses') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                        @if (Auth::user()->hasRole('Todo') || Auth::user()->hasRole('Admin'))
                        <a href="{{ url('/warehouse/warehouses/' . $warehouse->id . '/edit') }}" title="Editar Almacen"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></i> Editar</button></a>
                        @endif
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['warehouse/warehouses', $warehouse->id],
                            'style' => 'display:inline'
                        ]) !!}

                         @if (Auth::user()->hasRole('Todo'))
                            {!! Form::button('<i class="fas fa-trash-alt"></i> Eliminar', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Eliminar Almacen',
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
                                        <th>ID</th><td>{{ $warehouse->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Nombre </th>
                                        <td> {{ $warehouse->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Descripción </th>
                                        <td> {{ $warehouse->description }} </td>
                                    </tr>
                                    <tr>
                                        <th> Activo? </th>
                                        <td> {{ $warehouse->is_active }} </td>
                                        <th> Capacidad </th><td> {{ $warehouse->quantity }} </td>
                                        <th> Prioridad </th><td> {{ $warehouse->priority }} </td>
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
