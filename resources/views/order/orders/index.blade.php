@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Ordenes</div>
                    <div class="card-body">
                        <a href="{{ url('/order/orders/create') }}" class="btn btn-success btn-sm" title="Add New Order">
                            <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/order/orders', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
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
                                        <th>Cliente</th>
                                        <th>Deuda</th>
                                        <th>Productos</th>
                                        <th>Día de Entrega</th>
                                        <th>Estado</th>                 
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach($orders as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>

                                        <td>{{ App\Client::where('id', '=', $item->client)->value('name') }}</td>
                                        <td>{{ $item->due }}</td>
                                        <td>{{ $item->order_clients->sum('quantity') }}</td>
                                        <td>{{ $item->date_delivery }}</td>
                                        <td>{{ $item->stat->name }}</td>                                        
                                        <td>
                                            <a href="{{ url('/order/orders/' . $item->id) }}" title="View Order"><button class="btn btn-info btn-sm"><i class="fa fa-eye" ></i></button></a>
                                            <a href="{{ url('/order/orders/' . $item->id . '/edit') }}" title="Edit Order">
                                                <button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></button>
                                            </a>

                                            @if (Auth::user()->hasRole('Todo'))
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'url' => ['/order/orders', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fas fa-trash-alt"></i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Order',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                            @endif
                                            
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $orders->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
