@extends('layouts.backend')

@section('content')

<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-secondary" style="text-align: center; color:white;"><b>VENTA PÚBLICO</b></div>
                <div class="card-body">

                    <br />
                    <br />

                    @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif

                    {!! Form::open(['url' => '/order/orders', 'class' => 'form-horizontal', 'files' => true]) !!}
                    
                    <img src="{{ asset('img/redgold.png') }}" class="img mx-auto d-block" style="width: 30%; height: auto; margin-top: -5%; margin-bottom: 5%;">
                    
                    @include ('order.orders.form', ['formMode' => 'create'])

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection



@section('scripts')

<script type="text/javascript">
    change_total();
    $('#cost').css('font-weight', 'bold')
    $('#add_product').show();
    $('.vender').hide();    
    $('#add_product_edit').hide();
    $("#advance").val(0);
    $("#due").val(0);
    $(".delete_trash:first").hide();

    $(".chosen").chosen({
        no_results_text: "Ups!, no se encontró"
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
            var $products_quantity = $('#products_quantity').children().clone();

            $('#new_product').append($products_quantity);
            $("#new_product .delete_trash:last").show();
            $("#new_product select:last").removeClass("chzn-done").removeAttr("id").css("display", "block").next().remove();
            $("#new_product  select:last").chosen();

            $("input[name*='quantity[]']:last").val('1');
        }
        else{
            alert("Campos incompletos en Productos/Cantidad.");
        }
    });

    function change_cambio(){
        $("#cambio").val(parseInt($("#paga").val()) - parseInt(($("#cost").val())));
        if(parseInt($("#cambio").val()) >= 0){
            $('.vender').show();    
            $('#cambio').css('color', 'white')
            $('#cambio').css('background-color', 'green')
            if(parseInt($("#cambio").val()) == 0){
                $('#cambio').css('background-color', 'lightgray')
                $('#cambio').css('color', 'black')
            }
        }else{
            $('#cambio').css('color', 'white')
            $('#cambio').css('background-color', 'red')
            $('.vender').hide();  
        }
    }

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

                $('#total_account').html('');
                $('#total_account').append('Total: $' + response.toLocaleString('en-IN'));
                $('#cost').val(response); 
                change_due();
                change_cambio();
            },
            error: function(jqXHR, textStatus, errorThrown) {

                $('#total_account').html('');
                $('#total_account').append("<b style='color: red;'>Verificar Productos/Cantidades</b>");
            }
        });
    }

    function change_due(){
        $("#due").val(parseInt(($("#cost").val()) - parseInt($("#advance").val())).toLocaleString('en-IN'));
    }

    function borrar(row){
       $(row).closest('.product_quantity').remove();        
   }

</script>
@endsection