@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Destajo por Vehículo</h3>
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

                            {!! Form::open(array('route' => 'reporteV','method'=>'POST')) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha Inicio</label>
                                    @php
                                    $hoy = date('Y-m-d');
                                    $ayer = strtotime('-7 day', strtotime($hoy));
                                    $ayer = date('Y-m-d', $ayer);
                                    @endphp
                                    <input type="date" class="form-control" name="fecha_inicio"value="{{ $hoy }}" max="{{ $hoy }}">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_final">Fecha Final</label>
                                    <input type="date" class="form-control" name="fecha_final" value="{{ $ayer }}" min="{{ $ayer }}" max="{{ $hoy }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="vehiculo_id">Vehículo</label>
                                    <select name="vehiculo_id" id="vehiculo_id" class="form-control select2bs4 @error('vehiculo_id') is-invalid @enderror">
                                        <option value="0" disabled="disabled" selected="selected">Selecciona una opción...</option>
                                        @foreach ($vehiculos as $vehiculo)
                                            <option value="{{$vehiculo->id}}" {{old('vehiculo_id') == $vehiculo->id ? 'selected=selected':''}}>{{$vehiculo->vehiculo}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-primary">Ver Reporte</button>
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
