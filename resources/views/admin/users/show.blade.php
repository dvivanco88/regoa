@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Usuario</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/users') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
                        <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></i> Editar</button></a>
                        
                        @if(Auth::user()->hasRole('Todo'))
                        {!! Form::open([
                            'method' => 'DELETE',
                            'url' => ['/admin/users', $user->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fas fa-trash-alt"></i> Eliminar', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete User',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        @endif
                        
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID.</th> 
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Activo?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $user->id }}</td> 
                                        <td> {{ $user->name }} </td>
                                        <td> {{ $user->email }} </td> 
                                        <td> {{$user->roles()->first()->label}}  </td>
                                        <td> @if ($user->is_active == 1)
                                            SI
                                            @else
                                            NO
                                        @endif </td>
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
