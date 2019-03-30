@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">LogWorkFlow {{ $logworkflow->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/log_work_flow/log-work-flow') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                        
                        

                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $logworkflow->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Ejecución </th>
                                        <td> {{ $logworkflow->created_at }} </td>
                                    </tr>
                                    <tr>
                                        <th> Usuario </th>
                                        <td> {{ $logworkflow->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Evento </th>
                                        <td> {{ $logworkflow->action }} </td>
                                    </tr>
                                    <tr>
                                        <th> Página </th>
                                        <td> {{ $logworkflow->page }} </td>
                                    </tr>
                                    <tr>
                                        <th> Registro ID </th>
                                        <td> {{ $logworkflow->register_id }} </td>
                                    </tr>
                                    <tr>
                                        <th> Info 1 <small>(Crear, Edición-Registro Nuevo, Eliminar, Agregar Inventario, Abono Orden)</small> </th>
                                        <td> {{ $logworkflow->info1 }} </td>
                                    </tr>

                                    <tr>
                                        <th> Info 2 <small>(Edición-Registro Viejo, Eliminar Anidado)</small> </th>
                                        <td> {{ $logworkflow->info2 }} </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
