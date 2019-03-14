@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Configuración Venta Público</div>
                    <div class="card-body">
                        @if($count_publicsales==0)
                        <a href="{{ url('/public_sales/public-sales/create') }}" class="btn btn-success btn-sm" title="Add New PublicSale">
                            <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                        </a>
                        @endif

                        
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Cliente para Venta al Público</th><th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($publicsales as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->client->name }}</td>
                                        <td>                                            
                                            <a href="{{ url('/public_sales/public-sales/' . $item->id . '/edit') }}" title="Edit PublicSale"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></i></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $publicsales->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
