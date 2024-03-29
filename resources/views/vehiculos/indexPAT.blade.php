@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <div class="row">
          <h3 class="page__heading col-4">Vehículos en el PAT</h3>
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
{{--
                        @can('3.1 crear-vehiculo')
                          <a class="btn btn-success mb-2" href="{{ route('vehiculos.create') }}" data-widget="collapse" data-toggle="tooltip" title="3.1 Crear Vehículo"><i class="fas fa-plus"></i></a>
                          @endcan --}}

                            <table id="vehiculos" class="table table-responsive-sm table-striped table-bordered mt-2">
                              <thead>
                                  <th># Proyecto</th>
                                  <th>Vehículo</th>
                                  <th>Placas</th>
                                    @if (auth()->user()->sucursal_id == 1)
                                        <th>
                                            {{ 'Sucursal' }}
                                        </th>
                                    @endif
                                  <th>Referencia</th>
                                  <th>Acciones</th>
                              </thead>
                              <tbody>
                                @foreach ($vehiculos as $vehiculo)
                                  <tr>
                                    <td>{{ $vehiculo->id }}</td>
                                    <td>{{ $vehiculo->vehiculo }}</td>
                                    <td>{{ $vehiculo->placa }}</td>
                                    @if (auth()->user()->sucursal_id == 1)
                                                <td>
                                                    {{ $vehiculo->sucursal->nombre }}
                                                </td>
                                                @endif
                                    <td>{{ $vehiculo->referencia }}</td>
                                    <td>
                                      {{-- @can('3.2 editar-vehiculo')
                                      <a class="btn btn-warning" href="{{ route('vehiculos.edit',$vehiculo->id) }}" data-widget="collapse" data-toggle="tooltip" title="3.2 Editar Vehículo"><i class="fas fa-edit"></i></a>
                                      @endcan --}}

                                      {{-- @can('3.3 borrar-vehiculo')
                                      {!! Form::open(['method' => 'DELETE','route' => ['vehiculos.destroy', $vehiculo->id],'style'=>'display:inline']) !!}
                                      {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => '3.3 Borrar Vehículo'] )  }}
                                      {!! Form::close() !!}
                                      @endcan --}}

                                      @can('3.6 ver-pat')
                                      <a class="btn btn-info" href="{{ route('vehiculos.verPAT',$vehiculo->id) }}" data-widget="collapse" data-toggle="tooltip" title="3.6 Ver PAT"><i class="fa fa-comments"></i></a>
                                      @endcan
                                      @can('3.5 borrar-pat')
                                      <a class="btn btn-danger" href="{{ route('vehiculos.borrarPAT2',$vehiculo->id) }}" data-widget="collapse" data-toggle="tooltip" title="3.5 Borrar PAT"><i class="fa fa-minus"></i></a>
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
@endsection
