@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Hierarquia</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Hierarquia</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">

        <div class="card-header hstack gap-2">

            <span class="ms-auto">
                @can('create-role')
                <a class="btn btn-primary" href="{{ route('role.create') }}" role="button">
                    <i class="fa-regular fa-square-plus"></i> Cadastrar
                </a>
                @endcan
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell">ID</th>
                        <th>Nome</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>

                    {{-- Imprimir os registros --}}
                    @forelse ($roles as $role)
                    <tr>
                        <th class="d-none d-sm-table-cell">{{ $role->id }}</th>
                        <td>{{ $role->name }}</td>
                        <td class="d-md-flex flex-row justify-content-center">

                            @can('index-role-permission')
                            <a href="{{ route('role-permission.index', ['role' => $role->id]) }}"
                                class="btn btn-info btn-sm me-1 mb-1 mb-md-0"><i class="fa-solid fa-list"></i>
                                Permissões</a>
                            @endcan

                            @can('edit-role')
                            <a href="{{ route('role.edit', ['role' => $role->id]) }}"
                                class="btn btn-default btn-sm me-1 mb-1 mb-md-0">
                                <i class="fa-solid fa-pen-to-square"></i></a>
                            @endcan

                            @can('destroy-role')
                            <form method="POST" action="{{ route('role.destroy', ['role' => $role->id]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm me-1 mb-1 mb-md-0"
                                    onclick="return confirm('Tem certeza que deseja apagar este registro?')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                            @endcan

                        </td>
                    </tr>
                    @empty
                    <div class="alert alert-danger" role="alert">
                        Nenhum papel encontrado!
                    </div>
                    @endforelse

                </tbody>
            </table>

            {{-- Imprimir a paginação --}}
            {{ $roles->links() }}

        </div>
    </div>
</div>
@endsection