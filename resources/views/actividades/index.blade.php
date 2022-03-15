@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Actividades</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            @if (session('status'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            @endif

                            @can('crear-actividad')
                                <a class="btn btn-success mb-2" href="{{ route('actividades.create') }}"><i
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
                                            <td>{{ $actividad->tecnico->nombre }}</td>
                                            <td>

                                                @can('crear-asginacion')
                                                    <a class="btn btn-primary"
                                                        href="{{ route('actividades.asignar', $actividad->id) }}"><i
                                                            class="fas fa-tasks"></i></a>
                                                @endcan

                                                {{-- @can('editar-actividad')
                                                    <a class="btn btn-warning"
                                                        href="{{ route('actividades.edit', $actividad->id) }}"><i
                                                            class="fas fa-edit"></i></a>
                                                @endcan --}}

                                                @can('borrar-actividad')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['actividades.destroy', $actividad->id], 'style' => 'display:inline']) !!}
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
