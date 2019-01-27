@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Editar Tipo de Cliente #{{ $typeclient->id }}</div>
                    <div class="card-body">
                        <a href="{{ url('/type_client/type-clients') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($typeclient, [
                            'method' => 'PATCH',
                            'url' => ['/type_client/type-clients', $typeclient->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('type_client.type-clients.form', ['formMode' => 'edit'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
