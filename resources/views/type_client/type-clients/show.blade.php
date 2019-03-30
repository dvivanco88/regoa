@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Tipo de Cliente {{ $typeclient->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/type_client/type-clients') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                        <a href="{{ url('/type_client/type-clients/' . $typeclient->id . '/edit') }}" title="Editar Tipo de Cliente"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></i> Editar</button></a>

                                            @if (Auth::user()->hasRole('Todo'))
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['type_client/typeclients', $typeclient->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fas fa-trash-alt"></i> Eliminar', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Eliminar Tipo de Cliente',
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
                                        <th>ID</th><td>{{ $typeclient->id }}</td>
                                    </tr>
                                    <tr><th> Nombre </th><td> {{ $typeclient->name }} </td></tr><tr><th> Descripción </th><td> {{ $typeclient->description }} </td></tr><tr><th> Activo? </th><td> @if ($typeclient->is_active == 1)
                                            SI
                                            @else
                                            NO
                                        @endif </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
