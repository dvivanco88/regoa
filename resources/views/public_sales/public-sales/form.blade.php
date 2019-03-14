<div class="row">
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('client_id') ? 'has-error' : ''}}">
            {!! Form::label('client_id', 'Cliente', ['class' => 'control-label']) !!}
            {!! Form::select('client_id', $clients->count() == 1 ? $clients : $clients, isset($publicsale) ? $publicsale->client_id : [], $clients->count() > 1 ? ['class' => 'form-control chosen', 'multiple' => false, 'required' => 'required', 'placeholder' => 'Seleccionar Cliente'] : ['class' => 'form-control chosen', 'multiple' => false, 'required' => 'required']) !!}
            {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Actualizar' : 'Crear', ['class' => 'btn btn-primary']) !!}
</div>
