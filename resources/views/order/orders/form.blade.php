
<div class="row">

    <div class="col-md-4 d-none order_show">
        <div class="form-group{{ $errors->has('client_id') ? 'has-error' : ''}}">
            {!! Form::label('client_id', 'Cliente', ['class' => 'control-label']) !!}
            @if($public_sales_client != null)
            {!! Form::text('client_id',$public_sales_client->client_id,['class' => 'form-control d-none', 'multiple' => false, 'required' => 'required', 'placeholder' => 'Seleccionar Cliente']) !!}
            @else           
             {!! Form::select('client_id', isset($clients) ? $clients : [], !isset($order->id) ? null : $order->client_id, ['class' => 'form-control chosen', 'multiple' => false, 'required' => 'required']) !!}
            @endif

            {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>




    <div class="col-md-4 d-none order_show">
        <div class="form-group{{ $errors->has('date_delivery') ? 'has-error' : ''}}">
            {!! Form::label('date_delivery', 'Fecha de Entrega', ['class' => 'control-label ']) !!}
            {!! Form::date('date_delivery', date("Y-m-d"), ['class' => 'form-control ', 'required' => 'required']) !!}
            {!! $errors->first('date_delivery', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    

    


    <div class="col-md-4 d-none order_show">
        <div class="form-group{{ $errors->has('stats') ? ' has-error' : ''}}">
            {!! Form::label('stat_id', 'Estado: ', ['class' => 'control-label']) !!}
            @if($public_sales_client != null)
            {!! Form::text('stat_id', 1, ['class' => 'form-control', 'multiple' => false, 'required' => 'required']) !!}
            @else
             {!! Form::select('stat_id', isset($stats) ? $stats : [], isset($order->stat_id) ? $order->stat_id : '3' , ['class' => 'form-control', 'multiple' => false, 'required' => 'required']) !!}
            @endif
            {!! $errors->first('stat_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

</div>









<div style="background-color: #C0C0C0FF; padding: 5px; border-radius: 5px;">

    <div class="row" id="products_quantity">
        @if($formMode === 'create')
        <div class="col-md-12 product_quantity" style="display: inline-flex; border-bottom: 1px solid white"> 
            <div class="col-md-5">
             <div class="form-group{{ $errors->has('product_id') ? 'has-error' : ''}}">
                {!! Form::label('product_id', 'Producto', ['class' => 'control-label']) !!}
                {!! Form::select('product_id[]', $products, isset($products) ? $products : [], ['class' => 'form-control chosen', 'multiple' => false, 'required' => 'required', 'onchange'=>'change_total()']) !!}
                {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-md-5">
         <div class="form-group{{ $errors->has('quantity') ? 'has-error' : ''}}">
            {!! Form::label('quantity', 'Cantidad', ['class' => 'control-label']) !!}
            {!! Form::number('quantity[]', 1, ['step'=>'1', 'class' => 'form-control', 'required' => 'required', 'min'=>'1', 'onkeyup'=>'change_total()']) !!}
            {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}

        </div>
    </div>
    <div class="col-md-2">
        <span class="btn btn-danger delete_trash" style="margin-top: 25%;" onclick="borrar(this)"><i class="fas fa-trash-alt"></i></span>
    </div>
</div>
@else

<div class="col-md-12" style="border-bottom: 1px solid white;">
    @if(!empty($order))
    @foreach ($order->order_clients as $product)
    <div class="col-md-12 set_product_quantity" >
        <div class="col-md-12" style="display: inline-flex; background-color: #D2E9FF; border-radius: 5px; margin-bottom: 10px;">
            <div class="col-md-5" style="">
                <div class="form-group">
                    <label class="control-label">Producto</label> 
                    <select class="form-control product_set">
                        <option value="0" selected="selected">{{ $product->product->name }}</option>
                    </select>
                </div>
            </div> 
            <div class="col-md-5">
                <div class="form-group">
                    <label class="control-label">Cantidad</label> 
                    <input type="number" value="{{$product->quantity}}" class="form-control quantity_set" disabled>
                </div>
            </div> 
            <div class="col-md-2"><span onclick="borrar_set({{$product->id}})" class="btn btn-danger delete_trash" style="margin-top: 25%;"><i class="fas fa-trash-alt"></i></span>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>

<div class="col-md-12 product_quantity" id="products_quantity_set" style="display: none; margin-top:10px; border-bottom: 1px solid white;">
    <div class="col-md-5">
     <div class="form-group{{ $errors->has('product_id') ? 'has-error' : ''}}">
        {!! Form::label('product_id', 'Producto', ['class' => 'control-label']) !!}
        {!! Form::select('product_id[]', $products, isset($products) ? $products : [], ['class' => 'form-control chosen', 'multiple' => false, 'required' => 'required', 'onchange'=>'change_total()']) !!}
        {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="col-md-5">
 <div class="form-group{{ $errors->has('quantity') ? 'has-error' : ''}}">
    {!! Form::label('quantity', 'Cantidad', ['class' => 'control-label']) !!}
    {!! Form::number('quantity[]', 1, ['step'=>'1', 'class' => 'form-control', 'required' => 'required', 'min'=>'1', 'onkeyup'=>'change_total()']) !!}
    {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}

</div>
</div>
<div class="col-md-2">
    <span class="btn btn-danger delete_trash_new" style="margin-top: 25%;" onclick="borrar(this)"><i class="fas fa-trash-alt"></i></span>
</div>


</div>
@endif

</div>
<div class="row" id="new_product" style="padding: 5px;"></div>



<span class="btn btn-primary" id="add_product" style="margin-bottom: 10px; display:none;"><i class="fas fa-plus"></i></span>


<span class="btn btn-primary" id="add_product_edit" style="margin-bottom: 10px; display:none; "><i class="fas fa-plus"></i></span>

<span id="total_account" style="float:right; margin-right: 50px;">Total: ${{ !empty($order) ? $order->cost : 0 }}</span>
</div>

<div class="row" style="margin-top: 15px;">
    <div class="col-md-{{$public_sales_client == null ? 3 : 6}}">
        <div class="form-group{{ $errors->has('type_pay') ? 'has-error' : ''}}">
            {!! Form::label('type_pay', 'Tipo de Pago', ['class' => 'control-label']) !!}
            {!! Form::select('type_pay', ['Efectivo'=> 'Efectivo', 'Tarjeta Credito/Debito'=> 'Tarjeta Credito/Debito', 'Mixto'=> 'Mixto'], 'required', ['class' => 'form-control']) !!}
            {!! $errors->first('type_pay', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="col-md-{{$public_sales_client == null ? 3 : 6}}">
        <div class="form-group{{ $errors->has('cost') ? 'has-error' : ''}}">
            {!! Form::label('cost', 'Total $', ['class' => 'control-label']) !!}
            {!! Form::number('cost', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'min'=>'1', 'onchange'=>'change_due()', 'readonly'=> $public_sales_client == null ? false : true] : ['class' => 'form-control', 'min'=>'1', 'onchange'=>'change_due()', 'readonly'=> $public_sales_client == null ? false : true]) !!}
            {!! $errors->first('cost', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    @if($public_sales_client == null)
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('advance') ? 'has-error' : ''}}">
            {!! Form::label('advance', 'Anticipo $', ['class' => 'control-label']) !!}
            {!! Form::number('advance', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'min'=>'0', 'onchange'=>'change_due()'] : ['class' => 'form-control', 'min'=>'0', 'onchange'=>'change_due()']) !!}
            {!! $errors->first('advance', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group{{ $errors->has('due') ? 'has-error' : ''}}">
            {!! Form::label('due', 'Adeudo $', ['class' => 'control-label']) !!}
            {!! Form::number('due', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'min'=>'0', 'readonly'=> true] : ['class' => 'form-control', 'min'=>'0', 'readonly'=> true]) !!}
            {!! $errors->first('due', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    @endif

</div>
<div class="form-group{{ $errors->has('observations') ? 'has-error' : ''}}" >
    {!! Form::label('observations', 'Observaciones', ['class' => 'control-label']) !!}
    {!! Form::textarea('observations', null, ['class' => 'form-control', 'rows' => '4']) !!}
    {!! $errors->first('observations', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group">
    {!! Form::submit('VENDER', ['class' => 'btn btn-success']) !!}
</div>

