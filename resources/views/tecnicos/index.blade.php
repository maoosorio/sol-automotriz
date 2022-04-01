@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <h3 class="page__heading col-4">Técnicos</h3>
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
                            @can('2.2.1 crear-tecnico')
                                <a class="btn btn-success mb-2" href="{{ route('tecnicos.create') }}" data-widget="collapse" data-toggle="tooltip" title="2.2.1 Crear Técnico"><i
                                        class="fas fa-plus"></i></a>
                            @endcan

                            <table id="tecnicos" class="table table-responsive-sm table-striped table-bordered mt-2">
                                <thead>
                                    <th>Nombre</th>
                                    @if (auth()->user()->sucursal_id == 1)
                                        <th>
                                            {{ 'Sucursal' }}
                                        </th>
                                    @endif
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($tecnicos as $tecnico)
                                        <tr>
                                            <td>{{ $tecnico->nombre }}</td>
                                            @if (auth()->user()->sucursal_id == 1)
                                                <td>
                                                    {{ $tecnico->sucursal->nombre }}
                                                </td>
                                                @endif
                                            <td>
                                                @can('2.2.2 editar-tecnico')
                                                    <a class="btn btn-warning"
                                                        href="{{ route('tecnicos.edit', $tecnico->id) }}" data-widget="collapse" data-toggle="tooltip" title="2.2.2 Editar Técnico"><i
                                                            class="fas fa-edit"></i></a>
                                                @endcan

                                                @can('2.2.3 borrar-tecnico')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['tecnicos.destroy', $tecnico->id], 'style' => 'display:inline']) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => '2.2.3 Borrar Técnico']) }}
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
            $("#tecnicos").DataTable({
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
