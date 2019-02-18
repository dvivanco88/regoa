@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Clientes</div>
                    <div class="card-body">
                        <a href="{{ url('/client/clients/create') }}" class="btn btn-success btn-sm" title="Add New Client">
                            <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/client/clients', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
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
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Tipo de Cliente</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->name }}</td><td>{{ $item->email }}</td><td>{{ $item->telephone1 }}</td><td>{{ $item->type_client->name }}</td>
                                        <td>                                            
                                            <a href="{{ url('/client/clients/' . $item->id) }}" title="View Client"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                            <a href="{{ url('/client/clients/' . $item->id . '/edit') }}" title="Edit Client"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></i></button></a>

                                            @if (Auth::user()->hasRole('Todo'))
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'url' => ['/client/clients', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fas fa-trash-alt"></i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Client',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $clients->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
