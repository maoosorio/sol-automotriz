@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <h3 class="page__heading col-4">Vehículo <b class="text-success">{{ $vehiculo->vehiculo }}</b></h3>
                <div class="col-4"></div>
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

                            @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>¡Revise los campos!</strong>
                                    @foreach ($errors->all() as $error)
                                        <span class="badge badge-danger">{{ $error }}</span>
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if ($status)
                                <div class="alert alert-{{ $color }} alert-dismissible fade show" role="alert">
                                    {{ $status }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @php
                                use App\Models\Proceso;
                                use App\Models\Etapa;
                                $c = 1;
                                $proceso = Proceso::where('vehiculo_id', $vehiculo->id)->count();
                                $procesos = Proceso::where('vehiculo_id', $vehiculo->id)->orderBy('id','desc')->get();
                                $checar_proceso = Proceso::where('vehiculo_id', $vehiculo->id)->latest('id')->first();

                                if ($proceso == 0) {
                                    $c = 1;
                                } else {
                                    $c = $proceso + 1;
                                }
                            @endphp

                            @can('3.6.1 agregar-proceso')
                                {!! Form::open(['route' => 'vehiculos.agregarProceso']) !!}
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                    <input type="hidden" name="vehiculo_id" value="{{ $vehiculo->id }}">
                                    <input type="hidden" name="proceso" value="{{ $c }}">
                                    @if (isset($checar_proceso['estado']) != null || $proceso == 0)
                                        <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                            title="3.6.1 Agregar Proceso"><i class="fa fa-plus"></i></button>
                                    @else
                                        <button type="submit" class="btn btn-success d-none" data-toggle="tooltip"
                                            data-placement="top" title="3.6.1 Agregar Proceso"><i
                                                class="fa fa-plus"></i></button>
                                    @endif

                                </div>
                                {!! Form::close() !!}
                            @endcan

                            @foreach ($procesos as $row)
                            <h2 class="text-primary"><b>Proceso {{ $row->proceso }}</b></h2>

                            @php
                                $etapa = Etapa::where('proceso_id', $row->id)->count();
                                $etapas = Etapa::where('proceso_id', $row->id)->get();
                                $checar_etapa = Etapa::where('proceso_id', $row->id)->latest('proceso_id')->first();
                                $checar_etapass = Etapa::where('proceso_id', $row->id)->latest('id')->first();
                                $checar_etapas = Etapa::where('proceso_id', $row->id)->latest('id')->count();
                            if( $proceso > 1){
                                $i = 1;
                                if ($etapa == 0) {
                                    $i = $i + 1;
                                }else{
                                    $i = $checar_etapass['etapa'] + 1;
                                }

                            }else{
                                if ($etapa == 0) {
                                    $i = 1;
                                }else{
                                    $i = $etapa + 1;
                                }
                            }
                            @endphp
                                @if ($checar_etapas == 5 && $proceso == 1)
                                <p class="text-danger">Ya no es posible agregar más etapas, inicie un nuevo proceso.</p>
                                @endif

                                @if($checar_etapas == 4 && $proceso > 1)
                                <p class="text-danger">Ya no es posible agregar más etapas, inicie un nuevo proceso.</p>
                                @endif

                                @if ($proceso > 1 && $checar_etapas < 4)
                                @can('3.6.1.1 agregar-etapa')
                                    {!! Form::open(['route' => 'vehiculos.agregarEtapa']) !!}
                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                        <label for="etapa">Etapa {{ $i }}</label>
                                        <input type="hidden" name="vehiculo_id" value="{{ $vehiculo->id }}">
                                        <input type="hidden" name="proceso_id" value="{{ $row->id }}">
                                        <input type="hidden" name="proceso_padre" value="{{ $row->proceso }}">
                                        <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                                        <input type="hidden" name="etapa" value="{{ $i }}">
                                        <input class="form-control" type="text" name="valor" placeholder="Agregue sus comentarios aquí">
                                        @if ($etapas != false || $checar_etapa['estado'] != null)
                                            <button type="submit" class="btn btn-success mt-2" data-toggle="tooltip" data-placement="top"
                                                title="3.6.1.1 Agregar Etapa"><i class="fa fa-plus"></i></button>
                                        @else
                                            <button type="submit" class="btn btn-success d-none" data-toggle="tooltip"
                                                data-placement="top" title="3.6.1.1 Agregar Etapa"><i
                                                    class="fa fa-plus"></i></button>
                                        @endif
                                    </div>
                                    {!! Form::close() !!}
                                @endcan
                                @endif

                                @if ($proceso == 1 && $checar_etapas < 5)
                                @can('3.6.1.1 agregar-etapa')
                                    {!! Form::open(['route' => 'vehiculos.agregarEtapa']) !!}
                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                        <label for="etapa">Etapa {{ $i }}</label>
                                        <input type="hidden" name="vehiculo_id" value="{{ $vehiculo->id }}">
                                        <input type="hidden" name="proceso_id" value="{{ $row->id }}">
                                        <input type="hidden" name="proceso_padre" value="{{ $row->proceso }}">
                                        <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                                        <input type="hidden" name="etapa" value="{{ $i }}">
                                        <input class="form-control" type="text" name="valor" placeholder="Agregue sus comentarios aquí">
                                        @if ($etapas != false || $checar_etapa['estado'] != null)
                                            <button type="submit" class="btn btn-success mt-2" data-toggle="tooltip" data-placement="top"
                                                title="3.6.1.1 Agregar Etapa"><i class="fa fa-plus"></i></button>
                                        @else
                                            <button type="submit" class="btn btn-success d-none" data-toggle="tooltip"
                                                data-placement="top" title="3.6.1.1 Agregar Etapa"><i
                                                    class="fa fa-plus"></i></button>
                                        @endif
                                    </div>
                                    {!! Form::close() !!}
                                @endcan
                                @endif

                            @foreach ( $etapas as $fila )
                                <h3>
                                    @if ( $fila->etapa)
                                    @can('3.6.1.2 borrar-etapa')
                                        {!! Form::open(['method' => 'DELETE','route' => ['vehiculos.borrarEtapa',$fila->id,$vehiculo->id],'style'=>'display:inline']) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => '3.6.1.2 Borrar Etapa'] )  }}
                                        {!! Form::close() !!}
                                    @endcan
                                    @endif
                                Etapa {{ $fila->etapa }} <b class="text-success">{{ $fila->valor }}</b>
                                </h3>
                            @endforeach

                            @endforeach

                            {!! Form::open(['route' => 'vehiculos.agregarProceso']) !!}
                            {{-- {!! Form::model($etapa, ['method' => 'PATCH','route' => ['vehiculos.agregarEtapa', $etapa->id]]) !!} --}}
                            {{-- <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <input type="hidden" name="vehiculo_id" value="{{ $vehiculo->id }}">
                                                <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                                                <label for="etapa">Etapa 1 - Estatus Inicial</label>
                                                <input type="hidden" name="etapa" value="1">
                                                <label for="valor">Escribe</label>
                                                {!! Form::text('valor', null, array('class' => 'form-control')) !!}
                                            </div>
                                            @can('3.6.1.1 agregar-etapa1')
                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="3.6.1 Agregar Etapa">Guardar</button>
                                            </div>
                                            @endcan
                                            <div class="form-group">
                                                <input type="hidden" name="vehiculo_id" value="{{ $vehiculo->id }}">
                                                <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                                                <label for="etapa">Etapa 2 - Solicitud de Datos/Información de parte del Asesor Técnico</label>
                                                <input type="hidden" name="etapa" value="2">
                                                <label for="valor">Escribe</label>
                                                {!! Form::text('valor', null, array('class' => 'form-control')) !!}
                                            </div>
                                            @can('3.6.1.2 agregar-etapa2')
                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="3.6.1 Agregar Etapa">Guardar</button>
                                            </div>
                                            @endcan
                                            <div class="form-group">
                                                <input type="hidden" name="vehiculo_id" value="{{ $vehiculo->id }}">
                                                <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                                                <label for="etapa">Etapa 3 - Subir Información Solicitada</label>
                                                <input type="hidden" name="etapa" value="3">
                                                <label for="valor">Escribe</label>
                                                {!! Form::text('valor', null, array('class' => 'form-control')) !!}
                                            </div>
                                            @can('3.6.1.3 agregar-etapa3')
                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="3.6.1 Agregar Etapa">Guardar</button>
                                            </div>
                                            @endcan
                                            <div class="form-group">
                                                <input type="hidden" name="vehiculo_id" value="{{ $vehiculo->id }}">
                                                <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                                                <label for="etapa">Etapa 4 - Instrucción de  siguiente paso de parte del Asesor Técnico</label>
                                                <input type="hidden" name="etapa" value="4">
                                                <label for="valor">Escribe</label>
                                                {!! Form::text('valor', null, array('class' => 'form-control')) !!}
                                            </div>
                                            @can('3.6.1.4 agregar-etapa4')
                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="3.6.1 Agregar Etapa">Guardar</button>
                                            </div>
                                            @endcan
                                            <div class="form-group">
                                                <input type="hidden" name="vehiculo_id" value="{{ $vehiculo->id }}">
                                                <input type="hidden" name="usuario_id" value="{{ auth()->user()->id }}">
                                                <label for="etapa">Etapa 5 - Emitir Resultado</label>
                                                <input type="hidden" name="etapa" value="5">
                                                <label for="valor">Escribe</label>
                                                {!! Form::text('valor', null, array('class' => 'form-control')) !!}
                                            </div>
                                            @can('3.6.1.5 agregar-etapa5')
                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="3.6.1 Agregar Etapa">Guardar</button>
                                            </div>
                                            @endcan
                                        </div>
                                    </div>
                                </div>

                            </div> --}}
                            {!! Form::close() !!}

                            {{-- <table class="table table-responsive-sm table-striped table-bordered mt-2">
                              <thead>
                                  <th>Proceso</th>
                                  <th>Etapa</th>
                                  <th>Valor</th>
                                  <th>Acciones</th>
                              </thead>
                              <tbody>
                                @foreach ($etapas as $etapa)
                                  <tr>
                                    <td>{{ $etapa->proceso }}</td>
                                    <td>{{ $etapa->etapa }}</td>
                                    <td>{{ $etapa->valor }}</td>
                                    <td>
                                      @can('3.6.3 borrar-etapa')
                                      {!! Form::open(['method' => 'DELETE','route' => ['vehiculos.borrarEtapa',$vehiculo->id, $etapa->id],'style'=>'display:inline']) !!}
                                      {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => '3.3 Borrar Etapa'] )  }}
                                      {!! Form::close() !!}
                                      @endcan

                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
