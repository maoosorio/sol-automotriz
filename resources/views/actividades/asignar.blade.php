@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h5 class="page__heading">Actividades de: <b class="text-success">{{ $actividad->tecnico->nombre }}</b></h5>
            <h5 class="page__heading">Fecha: <b class="text-success">{{ $actividad->fecha }}</b></h5>
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

                            {!! Form::open(['route' => 'actividades.asignacion']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="hidden" name="actividad_id" value="{{ $actividad->id }}">
                                            <select name="vehiculo_id" id="vehiculo_id"
                                                class="form-control select2bs4 @error('vehiculo_id') is-invalid @enderror" data-live-search="true">
                                                <option value="0" disabled="disabled" selected="selected">Selecciona un
                                                    vehículo...</option>
                                                @foreach ($vehiculos as $vehiculo)
                                                    <option value="{{ $vehiculo->id }}"
                                                        {{ old('vehiculo_id') == $vehiculo->id ? 'selected=selected' : '' }}>
                                                        {{ $vehiculo->vehiculo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <input type="actividad" name="actividad" class="form-control"
                                                placeholder="Ingresa la actividad">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">Horario para esta actividad:</label>
                                            </div>
                                        </div>
                                        <div id="rol" class="col-12">
                                            <div class="form-group">
                                                @foreach($horarios as $horario)
                                                <label><input type="checkbox" name="horario_id[]" value="{{ $horario->id }}" > {{ $horario->hora }}</label>
                                                    {{-- <label>{{ Form::checkbox('horario_id[]', $horario->id, false, array('name' => 'horario_id')) }}
                                                    {{ $horario->hora }}</label> --}}
                                                <br/>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="5.4.1 Crear Asignacion">Guardar</button>
                                </div>
                            </div>
                            {!! Form::close() !!}

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <table class="table table-responsive-sm table-striped table-bordered mt-2">
                                        <thead>
                                            <th>Hora</th>
                                            <th>Vehículo</th>
                                            <th>Actividad</th>
                                            <th>Acciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($lista as $row)
                                                <tr>
                                                    <td>{{ $row->hora }}</td>
                                                    <td>{{ $row->vehiculo }}</td>
                                                    <td>{{ $row->actividad }}</td>
                                                    <td>
                                                        {{-- @can('editar-asignacion')
                                                            <a href="{{route('actividades.asignacion.update', $row->id)}}" class="btn btn-warning" data-toggle="modal"
                                                                data-target="#editarAsignacion" data-id="{{ $row->id }}"
                                                                data-actividadid="{{ $row->actividad_id }}"
                                                                data-horarioid="{{ $row->horario_id }}"
                                                                data-vehiculoid="{{ $row->vehiculo_id }}"
                                                                data-actividad="{{ $row->actividad }}"><i
                                                                    class="fas fa-edit"></i></a>
                                                        @endcan --}}
                                                        @can('ver-reporte')
                                                        @php
                                                        if($row->vmes == 0){
                                                            echo "<span class='badge badge-danger mr-2'><i
                                                                    class='fas fa-ruler'></i></span>";
                                                        }else{
                                                            echo "<span class='badge badge-success mr-2'><i
                                                                    class='fas fa-ruler'></i></span>";
                                                        }
                                                        if($row->vmos == 0){
                                                            echo "<span class='badge badge-danger mr-2'><i
                                                                    class='fas fa-dollar-sign'></i></span>";
                                                        }else{
                                                            echo "<span class='badge badge-success mr-2'><i
                                                                    class='fas fa-dollar-sign'></i></span>";
                                                        }

                                                        @endphp
                                                        @endcan

                                                        @can('5.4.2 editar-asignacion')
                                                            <a class="btn btn-warning"
                                                                href="{{ route('actividades.agregaValor', $row->id) }}"><i class="fa fa-briefcase"></i></a>
                                                        @endcan

                                                        @can('5.4.3 borrar-asignacion')
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['actividades.asignacion.destroy', $row->id, $row->actividad_id], 'style' => 'display:inline']) !!}
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
    {{-- @foreach ($lista as $row)
    <div class="modal fade" id="editarAsignacion" tabindex="-1" role="dialog" aria-labelledby="tituloModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Editar Actividad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['method' => 'POST', 'route' => ['actividades.asignacion.update', $row->id]]) !!}
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="actividad_id" id="actividadid">
                <div class="modal-body">
                    <select name="horario_id" id="horario_id"
                        class="form-control mb-2 select2bs4 @error('horario_id') is-invalid @enderror">
                        <option value="" id="horarioid" selected="selected">Selecciona la hora</option>
                        @foreach ($horarios as $horario)
                            <option id="horarioid" value="{{ $horario->id }}"
                                {{ old('horario_id') == $horario->id ? 'selected=selected' : '' }}>{{ $horario->hora }}
                            </option>
                        @endforeach
                    </select>
                    <select name="vehiculo_id" id="vehiculo_id"
                        class="form-control mb-2 select2bs4 @error('vehiculo_id') is-invalid @enderror">
                        <option value="" id="vehiculoid" selected="selected">Selecciona un vehículo...</option>
                        @foreach ($vehiculos as $vehiculo)
                            <option id="vehiculoid" value="{{ $vehiculo->id }}"
                                {{ old('vehiculo_id') == $vehiculo->id ? 'selected=selected' : '' }}>
                                {{ $vehiculo->vehiculo }}
                            </option>
                        @endforeach
                    </select>
                    <input class="form-control mb-2" type="text" name="actividad" value="" id="actividad" class="form-control">
                </div>
                <div class="modal-footer">
                    {!! Form::submit('Modificar', ['class' => 'btn btn-primary']) !!}
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @endforeach --}}
@endsection

@section('css')
<style>
#rol {
    columns: 3;
  }
  @media (min-width: 400px) {
    #rol {
      columns: 1;
    }
  }
  @media (min-width: 768px) {
    #rol {
      columns: 2;
    }
  }
  @media (min-width: 900px) {
    #rol {
      columns: 4;
    }
  }
</style>
@endsection

@section('js')
    <script>
        // $(function() {
        //     $('#editarAsignacion').on('show.bs.modal', function(e) {
        //         var btn = $(e.relatedTarget);
        //         $('#editarAsignacion #id').attr('value', btn.data('id'));
        //         $('#editarAsignacion #actividadid').attr('value', btn.data('actividadid'));
        //         $('#editarAsignacion #horarioid').val(btn.data('horarioid'));
        //         $('#editarAsignacion #vehiculoid').val(btn.data('vehiculoid'));
        //         $('#editarAsignacion #actividad').attr('value', btn.data('actividad'));
        //     });
        // });
        if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
}
    </script>
    <script>
        $(document).ready(function() {
        $('#vehiculo_id').select2();
    });
    </script>
@endsection
