@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Crear Inventario</div>
                <div class="card-body">
                    <a href="{{ url('/inventory/inventories') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                    <br />
                    <br />

                    @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif

                    {!! Form::open(['url' => '/inventory/inventories', 'class' => 'form-horizontal', 'files' => true]) !!}

                    @include ('inventory.inventories.form', ['formMode' => 'create'])

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">

    $("#warehouse_id").change(function(){
        $("#warehouse_id").val('{{ $warehouse_id }}');

    });

    $("#product_id").change(function(){
        $("#product_id").val('{{ $product_id }}');
   });




</script>
@endsection