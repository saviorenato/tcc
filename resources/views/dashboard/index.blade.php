@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Dashboard</h2>
    </div>

    <div class="card mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span class="ms-auto d-sm-flex flex-row"></span>
        </div>

        <div class="card-body">

            <x-alert />

            <div class="row">
                <div class="col">
                    <div class="card bg-default text-black mb-4">
                        <h2 class="mt-3 text-center">{{ $indicators['taxesNotPaid'] }}</h2>
                        <div class="card-footer mt-1 text-center">
                            <p class="small text-black stretched-link">Impostos não pagos</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-default text-black mb-4">
                        <h2 class="mt-3 text-center">{{ $indicators['totalTransactions'] }}</h2>
                        <div class="card-footer mt-1 text-center">
                            <p class="small text-black stretched-link">Total Transações no Mês</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-default text-black mb-4">
                        <h2 class="mt-3 text-center">{{ $indicators['totalSale'] }}</h2>
                        <div class="card-footer mt-1 text-center">
                            <p class="small text-black stretched-link">Total de Vendas no Mês</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="container-fluid px-4">
            <div class="mb-1 hstack gap-2">
                <h2 class="mt-3">Ultimas Transações</h2>
            </div>
            <div class="card mb-4 border-light shadow">
                <div class="card-body">
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
                                </td>
                                <td class="d-md-flex flex-row justify-content-center">

                                    @can('edit-classe')
                                    <a href="{{ route('transactions.edit', ['transaction' => $transaction->id]) }}"
                                        class="btn btn-default border border-secondary btn-sm me-1 mb-1">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    @endcan

                                    @can('destroy-classe')
                                    <form
                                        action="{{ route('transactions.destroy', ['transaction' => $transaction->id]) }}"
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
                </div>
            </div>
        </div>

        <div class="container-fluid px-4">
            <div class="mb-1 hstack gap-2">
                <h2 class="mt-3">Ultimos Impostos</h2>
            </div>

            <div class="card mb-4 border-light shadow">
                <div class="card-body">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="d-none d-sm-table-cell">ID</th>
                                <th>Mês / Ano</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($taxes as $tax)
                            <tr>
                                <td class="d-none d-sm-table-cell">{{ $loop->index + 1 }}</td>
                                <td>{{ $tax->mounth }} / {{ $tax->year }}</td>
                                <td>{{ $tax->amount }}</td>
                                <td>
                                    @if ($tax->paid)
                                    <span class="badge bg-success">Pago</span>
                                    @else
                                    <span class="badge bg-warning">Pendente</span>
                                    @endif
                                </td>
                                </td>
                                <td class="d-md-flex flex-row justify-content-center">
                                    @if (!$tax->paid)
                                    <form action="{{ route('taxes.update', ['tax' => $tax->id, 'paid' => true]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm me-1"
                                            onclick="return confirm('Confirma o pagamento do Imposto?')">
                                            <i class="fa-solid fa-dollar-sign"></i>
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('taxes.update', ['tax' => $tax->id, 'paid' => false]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-sm me-1"
                                            onclick="return confirm('Confirma o cancelamento do pagamento do Imposto?')">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <div class="alert alert-danger" role="alert">
                                Nenhum imposto encontrado!
                            </div>
                            @endforelse

                        </tbody>
                    </table>

                </div>

            </div>
        </div>

    </div>
</div>
@endsection