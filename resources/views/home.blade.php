@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-xl-6">

                                    <div class="card bg-primary">
                                            <div class="card-header">
                                            <h4>Usuarios</h4>
                                                @php
                                                 use App\Models\User;
                                                $cant_usuarios = User::count();
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-users fa-2x fa-pull-left"></i>
                                                    <span>{{$cant_usuarios}}</span></h2>
                                                <p class="text-right"><a href="/usuarios" class="text-white">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6">
                                        <div class="card bg-success">
                                            <div class="card-header">
                                            <h4>Roles</h4>
                                                @php
                                                use Spatie\Permission\Models\Role;
                                                 $cant_roles = Role::count();
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-user-lock fa-2x fa-pull-left"></i>
                                                    <span>{{$cant_roles}}</span></h2>
                                                <p class="text-right"><a href="/roles" class="text-white">Ver más</a></p>
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
