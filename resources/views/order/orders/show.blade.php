@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Orden #: {{ $order->id }}</div>
                <div class="card-body">

                    <a href="{{ url('/order/orders') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                    
                    <a href="{{ url('/order/orders/' . $order->id . '/edit') }}" title="Editar Orden"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></i> Editar</button></a>
                    
                    {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['order/orders', $order->id],
                        'style' => 'display:inline'
                        ]) !!}

                        @if (Auth::user()->hasRole('Todo'))
                        {!! Form::button('<i class="fas fa-trash-alt"></i> Eliminar', array(
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-sm',
                            'title' => 'Eliminar Orden',
                            'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                            {!! Form::close() !!}
                            @endif

                            <br/>
                            <br/>

                            <span class="btn btn-success" id='btn_print' style="margin-bottom: 10px;">Imprimir</span>

                            <a id="print_ticket" href="#" class="btn btn-secondary" style="margin-bottom: 10px;">Imprimir Ticket</a>

                            <div class="print-order">
                            <img src="{{ asset('img/redgold.png') }}" class="img mx-auto d-block" style="width: 30%; height: auto; margin-bottom: 5%;">

                            <div class="table-responsive ">


                                <table class="table">
                                    <tbody>
                                        <tr style="background-color: #E2E2E2;">
                                            <th>Orden #: {{ $order->id }}</th>
                                            <th> Cliente: {{ $client->name }}</th>
                                            <th> Estado: {{ $order->stat->name }}</th>
                                        </tr>
                                        <tr>
                                            <td>@if(!empty($client->contact))
                                                Contacto: {{ $client->contact }}
                                                @endif
                                                Correo: {{$client->email}} </td>
                                                <td>Dirección: {{ $client->adress }} 
                                                </td>
                                                <td>Tel: {{ $client->telephone1 }} 
                                                    @if(!empty($client->ext1))
                                                    Ext. {{ $client->ext1}}
                                                    @endif
                                                    @if(!empty($client->telephone2))
                                                    , Tel:{{$client->telephone2}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Creado: {{ $order->created_at }}</td>
                                                <td> Día de Entrega: {{ $order->date_delivery }} 
                                                </td>
                                                <td> Tipo de Pago: {{ $order->type_pay }}</td>
                                            </tr>
                                            
                                            <tr>
                                                <td colspan="3">
                                                    <h4>Productos</h4><br>
                                                    <div class="col-md-12">
                                                        <table style=" margin: auto;width: 100% !important; ">

                                                            <tbody>

                                                                <thead>
                                                                    <tr style="background-color: #E2E2E2; width: 100%;">
                                                                        <th>Artículo</th>
                                                                        <th>Cantidad</th>
                                                                        <th>Precio Unitario</th>
                                                                        <th>Subtotal</th>
                                                                    </tr>
                                                                </thead>

                                                                @foreach($products as $product)   
                                                                <tr style="border: 1px solid #dee2e6">
                                                                    <td>{{ $product->name }}</td>
                                                                    <td>{{ $product->quantity }}</td>
                                                                    <td>$ {{ $product->cost }}</td>
                                                                    <td>$ {{ $product->cost * $product->quantity }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </td>
                                            </tr>
                                            <tr style="background-color: #E2E2E2;">
                                                <td> Anticipo: $ {{ $order->advance }} <br> Descuento: $ {{ $order->discount }}</td>       
                                                <td style="color:  <?php if((int)$order->due > 0):?>  red <?php else: ?> green  <?php endif ?>; font-weight: bold;"> Adeudo: $ {{ $order->due }}</td>
                                                <th> Total: $ {{ $order->cost }}</th>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Vendedor: {{ $order->user->name }}</td>
                                           </tr>
                                           <tr>
                                            <td colspan="3">Observaciones: {{ $order->observations }}</td>                                            
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('scripts')
        <script type="text/javascript">

            $("#btn_print").click(function() {
              $('.print-order').printThis();
          });

            document.getElementById("print_ticket").addEventListener("click", function(){
                const ventana = window.open("/ticket/index.php?order={{ $order->id }}","_blank");
                setTimeout(function(){
                    ventana.close();
                }, 1); 
            });

        </script>
        @endsection