@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
            <h3 class="page__heading col-4">Actividades</h3>
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

                            @if (session('status'))
                            <div class="alert alert-{{ session('color') }} alert-dismissible fade show" role="alert">{{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            @endif

                            @can('5.1 crear-actividad')
                                <a class="btn btn-success mb-2" href="{{ route('actividades.create') }}" data-toggle="tooltip" data-placement="top" title="5.1 Crear Actividad"><i
                                        class="fas fa-plus"></i></a>
                            @endcan

                            <table id="actividades" class="table table-responsive-sm table-striped table-bordered mt-2">
                                <thead>
                                    <th>Fecha</th>
                                    <th>Técnico</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($actividades as $actividad)
                                        <tr>
                                            <td>{{ $actividad->fecha }}</td>
                                            @if (auth()->user()->sucursal_id == 1)
                                            <td>{{ $actividad->tecnico->nombre }}</td>
                                            @else
                                            <td>{{ $actividad->nombre }}</td>
                                            @endif
                                            <td>

                                                @can('5.2 ver-asignacion')
                                                    <a class="btn btn-primary"
                                                        href="{{ route('actividades.asignar', $actividad->id) }}"><i
                                                            class="fas fa-tasks" data-toggle="tooltip" data-placement="top" title="5.2 Ver Asignación"></i></a>
                                                @endcan

                                                @can('5.3 borrar-actividad')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['actividades.destroy', $actividad->id], 'style' => 'display:inline']) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => '5.3 Borrar Actividad']) }}
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
    </section>
@endsection

@section('js')
    <script>
        $(function() {
            $("#actividades").DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "lengthMenu": [5, 10, 25, 50],
                language: {
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "infoThousands": ",",
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                }
            });
        });
    </script>
@endsection
