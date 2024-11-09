@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Impostos</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Impostos</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-header hstack gap-2">
            <span></span>
            <span class="ms-auto"></span>
        </div>

        <div class="card-body">

            <x-alert />

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
@endsection
