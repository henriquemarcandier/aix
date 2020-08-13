@extends('admin.master.layout')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h1>Logs de Acesso</h1>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-primary" onclick="exportarLogs('{{env('APP_URL')}}', '{{$_SESSION['user']['id']}}')">Exportar Logs</button>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{env('APP_URL')}}admin">Home</a></li>
                            <li class="breadcrumb-item">Usuário</li>
                            <li class="breadcrumb-item active"><a href="{{env('APP_URL')}}logsAcesso">Logs de Acesso</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="cursor: pointer" onclick="abreFecha('filtro')">Filtro</h2>
            </div>
            <div class="media text-muted pt-3" id="filtro" style="display:none">
                <div style="width:100%">
                    <label for="usuarioFiltro">Por Usuário: </label>
                    <input class="form-control" id="usuarioFiltro" name="usuarioFiltro" type="text">
                </div><br><br>
                <div style="width:100%">
                    <label for="acaoFiltro">Por Ação: </label>
                    <input type="text" class="form-control" id="acaoFiltro" name="acaoFiltro">
                </div>
                <button type="button" class="btn btn-primary" onclick='verificaNovamente("newsletter", "{{env('APP_URL')}}", "{{$_SESSION['user']['id']}}")'>Filtrar</button>
            </div>
        </div>
        <input type="hidden" value="1" name="pagina" id="pagina">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body" id="conteudo">
                            <img src="{{env('APP_URL')}}img/loader.gif" width="20"> Aguarde... Carregando...
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
    </div>
    </div>
    <div class="modal fade" id="modalEdicao" tabindex="-1" role="dialog" aria-labelledby="modalEdicao" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edição de Newsletter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edicaoNewsletter">
                    <div class="modal-body">
                        <input type="hidden" name="urlEdicao" id="urlEdicao" value="{{env('APP_URL')}}">
                        <input type="hidden" name="idEdicao" id="idEdicao" value="Aguarde... Carregando...">
                        <input type="hidden" name="idUserEdicao" id="idUserEdicao" value="Aguarde... Carregando...">
                        <label for="nomeEdicao">Nome: </label>
                        <input type="text" name="nomeEdicao" id="nomeEdicao" value="Aguarde... Carregando..." required class="form-control">
                        <label for="emailEdicao">Email: </label>
                        <input type="email" name="emailEdicao" id="emailEdicao" value="Aguarde... Carregando..." required class="form-control">
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
                    <h5 class="modal-title" id="exampleModalLabel">Visualização de Newsletter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="visualizacaoNewsletter">
                    <img src="{{env('APP_URL')}}img/loader.gif" width="20"> Aguarde... Carregando...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.setInterval('verificaNovamente("logs", "{{env('APP_URL')}}", "{{$_SESSION['user']['id']}}")', 60000); window.setTimeout('verificaNovamente("logs", "{{env('APP_URL')}}", "{{$_SESSION['user']['id']}}")', 2000);
    </script>
@endsection