@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Editar LogWorkFlow #{{ $logworkflow->id }}</div>
                    <div class="card-body">
                        <a href="{{ url('/log_work_flow/log-work-flow') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($logworkflow, [
                            'method' => 'PATCH',
                            'url' => ['/log_work_flow/log-work-flow', $logworkflow->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('log_work_flow.log-work-flow.form', ['formMode' => 'edit'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
