<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name') ? 'has-error' : ''}}">
            {!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('contact') ? 'has-error' : ''}}">
            {!! Form::label('contact', 'Contacto', ['class' => 'control-label']) !!}
            {!! Form::text('contact', null, ('required' == 'required') ? ['class' => 'form-control'] : ['class' => 'form-control']) !!}
            {!! $errors->first('contact', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
<div class="form-group{{ $errors->has('adress') ? 'has-error' : ''}}">
    {!! Form::label('adress', 'Dirección', ['class' => 'control-label']) !!}
    {!! Form::text('adress', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('adress', '<p class="help-block">:message</p>') !!}
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('email') ? 'has-error' : ''}}">
            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
            {!! Form::email('email', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group{{ $errors->has('telephone1') ? 'has-error' : ''}}">
            {!! Form::label('telephone1', 'Teléfono', ['class' => 'control-label']) !!}
            {!! Form::number('telephone1', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('telephone1', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group{{ $errors->has('ext1') ? 'has-error' : ''}}">
            {!! Form::label('ext1', 'Ext', ['class' => 'control-label']) !!}
            {!! Form::number('ext1', null, ('' == 'required') ? ['class' => 'form-control'] : ['class' => 'form-control']) !!}
            {!! $errors->first('ext1', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('email2') ? 'has-error' : ''}}">
            {!! Form::label('email2', 'Email Alternativo', ['class' => 'control-label']) !!}
            {!! Form::email('email2', null, ('' == 'required') ? ['class' => 'form-control'] : ['class' => 'form-control']) !!}
            {!! $errors->first('email2', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('telephone2') ? 'has-error' : ''}}">
            {!! Form::label('telephone2', 'Teléfono Alternativo', ['class' => 'control-label']) !!}
            {!! Form::text('telephone2', null, ('' == 'required') ? ['class' => 'form-control'] : ['class' => 'form-control']) !!}
            {!! $errors->first('telephone2', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('rfc') ? 'has-error' : ''}}">
            {!! Form::label('rfc', 'RFC', ['class' => 'control-label']) !!}
            {!! Form::text('rfc', null, ('' == 'required') ? ['class' => 'form-control'] : ['class' => 'form-control']) !!}
            {!! $errors->first('rfc', '<p class="help-block">:message</p>') !!}
        </div>
    </div>    
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('type_business') ? 'has-error' : ''}}">
            {!! Form::label('type_client_id', 'Tipo de Cliente', ['class' => 'control-label']) !!}
            {!! Form::select('type_client_id', $t_c, null, ['class' => 'form-control', 'multiple' => false]) !!}
            {!! $errors->first('type_client_id', '<p class="help-block">:message</p>') !!}
        </div>        
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('contact_position') ? 'has-error' : ''}}">
            {!! Form::label('contact_position', 'Puesto del Contacto', ['class' => 'control-label']) !!}
            {!! Form::text('contact_position', null, ('required' == 'required') ? ['class' => 'form-control'] : ['class' => 'form-control']) !!}
            {!! $errors->first('contact_position', '<p class="help-block">:message</p>') !!}
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
    {!! Form::submit($formMode === 'edit' ? 'Actualizar' : 'Crear', ['class' => 'btn btn-primary']) !!}
</div>
