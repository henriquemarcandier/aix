@extends('admin.master.layout')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Permissão</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{env('APP_URL')}}admin">Home</a></li>
                            <li class="breadcrumb-item">Usuários</li>
                            <li class="breadcrumb-item active"><a href="{{env('APP_URL')}}permissao">Permissão</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
<div class="my-3 p-3 bg-white rounded shadow-sm">
    <div class="media text-muted pt-3">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <th style="padding:5px">Usuário</th>
            </tr>
            @foreach ($users as $key => $user)
                <tr style="background-color:{{ ($key % 2 == 0) ? "#E7E7E7" : "" }}; cursor: pointer" onclick="mostraPermissaoUsuario('{{$user->id}}', '{{env("APP_URL")}}', '{{$_SESSION['user']['id']}}')">
                    <td style="padding:5px">{{utf8_decode($user->name)}}</td>
                </tr>
                <tr id="permissaoUsuario{{$user->id}}" style="display: none">
                    <td><img src="{{env('APP_URL')}}img/loader.gif" width="20"> Aguarde... Carregando...</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
</div>
@endsection
