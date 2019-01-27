<div class="form-group{{ $errors->has('name') ? 'has-error' : ''}}">
	{!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
	{!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
	{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group{{ $errors->has('price_business') ? 'has-error' : ''}}">
			{!! Form::label('price_business', 'Precio de Compra', ['class' => 'control-label']) !!}
			$
			{!! Form::number('price_business', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
			{!! $errors->first('price_business', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group{{ $errors->has('price_retail') ? 'has-error' : ''}}">
			{!! Form::label('price_retail', 'Venta Base', ['class' => 'control-label']) !!} $
			{!! Form::number('price_retail', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
			{!! $errors->first('price_retail', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group{{ $errors->has('price_wholesale') ? 'has-error' : ''}}">
			{!! Form::label('price_wholesale', 'Venta Mayoreo', ['class' => 'control-label']) !!}
			$
			{!! Form::number('price_wholesale', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
			{!! $errors->first('price_wholesale', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
</div>

<div class="form-group{{ $errors->has('is_active') ? 'has-error' : ''}}">
	{!! Form::label('is_active', 'Activo?', ['class' => 'control-label']) !!}
	<div class="checkbox">
		<label>{!! Form::radio('is_active', '1', true) !!} Si</label>
	</div>
	<div class="checkbox">
		<label>{!! Form::radio('is_active', '0') !!} No</label>
	</div>
	{!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
	{!! Form::submit($formMode === 'edit' ? 'Actualizar Producto' : 'Crear Producto', ['class' => 'btn btn-primary']) !!}
</div>
