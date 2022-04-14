@extends('layouts.app')

@section('content')
@php
session()->forget('sucursal_id');
@endphp
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Elije una sucursal</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-12 col-xs-12 col-12 col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            {!! Form::model($user, ['method' => 'PATCH','route' => ['sucursal.asociar', $user->id]]) !!}
                                            <div class="form-group">

                                            @foreach ($sucursales->sucursal as $sucursal)
                                                <div class="form-check row">
                                                <label class="form-check-label col-6">{{ $sucursal->nombre }}</label>
                                                <input class="form-check-input col-4" type="radio" name="sucursal_id" value="{{ $sucursal->id }}">
                                                </div>
                                            @endforeach

                                            </div>
                                            <button type="submit" class="form-control btn btn-primary">Elegir</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
