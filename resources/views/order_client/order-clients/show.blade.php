@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">OrderClient {{ $orderclient->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/order_client/order-clients') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                        <a href="{{ url('/order_client/order-clients/' . $orderclient->id . '/edit') }}" title="Edit OrderClient"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></i> Editar</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['order_client/orderclients', $orderclient->id],
                            'style' => 'display:inline'
                        ]) !!}

                         @if (Auth::user()->hasRole('Todo'))
                            {!! Form::button('<i class="fas fa-trash-alt"></i> Eliminar', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete OrderClient',
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
                                        <th>ID</th><td>{{ $orderclient->id }}</td>
                                    </tr>
                                    <tr><th> Client Id </th><td> {{ $orderclient->client_id }} </td></tr><tr><th> Product Id </th><td> {{ $orderclient->product_id }} </td></tr><tr><th> Quantity </th><td> {{ $orderclient->quantity }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
