@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Registrar Préstamo</h3>
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

                        {!! Form::open(array('route' => 'prestamos.store','method'=>'POST')) !!}
                        <div class="row">
                            {{-- @if (auth()->user()->sucursal_id == 1) --}}
                            {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="sucursal_id">Sucursal</label>
                                    <select name="sucursal_id" id="sucursal_id" class="form-control select2bs4 @error('sucursal_id') is-invalid @enderror">
                                        <option value="0" disabled="disabled" selected="selected">Selecciona una opción...</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}" {{old('sucursal_id') == $sucursal->id ? 'selected=selected':''}}>{{$sucursal->nombre}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else --}}
                            {{-- <input class="form-control" type="hidden" name="sucursal_id" value="{{ auth()->user()->sucursal_id }}">
                            @endif --}}
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="tecnico_id">Nombre</label>
                                    <input class="form-control" type="hidden" name="estado" value="1">
                                    <select name="tecnico_id" id="tecnico_id" class="form-control select2bs4 @error('tecnico_id') is-invalid @enderror" data-live-search="true">
                                        <option value="0" disabled="disabled" selected="selected">Selecciona una opción...</option>
                                        @foreach ($tecnicos as $tecnico)
                                            <option value="{{$tecnico->id}}" {{old('tecnico_id') == $tecnico->id ? 'selected=selected':''}}>{{$tecnico->nombre}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="monto">Monto</label>
                                    <input class="form-control" type="number" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57))" name="monto">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="pagos">Pagos</label>
                                    <input class="form-control" type="number" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57))" name="pagos">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-primary">Guardar</button>
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

@section('js')
<script>
    $(document).ready(function() {
    $('#tecnico_id').select2();
});
</script>
@endsection
