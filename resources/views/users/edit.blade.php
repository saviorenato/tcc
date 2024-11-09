@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Usuário</h2>
        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item"><a class="text-decoration-none"
                    href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('user.index') }}">Usuários</a>
            </li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-body">

            <x-alert />

            <form action="{{ route('user.update', ['user' => $user->id]) }}" method="POST" class="row g-3">
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
                    <label for="roles" class="form-label">Papel: </label>
                    <select name="roles" class="form-select" id="roles">
                        <option value="">Selecione</option>
                        @forelse ($roles as $role)
                        @if ($role != 'Super Admin')
                        <option {{ old('roles', $userRoles)==$role ? 'selected' : '' }} value="{{ $role }}">{{ $role }}
                        </option>
                        @else
                        @if (Auth::user()->hasRole('Super Admin'))
                        <option {{ old('roles', $userRoles)==$role ? 'selected' : '' }} value="{{ $role }}">{{ $role }}
                        </option>
                        @endif
                        @endif
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="col mb-3 pt-5 text-end">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
