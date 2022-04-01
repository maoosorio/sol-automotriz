@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <h3 class="page__heading col-4">Traslados</h3>
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
                            @can('4.1 crear-traslado')
                                <a class="btn btn-success mb-2" href="{{ route('traslados.create') }}" data-widget="collapse" data-toggle="tooltip" title="4.1 Crear Traslado"><i
                                        class="fas fa-plus"></i></a>
                            @endcan

                            <table id="traslados" class="table table-responsive-sm table-striped table-bordered mt-2">
                                <thead>
                                    <th># Traslado</th>
                                    <th>Vehículo</th>
                                    @if (auth()->user()->sucursal_id == 1)
                                        <th>
                                            {{ 'Sucursal Origen' }}
                                        </th>
                                    @endif
                                    <th>Sucursal Destino</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                {{-- @php
                                dd($traslados);
                                die();
                                @endphp --}}
                                    @foreach ($traslados as $traslado)
                                        <tr>
                                            <td>{{ $traslado->id }}</td>
                                            <td>{{ $traslado->vehiculo }}</td>

                                            {{-- @foreach ($sucursales as $sucursal) --}}

                                            @if (auth()->user()->sucursal_id == 1)
                                                {{-- @if ($traslado->sucursal_origen == $sucursal->id) --}}
                                                <td>{{ $traslado->origen }}</td>
                                                {{-- @endif
                                                @if ($traslado->sucursal_destino == $sucursal->id) --}}
                                                <td>{{ $traslado->destino }}</td>
                                                {{-- @endif --}}
                                            @else
                                                {{-- @if ($traslado->sucursal_destino == $sucursal->id) --}}
                                                <td>{{ $traslado->origen }}</td>
                                                {{-- @endif --}}
                                            @endif

                                            {{-- @endforeach --}}
                                            <td>@php
                                                if($traslado->estado == 'En Proceso'){
                                                echo "<b>$traslado->estado</b>";
                                                }
                                                if($traslado->estado == 'Aprobado'){
                                                echo "<b class='text-success'>$traslado->estado</b>";
                                                }if($traslado->estado == 'Rechazado'){
                                                echo "<b class='text-danger'>$traslado->estado</b>";
                                                }
                                                @endphp
                                            </td>
                                            <td>
                                                {{-- @if ($traslado->estado == 'En Proceso')
                                                @can('4.2 editar-traslado')
                                                <a class="btn btn-warning"
                                                href="{{ route('traslados.edit', $traslado->id) }}" data-widget="collapse" data-toggle="tooltip" title="4.2 Editar Traslado"><i
                                                class="fas fa-edit"></i></a>
                                                @endcan
                                                @endif --}}

                                                @can('4.3 aprobar-traslado')
                                                <a class="btn btn-success"
                                                href="{{ route('traslados.aprobar', $traslado->id) }}" data-widget="collapse" data-toggle="tooltip" title="4.3 Aprobar Traslado"><i
                                                class="fas fa-check"></i></a>
                                                @endcan

                                                @if ($traslado->estado == 'En Proceso')
                                                @can('4.4 borrar-traslado')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['traslados.destroy', $traslado->id], 'style' => 'display:inline']) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => '4.4 Borrar Traslado']) }}
                                                    {!! Form::close() !!}
                                                @endcan
                                                @endif
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
            $("#traslados").DataTable({
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
