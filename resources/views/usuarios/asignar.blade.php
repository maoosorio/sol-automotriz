@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Asignar Sucursales</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                            <strong>¡Revise los campos!</strong>
                                @foreach ($errors->all() as $error)
                                    <span class="badge badge-danger">{{ $error }}</span>
                                @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        @endif

                        {!! Form::model($user, ['method' => 'PATCH','route' => ['usuarios.asignacion', $user->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input class="form-control" type="hidden" name="usuario_id" value="{{ $user->id }}">
                                    {!! Form::text('name', null, array('class' => 'form-control', 'readonly')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="sucursal_id">Sucursal</label>
                                    <select name="sucursal_id" id="sucursal_id" class="form-control select2bs4 @error('sucursal_id') is-invalid @enderror">
                                        @foreach ($sucursales as $sucursal)
                                        <option value="{{$sucursal->id}}" {{ $sucursal->id == $user->sucursal_id ? 'selected=selected':''}}>{{$sucursal->nombre}}
                                        </option>
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <table class="table table-responsive-sm table-striped table-bordered mt-2">
                                    <thead>
                                        <th>Sucursal</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($usuarios as $usuario)
                                            <tr>
                                                <td>{{ $usuario->sucursal->nombre }}</td>
                                                <td>
                                                    @can('1.2.4 borrar-usuario')
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['usuarios.asignacion.destroy', $usuario->id], 'style' => 'display:inline']) !!}
                                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger']) }}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
