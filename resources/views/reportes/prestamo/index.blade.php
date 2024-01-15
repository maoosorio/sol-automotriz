@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <h3 class="page__heading col-4">Reporte de Préstamos</h3>
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
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                <a href="{{  route('pdf.prestamos') }}" target="blank" class="btn btn-primary">Descargar PDF</a>
                            </div>
                            <table id="reporte" class="table table-responsive-sm table-striped table-bordered mt-2">
                                <thead class="bg-dark">
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Monto</td>
                                        <td>Estado</td>
                                        <td>Sucursal</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tbody>
                                        @foreach ($prestamos as $item)
                                        <tr>
                                        <td>{{ $item->tecnico->nombre }}</td>
                                        <td>{{ $item->monto }}</td>
                                        <td>
                                        @php
                                            if($item->estado == 0){
                                            echo "<b class='text-success'>Pagado</b>";
                                            }if($item->estado == 1){
                                            echo "<b class='text-danger'>No Pagado</b>";
                                            }
                                        @endphp
                                        </td>
                                        <td>{{ $item->tecnico->sucursal->nombre }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
