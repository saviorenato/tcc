@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Hierarquia</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('role.index') }}" class="text-decoration-none">Hierarquia</a>
            </li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span class="ms-auto d-sm-flex flex-row"></span>
        </div>

        <div class="card-body">

            <x-alert />

            <form action="{{ route('role.update', ['role' => $role->id]) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-12">
                    <label for="name" class="form-label">Nome: </label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nome do curso"
                        value="{{ old('name', $role->name) }}">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-warning bt-sm">Salvar</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection