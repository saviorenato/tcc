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
            <span class="ms-auto d-sm-flex flex-row"></span>
        </div>
        <div class="card-body">

            <x-alert />

            <dl class="row">
                <dt class="col-sm-3">Nome: </dt>
                <dd class="col-sm-9">{{ $user->name }}</dd>

                <dt class="col-sm-3">E-mail: </dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>
            </dl>
        </div>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="col-md-12">
            <h1 class="text-center">Tem certeza que deseja apagar seu perfil?</h1>
        </div>
        <div class="card-body hstack gap-2 justify-content-center">
            <form action="{{ route('profile.destroy', ['user' => $user->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-success"
                    onclick="return confirm('Tem certeza que deseja apagar seu perfil?')">
                    Sim
                </button>
            </form>
            <a href="{{ route('profile.edit') }}" class="btn btn-danger">Não</a>
        </div>
    </div>

</div>
@endsection
