@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <h3 class="page__heading col-4">Ver Pagos</h3>
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

                        {!! Form::model($prestamo, ['method' => 'PATCH','route' => ['prestamos.update', $prestamo->id], 'class'=>'form-inline']) !!}
                        <div class="row">
                            @foreach ( $prestamos as $row)
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                    <div class="form-group">
                                        {{-- <input class="form-control" type="text" name="id" value="{{ $row->id }}"> --}}
                                        <label for="pago" class="mr-2">Pago</label>
                                        {!! Form::text('pago', $row->monto, array('class' => 'form-control mr-2', 'readonly')) !!}
                                        @if ( $row->estado == 'Pagado')
                                        <label for="pago" class="text-success">{{ $row->estado }}  {{ $row->fecha }}</label>
                                        @else
                                        {{-- <button type="submit" class="btn btn-primary">Pagar</button> --}}
                                        <input type="radio" name="id" value="{{ $row->id }}">
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                            @if( $prestamoss == 0)
                            <a href="{{ route('prestamos.index') }}" class="btn btn-default">Regresar</a>
                            @else
                            @can('6.3 agregar-pago')
                            <button type="submit" class="btn btn-primary" data-widget="collapse" data-toggle="tooltip" title="6.3 Agregar Pago">Pagar</button>
                            @endcan
                            @endif
                            </div>
                        </div>
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
