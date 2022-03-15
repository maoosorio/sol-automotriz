@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-header">
      <h3 class="page__heading">Usuarios</h3>
  </div>
      <div class="section-body">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">

                        @can('crear-usuario')
                        <a class="btn btn-success mb-2" href="{{ route('usuarios.create') }}"><i class="fas fa-plus"></i></a>
                        @endcan

                            <table id="usuarios" class="table table-responsive-sm table-striped table-bordered mt-2">
                              <thead>
                                  <th>Nombre</th>
                                  <th>E-mail</th>
                                  <th>Rol</th>
                                  <th>Acciones</th>
                              </thead>
                              <tbody>
                                @foreach ($usuarios as $usuario)
                                  <tr>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>
                                      @if(!empty($usuario->getRoleNames()))
                                        @foreach($usuario->getRoleNames() as $rolNombre)
                                          <h5><span class="badge badge-dark">{{ $rolNombre }}</span></h5>
                                        @endforeach
                                      @endif
                                    </td>

                                    <td>
                                        @can('editar-usuario')
                                        <a class="btn btn-warning" href="{{ route('usuarios.edit',$usuario->id) }}"><i class="fas fa-edit"></i></a>
                                        @endcan

                                        @can('borrar-usuario')
                                        {!! Form::open(['method' => 'DELETE','route' => ['usuarios.destroy', $usuario->id],'style'=>'display:inline']) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger'] )  }}
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
            $("#usuarios").DataTable({
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
