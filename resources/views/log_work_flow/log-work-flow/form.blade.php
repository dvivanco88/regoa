<div class="form-group{{ $errors->has('action') ? 'has-error' : ''}}">
    {!! Form::label('action', 'Action', ['class' => 'control-label']) !!}
    {!! Form::text('action', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('action', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('page') ? 'has-error' : ''}}">
    {!! Form::label('page', 'Page', ['class' => 'control-label']) !!}
    {!! Form::text('page', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('page', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('register_id') ? 'has-error' : ''}}">
    {!! Form::label('register_id', 'Register Id', ['class' => 'control-label']) !!}
    {!! Form::number('register_id', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('register_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('info1') ? 'has-error' : ''}}">
    {!! Form::label('info1', 'Info1', ['class' => 'control-label']) !!}
    {!! Form::text('info1', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('info1', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('info2') ? 'has-error' : ''}}">
    {!! Form::label('info2', 'Info2', ['class' => 'control-label']) !!}
    {!! Form::text('info2', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('info2', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('info3') ? 'has-error' : ''}}">
    {!! Form::label('info3', 'Info3', ['class' => 'control-label']) !!}
    {!! Form::text('info3', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('info3', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('info4') ? 'has-error' : ''}}">
    {!! Form::label('info4', 'Info4', ['class' => 'control-label']) !!}
    {!! Form::text('info4', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('info4', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('info5') ? 'has-error' : ''}}">
    {!! Form::label('info5', 'Info5', ['class' => 'control-label']) !!}
    {!! Form::text('info5', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('info5', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Actualizar' : 'Crear', ['class' => 'btn btn-primary']) !!}
</div>
