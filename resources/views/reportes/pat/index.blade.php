@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <h3 class="page__heading col-8">Reporte Asistencia Técnica</h3>
                <div class="col-4">
                    @php
                        use App\Models\Sucursal;
                        $id = auth()->user()->sucursal_id;
                        $sucur = Sucursal::find($id);
                    @endphp
                    <p class="text-primary text-right">Sucursal: {{ $sucur->nombre }}
                    </p>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                <a href="{{  route('pdf.PAT') }}" class="btn btn-primary">Descargar PDF</a>
                            </div>

                            <table id="vehiculos" class="table table-responsive-sm table-striped table-bordered mt-2">
                                <thead>
                                    <th>Etapa</th>
                                    <th>Vehiculo</th>
                                    <th>Usuario</th>
                                    <th>Fecha y Hora</th>
                                </thead>
                                <tbody>
                                    @foreach ($vehiculos as $vehiculo)
                                        <tr>
                                            <td>{{ $vehiculo->etapa }}</td>
                                            <td>{{ $vehiculo->vehiculo }}</td>
                                            <td>{{ $vehiculo->nombre }}</td>
                                            <td>{{ $vehiculo->fecha }}</td>
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
    </section>
@endsection
{{--
@section('js')
    <script>
        $(function() {
            $("#vehiculos").DataTable({
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
@endsection --}}
