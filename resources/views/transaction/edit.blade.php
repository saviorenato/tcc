@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Transações</h2>
        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="text-decoration-none"
                    href="{{ route('transactions.index') }}">Transações</a>
            </li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-header hstack gap-2">
            <span>Editar</span>
            <span class="ms-auto d-sm-flex flex-row"></span>
        </div>
        <div class="card-body">

            <x-alert />

            <div class="row">
                <div class="col-md-12">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">

                        <div class="container mt-4">
                            <form action="{{ route('transactions.update', ['transaction' => $transaction->id]) }}"
                                method="POST" class="row g-3">
                                @csrf
                                @method('PUT')
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input btn-check" type="radio" name="type"
                                                id="tipo_compra" value="C" {{ $transaction->type == 'C' ? 'checked' : ''
                                            }}>
                                            <label class="btn btn-outline-primary" for="tipo_compra">Compra</label>

                                            <input class="form-check-input btn-check" type="radio" name="type"
                                                id="tipo_venda" value="V" {{ $transaction->type == 'V' ? 'checked' : ''
                                            }}>
                                            <label class="btn btn-outline-primary" for="tipo_venda">Venda</label>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="ticker" class="form-label">Ticker</label>
                                        <select class="form-select" id="ticker" name="ticker"
                                            aria-label="Default select example">
                                            <option selected>Selecione um Ticker</option>
                                            @forelse ($tickers as $ticker)
                                            <option {{ $transaction->ticker->ticker==$ticker ? 'selected' : '' }}
                                                value="{{ $ticker }}"> {{ $ticker }} </option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="container pt-5">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="date">Data</label>
                                            <input id="date" name="date" value="{{ old('date', $transaction->date) }}"
                                                class="form-control" type="date" required />
                                        </div>
                                        <div class="col mb-3">
                                            <label for="quantity" class="form-label">Quantidade</label>
                                            <div class="input-group has-validation">
                                                <input type="number" class="form-control" id="quantity" name="quantity"
                                                    value="{{ old('quantity', $transaction->quantity) }}"
                                                    aria-describedby="inputGroupPrepend" required>
                                                <div class="invalid-feedback">
                                                    Informe a quantidade.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col mb-3">
                                            <label for="amount" class="form-label">Preço</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text">R$</span>
                                                <input type="number" class="form-control" id="amount" name="amount"
                                                    value="{{ old('amount', $transaction->amount) }}"
                                                    aria-describedby="inputGroupPrepend" required>
                                                <div class="invalid-feedback">
                                                    Informe o preço.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="container pt-5 text-center">
                                        <div class="row align-items-center">
                                            <div class="col"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col mb-3 pt-5 text-end">
                                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection