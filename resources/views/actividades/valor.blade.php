@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h5 class="page__heading">Captura de Valores</h5>
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

                            {!! Form::open(['route' => 'actividades.guardaValor']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                    <input type="hidden" name="actividad_id" id="actividad_id"
                                        value="{{ $actividad->id }}">
                                    <input type="hidden" name="id" id="id" value="{{ $actividad->actividad_id }}">

                                    <div class="form-group row">
                                        <label for="actividad" class="col-sm-2 col-form-label">Actividad</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="actividad"
                                                value="{{ $actividad->actividad }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="valor_metrico" class="col-sm-2 col-form-label">Valor Métrico</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="valor_metrico" class="form-control"
                                                value="{{ old('valor_monetario') ?? ($actividad->valor_metrico ?? '') }}"
                                                placeholder="Valor Métrico">
                                        </div>
                                    </div>
                                    <fieldset class="form-group">
                                        <div class="row">
                                            <legend class="col-form-label col-sm-2 pt-0"></legend>
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="vmes" value="1" @if ($actividad->vmes == 1) checked @endif>
                                                        <label class="form-check-label">
                                                          Aprobado
                                                        </label>
                                                      </div>
                                                      <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="vmes" value="0" @if ($actividad->vmes == 0) checked @endif>
                                                        <label class="form-check-label">
                                                          No Aprobado
                                                        </label>
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group row">
                                        <label for="valor_monetario" class="col-sm-2 col-form-label">Valor Monetario</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="valor_monetario" class="form-control"
                                                value="{{ old('valor_monetario') ?? ($actividad->valor_monetario ?? '') }}"
                                                placeholder="Valor Monetario">
                                        </div>
                                    </div>
                                    <fieldset class="form-group">
                                        <div class="row">
                                            <legend class="col-form-label col-sm-2 pt-0"></legend>
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="vmos" value="1" @if ($actividad->vmos == 1) checked @endif>
                                                        <label class="form-check-label">Aprobado</label>
                                                      </div>
                                                      <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="vmos" value="0" @if ($actividad->vmos == 0) checked @endif>
                                                        <label class="form-check-label">No Aprobado</label>
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                    <a class="btn btn-secondary"
                                        href="{{ route('actividades.asignar', $actividad->actividad_id) }}">Regresar</a>
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
