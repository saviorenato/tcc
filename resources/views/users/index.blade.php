@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Usuário</h2>
        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Usuários</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-header hstack gap-2">
            <span class="ms-auto">
                @can('create-user')
                <a class="btn btn-primary" href="{{ route('user.create') }}" role="button">
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
                        <th>Nome</th>
                        <th class="d-none d-md-table-cell">E-mail</th>
                        <th>Permissão</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($users as $user)
                    <tr>
                        <th>{{ $loop->index + 1 }}</th>
                        <td>{{ $user->name }}</td>
                        <td class="d-none d-md-table-cell">{{ $user->email }}</td>
                        <td>
                            @forelse ($user->getRoleNames() as $role)
                            {{ $role }}
                            @empty
                            {{ '-' }}
                            @endforelse
                        </td>
                        <td>
                            {{
                            \Carbon\Carbon::parse($user->created_at)->tz('America/Sao_Paulo')->format('d/m/Y H:i:s')
                            }}
                        </td>
                        <td>
                            {{
                            \Carbon\Carbon::parse($user->updated_at)->tz('America/Sao_Paulo')->format('d/m/Y H:i:s')
                            }}
                        </td>
                        <td class="d-md-flex flex-row justify-content-center">

                            @can('edit-user')
                            <a href="{{ route('user.edit', ['user' => $user->id]) }}"
                                class="btn btn-default border border-secondary btn-sm me-1 mb-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            @endcan

                            @can('destroy-user')
                            <form method="POST" action="{{ route('user.destroy', ['user' => $user->id]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm me-1 mb-1"
                                    onclick="return confirm('Tem certeza que deseja apagar este Usuário?')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                            @endcan

                        </td>
                    </tr>
                    @empty
                    <div class="alert alert-danger" role="alert">Nenhum usuário encontrado!</div>
                    @endforelse

                </tbody>
            </table>

            {{ $users->onEachSide(0)->links() }}

        </div>
    </div>
</div>
@endsection