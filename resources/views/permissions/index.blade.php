@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Permissões</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Permissões</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span class="ms-auto">
                @can('create-permission')
                <a class="btn btn-primary" href="{{ route('permission.create') }}" role="button">
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
                        <th>ID</th>
                        <th class="d-none d-md-table-cell">Título</th>
                        <th>Nome</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($permissions as $permission)
                    <tr>
                        <th>{{ $loop->index + 1 }}</th>
                        <td class="d-none d-md-table-cell">{{ $permission->title }}</td>
                        <td>{{ $permission->name }}</td>
                        <td class="d-md-flex flex-row justify-content-center">
                            @can('edit-permission')
                            <a href="{{ route('permission.edit', ['permission' => $permission->id]) }}"
                                class="btn btn-default btn-sm me-1 mb-1 mb-md-0">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            @endcan

                            @can('destroy-permission')
                            <form action="{{ route('permission.destroy', ['permission' => $permission->id]) }}"
                                method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm me-1"
                                    onclick="return confirm('Tem certeza que deseja apagar este registro?')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <div class="alert alert-danger" role="alert">
                        Nenhuma permissão encontrada!
                    </div>
                    @endforelse

                </tbody>
            </table>

            {{ $permissions->links() }}

        </div>
    </div>
</div>
@endsection