@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Regras</h2>
        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('rules.index') }}">Regras</a>
            </li>
            <li class="breadcrumb-item active">Cadastrar</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-body">

            <x-alert />

            <div class="row">
                <div class="col-md-12">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                        <div class="container mt-4">
                            <form action="{{ route('rules.store') }}" method="POST" class="row g-3">
                                @csrf
                                @method('POST')

                                <div class="container pt-5">
                                    <div class="row">

                                        <div class="col mb-3">
                                            <label for="name" class="form-label">Nome</label>
                                            <div class="input-group has-validation">
                                                <input type="text" class="form-control" id="name" name="name" value=""
                                                    aria-describedby="inputGroupPrepend" placeholder="Informe o Nome..."
                                                    required>
                                                <div class="invalid-feedback">
                                                    Informe o Nome.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col mb-3">
                                            <label for="aliquot" class="form-label">Aliquota</label>
                                            <div class="input-group has-validation">
                                                <input type="number" class="form-control" name="aliquot" id="aliquot"
                                                    value="" aria-describedby="inputGroupPrepend"
                                                    placeholder="Informe a Aliquota..." required>
                                                <div class="invalid-feedback">
                                                    Informe a Aliquota.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col mb-3">
                                            <label for="amount" class="form-label">Valor</label>
                                            <div class="input-group has-validation">
                                                <input type="number" class="form-control" name="amount" id="amount"
                                                    value="" aria-describedby="inputGroupPrepend"
                                                    placeholder="Informe o Valor..." required>
                                                <div class="invalid-feedback">
                                                    Informe o Valor.
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
