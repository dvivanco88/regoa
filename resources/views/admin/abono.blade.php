 @extends('layouts.backend')

 @section('content')

 <div class="container">
 	<div class="row">
 		@include('admin.sidebar')

 		<div class="col-md-10">
 			<div class="card">
 				<div class="card-header">Abono</div>

 				<div class="card-body">   

 					{!! Form::model($order, [
                        'method' => 'PATCH',
                        'url' => ['/admin/abono_set', $order->id],
                        'class' => 'form-horizontal',
                        'files' => true
                        ]) !!}

                        <div class="row" >
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('advance') ? 'has-error' : ''}}">
            {!! Form::label('advance', 'Abono $', ['class' => 'control-label']) !!}
            {!! Form::number('advance', 0, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'min'=>'0', 'max'=>(int)$order->due, 'onkeyup'=>'change_due()'] : ['class' => 'form-control', 'min'=>'0', 'onkeyup'=>'change_due()']) !!}
            {!! $errors->first('advance', '<p class="help-block">:message</p>') !!}
        </div>
    </div> 

   

    <div class="col-md-3">
        <div class="form-group{{ $errors->has('due') ? 'has-error' : ''}}">
            {!! Form::label('due', 'Adeudo $', ['class' => 'control-label']) !!}
            {!! Form::text('due', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'min'=>'0', 'disabled'=> 'true'] : ['class' => 'form-control', 'min'=>'0', 'disabled'=> 'true']) !!}
            {!! $errors->first('due', '<p class="help-block">:message</p>') !!}
        </div>
    </div> 

     <div class="col-md-3">
        <div class="form-group{{ $errors->has('cost') ? 'has-error' : ''}}">
            {!! Form::label('cost', 'Total $', ['class' => 'control-label']) !!}
            {!! Form::number('cost', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'min'=>'1', 'onchange'=>'change_due()', 'disabled'=> 'true'] : ['class' => 'form-control', 'min'=>'1', 'onchange'=>'change_due()', 'disabled'=> 'true']) !!}
            {!! $errors->first('cost', '<p class="help-block">:message</p>') !!}
        </div>
    </div> 

    <div class="col-md-3">
    	<div class="form-group">
    {!! Form::submit('Actualizar', ['class' => 'btn btn-primary', 'style'=>'margin-top:15%;']) !!}
</div>
    </div>

</div>

                        {!! Form::close() !!}
                        <hr>

 					<span class="btn btn-success" id='btn_print' style="margin-bottom: 10px;">Imprimir</span>               
 					<div class="table-responsive print-order">


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
 										<td> Anticipo: $ {{ $order->advance }}</td>      
 										<td> Adeudo: $ {{ $order->due }}</td>
 										<th> Total: $ {{ $order->cost }}</td>
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

 			function change_due(){
        total = parseInt($("#cost").val());
        
        $("#due").val( total - {{ $order->advance }} - parseInt($("#advance").val())).toLocaleString('en-IN');
    }

 		</script>
 		@endsection