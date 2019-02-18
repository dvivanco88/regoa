<div class="form-group{{ $errors->has('client_id') ? 'has-error' : ''}}">
    {!! Form::label('client_id', 'Client Id', ['class' => 'control-label']) !!}
    {!! Form::number('client_id', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('product_id') ? 'has-error' : ''}}">
    {!! Form::label('product_id', 'Product Id', ['class' => 'control-label']) !!}
    {!! Form::number('product_id', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('quantity') ? 'has-error' : ''}}">
    {!! Form::label('quantity', 'Quantity', ['class' => 'control-label']) !!}
    {!! Form::number('quantity', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('cost') ? 'has-error' : ''}}">
    {!! Form::label('cost', 'Cost', ['class' => 'control-label']) !!}
    {!! Form::text('cost', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('cost', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Actualizar' : 'Crear', ['class' => 'btn btn-primary']) !!}
</div>
