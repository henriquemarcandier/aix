@extends('admin.master.layout')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h1>Versão do Sistema</h1>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalCadastro" onclick=addVersao()>Criar Novo</button>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{env('APP_URL')}}admin">Home</a></li>
                            <li class="breadcrumb-item">Cadastros</li>
                            <li class="breadcrumb-item active"><a href="{{env('APP_URL')}}versao">Versão do Sistema</a></li>
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
            <label for="nomeFiltro">Por Nome: </label>
            <input type="text" class="form-control" id="nomeFiltro" name="nomeFiltro">
        </div>
        <button type="button" class="btn btn-primary" onclick='verificaNovamente("versao", "{{env('APP_URL')}}","{{$_SESSION['user']['id']}}")'>Filtrar</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Versão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" id="fecharCadastro">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cadastroVersao">
                <div class="modal-body">
                    <input type="hidden" name="urlCadastro" id="urlCadastro" value="{{env('APP_URL')}}">
                    <input type="hidden" name="idUserCadastro" id="idUserCadastro" value="{{$_SESSION['user']['id']}}">
                    <label for="nomeCadastro">Nome: </label>
                    <input type="text" name="nomeCadastro" id="nomeCadastro" value="" required class="form-control">
                    <label for="descricaoCadastro">Descrição: </label>
                    <textarea name="descricaoCadastro" id="descricaoCadastro" required class="form-control"></textarea>
                    <label for="dataCadastro">Data: </label>
                    <input type="date" name="dataCadastro" id="statusCadastro" required class="form-control">
                    <label for="imagemCadastro">Imagem: </label>
                    <input type="file" name="imagemCadastro" id="imagemCadastro" class="form-control">
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
                <h5 class="modal-title" id="exampleModalLabel">Edição de Versão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edicaoVersao">
                <div class="modal-body">
                    <input type="hidden" name="urlEdicao" id="urlEdicao" value="{{env('APP_URL')}}">
                    <input type="hidden" name="idEdicao" id="idEdicao" value="Aguarde... Carregando...">
                    <input type="hidden" name="idUserEdicao" id="idUserEdicao" value="Aguarde... Carregando...">
                    <label for="nomeEdicao">Nome: </label>
                    <input type="text" name="nomeEdicao" id="nomeEdicao" value="Aguarde... Carregando..." required class="form-control">
                    <label for="descricaoEdicao">Descrição: </label>
                    <textarea name="descricaoEdicao" id="descricaoEdicao" required class="form-control">Aguarde... Carregando...</textarea>
                    <label for="dataEdicao">Data: </label>
                    <input type="date" name="dataEdicao" id="dataEdicao" required class="form-control">
                    <label for="imagemEdicao">Imagem: </label>
                    <input type="file" name="imagemEdicao" id="imagemEdicao" class="form-control">
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
                <h5 class="modal-title" id="exampleModalLabel">Visualização de Versão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="visualizacaoVersao">
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
    window.setInterval('verificaNovamente("versao", "{{env('APP_URL')}}", "{{$_SESSION['user']['id']}}")', 60000); window.setTimeout('verificaNovamente("versao", "{{env('APP_URL')}}", "{{$_SESSION['user']['id']}}")', 2000);
</script>
@endsection
