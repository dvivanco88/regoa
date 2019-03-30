@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Cliente {{ $client->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/client/clients') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                        <a href="{{ url('/client/clients/' . $client->id . '/edit') }}" title="Editar Cliente"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></i> Editar</button></a>
                        @if (Auth::user()->hasRole('Todo'))
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['client/clients', $client->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fas fa-trash-alt"></i> Eliminar', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Eliminar Cliente',
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
                                        <th>ID</th><td>{{ $client->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Nombre </th><td> {{ $client->name }} </td>
                                        <th> Contacto </th><td> {{ $client->contact }} </td>
                                    </tr>
                                    <tr style="white-space: nowrap;">
                                        <th> Dirección </th><td> {{ $client->adress }} </td>
                                    </tr>
                                    <tr>
                                        <th> Email </th><td> {{ $client->email }} </td>
                                        <th> Teléfono </th><td> {{ $client->telephone1 }} </td>
                                        <th> Ext </th><td> {{ $client->ext1 }} </td>
                                    </tr>
                                    <tr>
                                        <th> Email Alternativo </th><td> {{ $client->email2 }} </td>
                                        <th> Teléfono Alternativo</th><td> {{ $client->telephone2 }} </td>
                                        <th> RFC </th><td> {{ $client->rfc }} </td>
                                    </tr>
                                    <tr>
                                        <th> Tipo de Cliente </th><td> {{ $client->type_client->name }} </td>
                                        <th> Puesto del Contacto</th><td> {{ $client->contact_position }} </td>
                                        
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
