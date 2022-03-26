@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Alta de Vehículos</h3>
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

                        {!! Form::open(array('route' => 'altas.store','method'=>'POST')) !!}
                        <div class="row">
                            {{-- @if (auth()->user()->sucursal_id == 1) --}}
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="sucursal_id">Sucursal</label>
                                    <select name="sucursal_id" id="sucursal_id" class="form-control select2bs4 @error('sucursal_id') is-invalid @enderror">
                                        <option value="0" disabled="disabled" selected="selected">Selecciona una opción...</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}" {{old('sucursal_id') == $sucursal->id ? 'selected=selected':''}}>{{$sucursal->nombre}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- @else
                            <input class="form-control" type="hidden" name="sucursal_id" value="{{ auth()->user()->sucursal_id }}">
                            @endif --}}
                            <input class="form-control" type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="vehiculo_id">Vehículo</label>
                                    <select name="vehiculo_id" id="vehiculo_id" class="form-control select2bs4 @error('vehiculo_id') is-invalid @enderror" data-live-search="true">
                                        <option value="0" disabled="disabled" selected="selected">Selecciona una opción...</option>
                                        @foreach ($vehiculos as $vehiculo)
                                            <option value="{{$vehiculo->id}}" {{old('vehiculo_id') == $vehiculo->id ? 'selected=selected':''}}>{{$vehiculo->vehiculo}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" class="form-control" name="fecha" value="{{ date('Y-m-d') }}" readonly>
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

@section('js')
    <script>
        $(document).ready(function() {
        $('#vehiculo_id').select2();
    });
    </script>
@endsection
