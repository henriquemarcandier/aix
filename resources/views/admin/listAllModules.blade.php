@extends('admin.master.layout')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h1>Módulos</h1>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalCadastro" onclick=addModulo()>Criar Novo</button>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{env('APP_URL')}}admin">Home</a></li>
                            <li class="breadcrumb-item">Usuários</li>
                            <li class="breadcrumb-item active"><a href="{{env('APP_URL')}}modulos">Módulos</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
<div class="my-3 p-3 bg-white rounded shadow-sm">
    <div class="media text-muted pt-3">
        <h6 style="cursor: pointer" onclick="abreFecha('filtro')">Filtro</h6>
    </div>
    <div class="media text-muted pt-3" id="filtro" style="display:none">
        <div style="width:100%">
            <label for="tipoModuloFiltro">Por Tipo de Módulo: </label>
            <select class="form-control" id="tipoModuloFiltro" name="tipoModuloFiltro">
                <option value="">Selecione o tipo de módulo abaixo</option>
                @foreach ($typeModules as $key => $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
            </select>
            <label for="nomeFiltro">Por Nome: </label>
            <input type="text" class="form-control" id="nomeFiltro" name="nomeFiltro">
        </div>
        <button type="button" class="btn btn-primary" onclick='verificaNovamente("modulo", "{{env('APP_URL')}}","{{$_SESSION['user']['id']}}")'>Filtrar</button>
    </div>
    <input type="hidden" name="tipo" id="tipo" value="categorias">
    <input type="hidden" name="pagina" id="pagina" value="1">

    <div class="media text-muted pt-3" id="conteudo">
        <img src="{{env('APP_URL')}}img/loader.gif" width="20"> Aguarde... Carregando...
    </div>
    <div id="contadorSite"></div>
</div>
<div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="modalCadastro" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Módulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" id="fecharCadastro">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cadastroModulo">
                <div class="modal-body">
                    <input type="hidden" name="urlCadastro" id="urlCadastro" value="{{env('APP_URL')}}">
                    <input type="hidden" name="idUserCadastro" id="idUserCadastro" value="{{$_SESSION['user']['id']}}">
                    <label for="tipoModuloCadastro">Tipo de Módulo: </label>
                    <select name="tipoModuloCadastro" id="tipoModuloCadastro" required class="form-control">
                        <option value="">Selecione o tipo de módulo abaixo</option>
                        @foreach ($typeModules as $key => $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                    <label for="nomeCadastro">Nome: </label>
                    <input type="text" name="nomeCadastro" id="nomeCadastro" value="" required class="form-control">
                    <label for="urlAmigavelCadastro">URL Amigável: </label>
                    <input type="text" name="urlAmigavelCadastro" id="urlAmigavelCadastro" value="" required class="form-control">
                    <label for="statusCadastro">Status: </label>
                    <select name="statusCadastro" id="statusCadastro" class="form-control">
                        <option value="0">Inativo</option>
                        <option value="1">Ativo</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEdicao" tabindex="-1" role="dialog" aria-labelledby="modalEdicao" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edição de Módulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edicaoModulo">
                <div class="modal-body">
                    <input type="hidden" name="urlEdicao" id="urlEdicao" value="{{env('APP_URL')}}">
                    <input type="hidden" name="idEdicao" id="idEdicao" value="Aguarde... Carregando...">
                    <input type="hidden" name="idUserEdicao" id="idUserEdicao" value="Aguarde... Carregando...">
                    <label for="tipoModuloEdicao">Tipo de Módulo: </label>
                    <select class="form-control" id="tipoModuloEdicao" name="tipoModuloEdicao">
                        <option value="">Selecione o tipo de módulo abaixo</option>
                        @foreach ($typeModules as $key => $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                    <label for="nomeEdicao">Nome: </label>
                    <input type="text" name="nomeEdicao" id="nomeEdicao" value="Aguarde... Carregando..." required class="form-control">
                    <label for="urlAmigavelEdicao">URL Amigável: </label>
                    <input type="text" name="urlAmigavelEdicao" id="urlAmigavelEdicao" value="Aguarde... Carregando..." required class="form-control">
                    <label for="statusEdicao">Status: </label>
                    <select name="statusEdicao" id="statusEdicao" class="form-control">
                        <option value="0">Inativo</option>
                        <option value="1">Ativo</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="botaoEditar" style="display:none">Editar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalVisualizacao" tabindex="-1" role="dialog" aria-labelledby="modalVisualizacao" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Visualização de Módulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="visualizacaoModulo">
                <img src="{{env('APP_URL')}}img/loader.gif" width="20"> Aguarde... Carregando...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    window.setInterval('verificaNovamente("modulo", "{{env('APP_URL')}}", "{{$_SESSION['user']['id']}}")', 60000); window.setTimeout('verificaNovamente("modulo", "{{env('APP_URL')}}", "{{$_SESSION['user']['id']}}")', 2000);
</script>
@endsection
