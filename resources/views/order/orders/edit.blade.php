@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Editar Order #{{ $order->id }}</div>
                <div class="card-body">
                    <a href="{{ url('/order/orders') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                    <br />
                    <br />
                    
                    @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif

                    {!! Form::model($order, [
                        'method' => 'PATCH',
                        'url' => ['/order/orders', $order->id],
                        'class' => 'form-horizontal',
                        'files' => true
                        ]) !!}

                        @include ('order.orders.form', ['formMode' => 'edit'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script type="text/javascript">
        $('.order_show').removeClass('d-none');
        
       $('#add_product').hide();
       $('#add_product_edit').show();
       $(".delete_trash_new:first").hide();

       $("#add_product_edit" ).click(function() {
        $('#add_product').show();
        $('.product_quantity').show('inline-flex');
        $('.product_quantity').css('display','inline-flex')
        $('#add_product_edit').hide();

        $(".chosen").chosen({
            no_results_text: "Ups!, no se encontró"
        }); 
    });

       $("#add_product").click(function() {
        var check = true;
        $("select[name*='product_id[]']").each(function() {
          if($(this).chosen().val() == "0"){
            check = false;
        }
    });

        $("input[name*='quantity[]']").each(function() {
          if(parseInt($(this).val()) < 1 ){
             check = false; 
         }
     });

        if(check){
            var $products_quantity = $('#products_quantity_set').clone();
            
            $('#new_product').append($products_quantity);
            $("#new_product .delete_trash_new:last").show();
            $("#new_product select:last").removeClass("chzn-done").removeAttr("id").css("display", "block").next().remove();
            $("#new_product  select:last").chosen();

            $("input[name*='quantity[]']:last").val('1');
        }
        else{
            alert("Campos incompletos en Productos/Cantidad.");
        }
    });


       function change_total(){

        var products= [];
        var quantities= [];

        $("select[name*='product_id[]']").each(function() {
            products.push($(this).chosen().val());});

        $("input[name*='quantity[]']").each(function() {
          quantities.push($(this).val());});



        $.ajax({
            method: 'get', 
            url: '/request/product',
            data: {'products' : products, 'quantities': quantities},
            success: function(response){
                total = parseInt({{ $order->cost }}) + parseInt(response);
                console.log(total);
                $('#total_account').html('');
                $('#total_account').append('Total: $' + total.toLocaleString('en-IN'));
                $('#cost').val(total); 
                change_due();
            },
            error: function(jqXHR, textStatus, errorThrown) {

                $('#total_account').html('');
                $('#total_account').append("<b style='color: red;'>Verificar Productos/Cantidades</b>");
            }
        });
    }

    function change_due(){
        total = parseInt($("#cost").val());
        
        $("#due").val( total - parseInt($("#advance").val())).toLocaleString('en-IN');
    }

    function borrar(row){
        console.log($(row).closest('.product_quantity'));
        $(row).closest('.product_quantity').remove();        
    }

    function borrar_set(id){
     $.ajax({
        method: 'get', 
        url: '/order_client/order_clients/delete',
        data: {'id' : id},
        success: function(response){
            console.log('Elemento ' + response + ' eliminado');
            location.reload();            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });       
 }




</script>
@endsection