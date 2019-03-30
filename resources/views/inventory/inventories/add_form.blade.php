
<div class="form-group{{ $errors->has('roles') ? ' has-error' : ''}}">
    {!! Form::label('warehouse_id', 'Almacén: ', ['class' => 'control-label']) !!}
    {!! Form::select('warehouse_id', $almacenes, $warehouse_id, ['class' => 'form-control', 'required' => true, 'readonly' => true]) !!}
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('roles') ? ' has-error' : ''}}">
            {!! Form::label('product_id', 'Producto: ', ['class' => 'control-label']) !!}
            {!! Form::select('product_id', $productos, $product_id, ['class' => 'form-control', 'required' => true, 'readonly' => true]) !!}
            {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label">Agregar Cantidad</label>
            <input type="number" id="quantity_add" min="1" class="form-control" placeholder="0" required>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group{{ $errors->has('quantity') ? 'has-error' : ''}}">
            {!! Form::label('quantity', 'Cantidad', ['class' => 'control-label']) !!}
            {!! Form::number('quantity', (isset($inventory)) ? $inventory->quantity : 0, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'readonly' => true] : ['class' => 'form-control', 'readonly' => true]) !!}
            {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group{{ $errors->has('is_active') ? 'has-error' : ''}}" style="display: none;">
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
    {!! Form::submit($formMode === 'edit' ? 'Actualizar' : 'Crear', ['class' => 'btn btn-primary']) !!}
</div>


