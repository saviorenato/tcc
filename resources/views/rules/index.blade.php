@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Regras</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Regras</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-header hstack gap-2">
            <span></span>
            <span class="ms-auto">
                <a class="btn btn-primary" href="{{ route('rules.create') }}" role="button">
                    <i class="fa-regular fa-square-plus"></i> Cadastrar
                </a>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell">ID</th>
                        <th>Nome</th>
                        <th>Aliquota</th>
                        <th>Valor</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($rules as $rule)
                    <tr>
                        <td class="d-none d-sm-table-cell">{{ $rule->id }}</td>
                        <td>{{ $rule->name }}</td>
                        <td>{{ $rule->aliquot }}</td>
                        <td>R$ {{ $rule->amount }}</td>
                        <td class="d-md-flex flex-row justify-content-center">

                            <a href="{{ route('rules.edit', ['rule' => $rule->id]) }}"
                                class="btn btn-default border border-secondary btn-sm me-1 mb-1 mb-md-0">
                                <i class="fa-regular fa-pen-to-square"></i></a>

                            <form action="{{ route('rules.destroy', ['rule' => $rule->id]) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm me-1"
                                    onclick="return confirm('Tem certeza que deseja apagar este Regra?')"><i
                                        class="fa-regular fa-trash-can"></i></button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <div class="alert alert-danger" role="alert">
                        Nenhum regra encontrada!
                    </div>
                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection