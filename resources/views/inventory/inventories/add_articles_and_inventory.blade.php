@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Crear Inventario</div>
                <div class="card-body">
                    <a href="{{ url('/inventory/inventories') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                    <br />
                    <br />

                    @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif

                    {!! Form::open(['url' => '/inventory/inventories/add_new', 'class' => 'form-horizontal', 'files' => true]) !!}

                    @include ('inventory.inventories.add_form', ['formMode' => 'create'])

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
    var quantity_original;
    var total = 0;

    if($("#quantity").val() == ""){
            quantity_original = 0;
        }else{
            quantity_original = parseInt($("#quantity").val());
        }

    $("#quantity_add").keyup(function(){
        var quantity_add = 0;

        if($("#quantity_add").val() == ""){
            quantity_add = 0;
        }else{
            quantity_add = parseInt($("#quantity_add").val());
        }

        total = quantity_add + quantity_original;
        
        
        $("#quantity").val(total.toString());
   });

    $("#warehouse_id").change(function(){
        $("#warehouse_id").val('{{ $warehouse_id }}');

    });

    $("#product_id").change(function(){
        $("#product_id").val('{{ $product_id }}');
   });

    


</script>
@endsection