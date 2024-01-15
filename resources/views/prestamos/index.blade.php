@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <h3 class="page__heading col-4">Préstamos</h3>
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
                            @can('6.1 crear-prestamo')
                                <a class="btn btn-success mb-2" href="{{ route('prestamos.create') }}" data-widget="collapse" data-toggle="tooltip" title="6.1 Crear Préstamo"><i
                                        class="fas fa-plus"></i></a>
                            @endcan

                            <table id="prestamos" class="table table-responsive-sm table-striped table-bordered mt-2">
                                <thead>
                                    <th>Nombre</th>
                                    <th>Monto</th>
                                    {{-- <th>Tipo</th> --}}
                                    <th>Estado</th>
                                    @if (auth()->user()->sucursal_id == 1)
                                        <th>
                                            {{ 'Sucursal' }}
                                        </th>
                                    @endif
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($prestamos as $prestamo)
                                        <tr>
                                            <td>{{ $prestamo->tecnico->nombre }}</td>
                                            <td>{{ $prestamo->monto }}</td>
                                            {{-- <td>{{ $prestamo->tipo }}</td> --}}
                                            <td>
                                                @php
                                                if($prestamo->estado == 0){
                                                echo "<b class='text-success'>Pagado</b>";
                                                }if($prestamo->estado == 1){
                                                echo "<b class='text-danger'>No Pagado</b>";
                                                }
                                                @endphp
                                                </td>
                                            @if (auth()->user()->sucursal_id == 1)
                                                <td>
                                                    {{ $prestamo->tecnico->sucursal->nombre }}
                                                </td>
                                                @endif
                                            <td>
                                                @if ($prestamo->estado == 1)
                                                @can('6.2 ver-pagos')
                                                <a class="btn btn-primary"
                                                href="{{ route('prestamos.edit', $prestamo->id) }}" data-widget="collapse" data-toggle="tooltip" title="6.2 Ver Pagos"><i
                                                class="fa fa-money-bill"></i></a>
                                                @endcan
                                                @endif

                                                {{-- @can('6.3 borrar-prestamo')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['prestamos.destroy', $prestamo->id], 'style' => 'display:inline']) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => '6.3 Borrar Préstamo']) }}
                                                    {!! Form::close() !!}
                                                @endcan --}}
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
            $("#prestamos").DataTable({
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
