@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <h3 class="page__heading col-4">Sucursales</h3>
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
                            @can('1.1.1 crear-sucursal')
                                <a class="btn btn-success mb-2" href="{{ route('sucursales.create') }}"><i
                                        class="fas fa-plus" data-widget="collapse" data-toggle="tooltip" title="1.1.1 Crear Sucursal"></i></a>
                            @endcan

                            <table id="sucursales" class="table table-responsive-sm table-striped table-bordered mt-2">
                                <thead>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($sucursales as $sucursal)
                                        <tr>
                                            <td>{{ $sucursal->nombre }}</td>
                                            <td>
                                                @can('1.1.2 editar-sucursal')
                                                    <a class="btn btn-warning"
                                                        href="{{ route('sucursales.edit', $sucursal->id) }}" data-widget="collapse" data-toggle="tooltip" title="1.1.2 Editar Sucursal"><i
                                                            class="fas fa-edit"></i></a>
                                                @endcan

                                                @can('1.1.3 borrar-sucursal')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['sucursales.destroy', $sucursal->id], 'style' => 'display:inline']) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => '1.1.3 Borrar Sucursal']) }}
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
            $("#surcusales").DataTable({
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
