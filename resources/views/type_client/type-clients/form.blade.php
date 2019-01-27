<div class="form-group{{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Descripción', ['class' => 'control-label']) !!}
    {!! Form::text('description', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
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
    {!! Form::submit($formMode === 'edit' ? 'Actualizar Tipo de Cliente' : 'Crear Tipo de Cliente', ['class' => 'btn btn-primary']) !!}
</div>
