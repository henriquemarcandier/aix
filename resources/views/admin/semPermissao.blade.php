@extends('admin.master.layout')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Sem Permissão</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{env('APP_URL')}}admin">Home</a></li>
                            <li class="breadcrumb-item">Sem Permissão</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
<div class="d-flex align-items-center p-3 my-3 text-white-50 bg-danger rounded shadow-sm">
    <img class="mr-3" src="{{env('APP_URL')}}img/logo.png" alt="" width="48">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100">Sistema de Domínios da BH Commerce - Sem permissão para visualizar esse módulo!</h6>
        <small>Desde {{date('Y')}}</small>
    </div>
</div>
    </div>
@endsection
