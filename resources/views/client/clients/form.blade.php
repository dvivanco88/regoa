<div class="form-group{{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('contact') ? 'has-error' : ''}}">
    {!! Form::label('contact', 'Contact', ['class' => 'control-label']) !!}
    {!! Form::text('contact', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('contact', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('adress') ? 'has-error' : ''}}">
    {!! Form::label('adress', 'Adress', ['class' => 'control-label']) !!}
    {!! Form::text('adress', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('adress', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
    {!! Form::email('email', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('telephone1') ? 'has-error' : ''}}">
    {!! Form::label('telephone1', 'Telephone1', ['class' => 'control-label']) !!}
    {!! Form::text('telephone1', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('telephone1', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('ext1') ? 'has-error' : ''}}">
    {!! Form::label('ext1', 'Ext1', ['class' => 'control-label']) !!}
    {!! Form::text('ext1', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('ext1', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('telephone2') ? 'has-error' : ''}}">
    {!! Form::label('telephone2', 'Telephone2', ['class' => 'control-label']) !!}
    {!! Form::text('telephone2', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('telephone2', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('type_business') ? 'has-error' : ''}}">
    {!! Form::label('type_business', 'Type Business', ['class' => 'control-label']) !!}
    {!! Form::text('type_business', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('type_business', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('rfc') ? 'has-error' : ''}}">
    {!! Form::label('rfc', 'Rfc', ['class' => 'control-label']) !!}
    {!! Form::text('rfc', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('rfc', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('email2') ? 'has-error' : ''}}">
    {!! Form::label('email2', 'Email2', ['class' => 'control-label']) !!}
    {!! Form::email('email2', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('email2', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('contact_position') ? 'has-error' : ''}}">
    {!! Form::label('contact_position', 'Contact Position', ['class' => 'control-label']) !!}
    {!! Form::text('contact_position', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('contact_position', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
