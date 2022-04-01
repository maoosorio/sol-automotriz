@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <h3 class="page__heading col-4">Destajo por Técnico</h3>
                <div class="col-4"></div>
                <div class="col-4">
                    @php
                    use App\Models\Sucursal;
                    $id = auth()->user()->sucursal_id;
                    $sucur = Sucursal::find($id) ;
                    @endphp
                    <p class="text-primary text-right">Sucursal: {{ $sucur->nombre }}
                    </p></div>
                </div>
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

                            {!! Form::open(array('route' => 'reporteT','method'=>'POST')) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha Inicio</label>
                                    @php
                                    $hoy = date('Y-m-d');
                                    $ayer = strtotime('-15 day', strtotime($hoy));
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
                                    <label for="tecnico_id">Técnico</label>
                                    <select name="tecnico_id" id="tecnico_id" class="form-control select2bs4 @error('tecnico_id') is-invalid @enderror">
                                        <option value="0" disabled="disabled" selected="selected">Selecciona una opción...</option>
                                        @foreach ($tecnicos as $tecnico)
                                            <option value="{{$tecnico->id}}" {{old('tecnico_id') == $tecnico->id ? 'selected=selected':''}}>{{$tecnico->nombre}}
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
        </div>
    </section>
@endsection
