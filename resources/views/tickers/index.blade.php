@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Tickers</h2>
        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Tickers</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-header hstack gap-2">
            <span></span>
            <span class="ms-auto">
                @can('create-transaction')
                <a class="btn btn-primary" href="{{ route('tickers.create') }}" role="button">
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
                        <th>Categoria</th>
                        <th>Ticker</th>
                        <th>Nome</th>
                        <th>CNPJ</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($acoes as $acao)
                    <tr>
                        <td class="d-none d-sm-table-cell">{{ $loop->index + 1 }}</td>
                        <td>{{ $acao->category }}</td>
                        <td>{{ $acao->ticker }}</td>
                        <td>{{ $acao->name }}</td>
                        <td>{{ $acao->cnpj }}</td>
                        </td>
                        <td class="d-md-flex flex-row justify-content-center">


                            <a href="{{ route('tickers.edit', ['ticker' => $acao->id]) }}"
                                class="btn btn-default border border-secondary btn-sm me-1 mb-1">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>

                            <form action="{{ route('tickers.destroy', ['ticker' => $acao->id]) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm me-1"
                                    onclick="return confirm('Tem certeza que deseja apagar este Ticker?')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach

                    @forelse ($fiis as $fii)
                    <tr>
                        <td class="d-none d-sm-table-cell">{{ $loop->index + 1 }}</td>
                        <td>{{ $fii->category }}</td>
                        <td>{{ $fii->ticker }}</td>
                        <td>{{ $fii->name }}</td>
                        <td>{{ $fii->cnpj }}</td>
                        </td>
                        <td class="d-md-flex flex-row justify-content-center">


                            <a href="{{ route('tickers.edit', ['ticker' => $fii->id]) }}"
                                class="btn btn-default border border-secondary btn-sm me-1 mb-1">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>

                            <form action="{{ route('tickers.destroy', ['ticker' => $fii->id]) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm me-1"
                                    onclick="return confirm('Tem certeza que deseja apagar este Ticker?')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection