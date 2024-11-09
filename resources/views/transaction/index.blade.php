@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Transações</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Transações</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-header hstack gap-2">
            <span class="ms-auto">
                @can('create-transaction')
                <a class="btn btn-primary" href="{{ route('transactions.create') }}" role="button">
                    <i class="fa-regular fa-square-plus"></i> Novo
                </a>
                @endcan
                <a class="btn btn-primary" href="#" role="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fa-solid fa-upload"></i> Upload
                </a>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell">ID</th>
                        <th>Tipo</th>
                        <th>Categoria</th>
                        <th>Ticker</th>
                        <th>Data</th>
                        <th>Qtd</th>
                        <th>Valor</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($transactions as $transaction)
                    <tr>
                        <td class="d-none d-sm-table-cell">{{ $loop->index + 1 }}</td>
                        <td>{{ $transaction->type }}</td>
                        <td>{{ $transaction->ticker->category }}</td>
                        <td>{{ $transaction->ticker->ticker }}</td>
                        <td>{{ $transaction->date }}</td>
                        <td>{{ $transaction->quantity }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td class="d-md-flex flex-row justify-content-center">

                            @can('edit-classe')
                            <a href="{{ route('transactions.edit', ['transaction' => $transaction->id]) }}"
                                class="btn btn-default border border-secondary btn-sm me-1 mb-1">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            @endcan

                            @can('destroy-classe')
                            <form action="{{ route('transactions.destroy', ['transaction' => $transaction->id]) }}"
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
                        Nenhuma transação encontrada!
                    </div>
                    @endforelse

                </tbody>
            </table>


            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('transactions.importExcel') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Importar Transações</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h2 class="fs-5">Selecione o Arquivo .xls ou .xlsx</h2>
                                <br>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="file" name="file"
                                        aria-describedby="file" aria-label="Upload">
                                </div>
                                <hr>
                                <p>
                                    Caso tenha duvida do modelo de importação segue o
                                    <a href="{{ route('transactions.downloadExcel') }}" data-bs-toggle="tooltip"
                                        title="Tooltip">link</a>
                                    para que possa realizar a importação.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>





@endsection
