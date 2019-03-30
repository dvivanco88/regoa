@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Logworkflow</div>
                    <div class="card-body">
                       

                        {!! Form::open(['method' => 'GET', 'url' => '/log_work_flow/log-work-flow', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Ejecuón</th><th>Usuario</th><th>Evento</th><th>Página</th><th>Registro ID</th><th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($logworkflow as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->action }}</td><td>{{ $item->page }}</td><td>{{ $item->register_id }}</td>
                                        <td>
                                            <a href="{{ url('/log_work_flow/log-work-flow/' . $item->id) }}" title="View LogWorkFlow"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $logworkflow->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
