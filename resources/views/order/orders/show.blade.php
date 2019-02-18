@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Order {{ $order->id }}</div>
                <div class="card-body">

                    <a href="{{ url('/order/orders') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                    <a href="{{ url('/order/orders/' . $order->id . '/edit') }}" title="Edit Order"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></i> Editar</button></a>
                    {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['order/orders', $order->id],
                        'style' => 'display:inline'
                        ]) !!}

                        @if (Auth::user()->hasRole('Todo'))
                        {!! Form::button('<i class="fas fa-trash-alt"></i> Eliminar', array(
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-sm',
                            'title' => 'Delete Order',
                            'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                            {!! Form::close() !!}
                            @endif

                            <br/>
                            <br/>

                            <span class="btn btn-success" id='btn_print' style="margin-bottom: 10px;">Imprimir</span>

                            <div class="table-responsive print-order">


                                <table class="table">
                                    <tbody>
                                        <tr>
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
                                                <td> Anticipo: ${{ $order->advance }}</td>
                                                <td> Total: ${{ $order->cost }}</td>
                                                <td> Adeudo: ${{ $order->due }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <h4>Productos</h4><br>
                                                    <div class="col-md-12">
                                                        <table style=" margin: auto;width: 50% !important; ">
                                                            <tr>
                                                                <th>Producto</th>
                                                                <th>Cantidad</th>
                                                            </tr>
                                                            <tbody>

                                                            </tbody>

                                                            @foreach($products as $product)   
                                                            <tr>
                                                                <td>{{ $product->name }}</td>
                                                                <td>{{ $product->quantity }}</td>
                                                            </tr>
                                                            @endforeach

                                                        </table>
                                                    </div>

                                                </td>
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
            @endsection

            @section('scripts')
            <script type="text/javascript">
                
                $("#btn_print").click(function() {
                  $('.print-order').printThis();
              });

                

          </script>
          @endsection