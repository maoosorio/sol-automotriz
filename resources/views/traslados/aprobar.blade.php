@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Aprobar Traslado</h3>
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

                        {!! Form::model($traslado, ['method' => 'PATCH','route' => ['traslados.aprobacion', $traslado->id]]) !!}
                        <div class="row">
                            @if (auth()->user()->sucursal_id == 1)
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="sucursal_origen">Sucursal Origen</label>
                                    <select name="sucursal_origen" id="sucursal_origen" class="form-control select2bs4 @error('sucursal_origen') is-invalid @enderror" disabled="disabled">
                                        <option value="0" disabled="disabled" selected="selected">Selecciona una opción...</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}" {{ $traslado->sucursal_origen == $sucursal->id ? 'selected=selected':''}}>{{$sucursal->nombre}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="sucursal_origen">Sucursal Origen</label>
                                    <select name="sucursal_origen" id="sucursal_origen" class="form-control select2bs4 @error('sucursal_origen') is-invalid @enderror" disabled="disabled">
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{ auth()->user()->sucursal_id }}" {{ auth()->user()->sucursal_id == $sucursal->id ? 'selected=selected':''}}>{{$sucursal->nombre}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <input class="form-control" type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="sucursal_destino">Sucursal Destino</label>
                                    <select name="sucursal_destino" id="sucursal_destino" class="form-control select2bs4 @error('sucursal_destino') is-invalid @enderror" disabled="disabled">
                                        <option value="0" disabled="disabled" selected="selected">Selecciona una opción...</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}" {{ $traslado->sucursal_destino == $sucursal->id ? 'selected=selected':''}}>{{$sucursal->nombre}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="vehiculo_id">Vehículo</label>
                                    <select name="vehiculo_id" id="vehiculo_id" class="form-control select2bs4 @error('vehiculo_id') is-invalid @enderror" data-live-search="true" disabled="disabled">
                                        <option value="0" disabled="disabled" selected="selected">Selecciona una opción...</option>
                                        @foreach ($vehiculos as $vehiculo)
                                            <option value="{{$vehiculo->id}}" {{ $traslado->vehiculo_id == $vehiculo->id ? 'selected=selected':''}}>{{$vehiculo->vehiculo}}
                                            </option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <input class="form-control" type="text" name="observaciones" readonly value="{{ $traslado->observaciones }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="link">Link</label>
                                    <input class="form-control" type="text" name="link" readonly value="{{ $traslado->link }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <select name="estado" id="estado" class="form-control select2bs4 @error('estado') is-invalid @enderror">
                                            <option value="En Proceso" {{ 'En Proceso' == $traslado->estado ?  'selected=selected':''}}>En Proceso </option>
                                            <option value="Rechazado" {{ 'Rechazado' == $traslado->estado ?  'selected=selected':''}}>Rechazado </option>
                                            <option value="Aprobado" {{ 'Aprobado' == $traslado->estado ?  'selected=selected':''}}>Aprobado </option>
                                    </select>
                                    <input class="form-control" type="hidden" name="sucursal_destino" value="{{ $traslado->sucursal_destino }}">
                                        <input class="form-control" type="hidden" name="vehiculo_id" value="{{ $traslado->vehiculo_id }}">
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
