@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Actividades por Técnico</h3>
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

                        {!! Form::model($actividad, ['method' => 'PATCH','route' => ['actividades.update', $actividad->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    @php
                                    $hoy = date('Y-m-d');
                                    $ayer = strtotime('-1 day', strtotime($hoy));
                                    $ayer = date('Y-m-d', $ayer);
                                    @endphp
                                    <input type="date" class="form-control" name="fecha" value="{{ $hoy }}" max="{{ $hoy }}" min="{{ $ayer }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="tecnico_id">Técnico</label>
                                    <select name="tecnico_id" id="tecnico_id" class="form-control select2bs4 @error('tecnico_id') is-invalid @enderror">
                                        @foreach ($tecnicos as $tecnico)
                                            <option value="{{$tecnico->id}}" {{ $actividad->tecnico_id == $tecnico->id ? 'selected=selected':''}}>{{$tecnico->nombre}}
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
