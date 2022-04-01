@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <h3 class="page__heading col-4">Altas</h3>
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
                            @can('7.1 crear-alta')
                                <a class="btn btn-success mb-2" href="{{ route('altas.create') }}" data-widget="collapse" data-toggle="tooltip" title="7.1 Crear Alta"><i
                                        class="fas fa-plus"></i></a>
                            @endcan

                            <table id="altas" class="table table-responsive-sm table-striped table-bordered mt-2">
                                <thead>
                                    <th># Alta</th>
                                    @if (auth()->user()->sucursal_id == 1)
                                        <th>
                                            {{ 'Sucursal' }}
                                        </th>
                                    @endif
                                    <th>Vehículo</th>
                                    <th>Fecha y Hora</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($altas as $alta)
                                        <tr>
                                            <td>{{ $alta->id }}</td>
                                            {{-- @foreach ($sucursales as $sucursal) --}}
                                                @if (auth()->user()->sucursal_id == 1)
                                                    {{-- @if ($alta->sucursal_id == $sucursal->id) --}}
                                                    <td>
                                                        {{ $alta->sucursal->nombre }}
                                                    </td>
                                                    {{-- @endif --}}
                                                @endif
                                            {{-- @endforeach --}}
                                            <td>{{ $alta->vehiculo->vehiculo }}</td>
                                            <td>{{ $alta->created_at }}</td>
                                            <td>
                                                {{-- @can('7.2 editar-alta')
                                                    <a class="btn btn-warning"
                                                        href="{{ route('altas.edit', $alta->id) }}" data-widget="collapse" data-toggle="tooltip" title="2.2.2 Editar Alta"><i
                                                            class="fas fa-edit"></i></a>
                                                @endcan --}}

                                                @can('7.2 borrar-alta')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['altas.destroy', $alta->id], 'style' => 'display:inline']) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => '7.2 Borrar Alta']) }}
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
            $("#altas").DataTable({
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
