@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Perfil</h2>
        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item"><a class="text-decoration-none"
                    href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Perfil</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-header hstack gap-2">
            <span class="ms-auto d-sm-flex flex-row">
                <a href="{{ route('profile.show') }}" class="btn btn-danger btn-sm me-1">
                    <i class="fa-solid fa-user-slash"></i>
                </a>
                Apagar Perfil
            </span>

        </div>
        <div class="card-body">

            <x-alert />

            <form action="{{ route('profile.update') }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-12">
                    <label for="name" class="form-label">Nome: </label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nome completo"
                        value="{{ old('name', $user->name) }}">
                </div>

                <div class="col-12">
                    <label for="email" class="form-label">E-mail: </label>
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="Melhor e-mail do usuário" value="{{ old('email', $user->email) }}">
                </div>

                <div class="col-12">
                    <label for="password" class="form-label">Senha: </label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Senha com no mínimo 6 caracteres" value="{{ old('password', $user->password) }}">
                </div>

                <div class="col mb-3 pt-5 text-end">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
