@extends('admin.master.layout')@section('content')    <div class="content-wrapper">        <section class="content-header">            <div class="container-fluid">                <div class="row mb-2">                    <div class="col-sm-4">                        <h1>Alunos</h1>                    </div>                    <div class="col-sm-4">                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalCadastro" onclick=addAlunos()>Criar Novo</button>                        <button class="btn btn-warning" data-toggle="modal" data-target="#modalImporta" onclick=importaAlunos()>Importar</button>                    </div>                    <div class="col-sm-4">                        <ol class="breadcrumb float-sm-right">                            <li class="breadcrumb-item"><a href="{{env('APP_URL')}}admin">Home</a></li>                            <li class="breadcrumb-item">Cadastros</li>                            <li class="breadcrumb-item active"><a href="{{env('APP_URL')}}alunos">Alunos</a></li>                        </ol>                    </div>                </div>            </div><!-- /.container-fluid -->        </section><div class="my-3 p-3 bg-white rounded shadow-sm">    <div class="media text-muted pt-3">        <h6 style="cursor: pointer" onclick="abreFecha('filtro')">Filtro</h6>    </div>    <div class="media text-muted pt-3" id="filtro" style="display:none">        <div style="width:100%">            <label for=idFiltro">Por Matrícula: </label>            <input type="text" class="form-control" id="idFiltro" name="idFiltro">            <label for="nomeFiltro">Por Nome: </label>            <input type="text" class="form-control" id="nomeFiltro" name="nomeFiltro">            <label for="nomeFiltro">Por Curso: </label>            <select class="form-control" id="cursoFiltro" name="cursoFiltro">                <option value="">Selecione a curso abaixo...</option>                @foreach ($courses as $kkey => $value)                    <option value="{{$value->id}}">{{$value->name}}</option>                @endforeach            </select>            <label for="nomeFiltro">Por Turma: </label>            <select class="form-control" id="turmaFiltro" name="turmaFiltro">                <option value="">Selecione a turma abaixo...</option>                <option value="M">Manhã</option>                <option value="T">Tarde</option>                <option value="N">Noite</option>            </select>        </div>        <button type="button" class="btn btn-primary" onclick='verificaNovamente("alunos", "{{env('APP_URL')}}","{{$_SESSION['user']['id']}}")'>Filtrar</button>    </div>    <div class="media text-muted pt-3" id="conteudo">        <img src="{{env('APP_URL')}}img/loader.gif" width="20"> Aguarde... Carregando...    </div>    <div id="contadorSite"></div></div>        <input type="hidden" name="pagina" id="pagina" value="1">        <div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="modalCadastro" aria-hidden="true">            <div class="modal-dialog" role="document">                <div class="modal-content">                    <div class="modal-header">                        <h5 class="modal-title" id="exampleModalLabel">Cadastro de Aluno</h5>                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" id="fecharCadastro">                            <span aria-hidden="true">&times;</span>                        </button>                    </div>                    <form id="cadastroAlunos">                        <div class="modal-body">                            <input type="hidden" name="urlCadastro" id="urlCadastro" value="{{env('APP_URL')}}">                            <input type="hidden" name="idUserCadastro" id="idUserCadastro" value="{{$_SESSION['user']['id']}}">                            <label for="nomeCadastro">Nome: </label>                            <input type="text" name="nomeCadastro" id="nomeCadastro" value="" required class="form-control">                            <label for="matriculaCadastro">Matrícula: </label>                            <input type="text" name="matriculaCadastro" required id="matriculaCadastro" class="form-control" value="">                            <label for="situacaoCadastro">Situação: </label>                            <select name="situacaoCadastro" id="situacaoCadastro" class="form-control">                                <option value="0">Inativo</option>                                <option value="1">Ativo</option>                            </select>                            <label for="cepCadastro" style="float:left">CEP: </label>                            <input type="text" name="cepCadastro" required id="cepCadastro" onkeypress='mascara(this,"00000-000",event)' maxlength="9" onkeyup="verificaCepCadastroAluno(this.value)" class="form-control" value="" style="float:left; width:60%"> <div style="float: Left; width:25%"><input type="button" class="btn btn-warning" onclick="validaCepCadastro($('#cepCadastro').val())" value="Verificar CEP"></div><br><br>                            <label for="logradouroCadastro">Logradouro: </label>                            <input type="text" name="logradouroCadastro" id="logradouroCadastro" value="" required class="form-control">                            <label for="numeroCadastro">Número: </label>                            <input type="text" name="numeroCadastro" id="numeroCadastro" value="" required class="form-control">                            <label for="complementoCadastro">Complemento: </label>                            <input type="text" name="complementoCadastro" id="complementoCadastro" value="" class="form-control">                            <label for="bairroCadastro">Bairro: </label>                            <input type="text" name="bairroCadastro" id="bairroCadastro" value="" required class="form-control">                            <label for="cidadeCadastro">Cidade: </label>                            <input type="text" name="cidadeCadastro" id="cidadeCadastro" value="" required class="form-control">                            <label for="estadoCadastro">Estado: </label>                            <select name="estadoCadastro" id="estadoCadastro" required class="form-control">                                <option value="">Selecione o estado abaixo corretamente...</option>                                @foreach ($states as $key => $value)                                    <option value="{{$value->sigla}}">{{$value->sigla}}</option>                                @endforeach                            </select>                            <label for="cursosCadastro">Curso: </label>                            <select name="cursoCadastro" id="cursoCadastro" required class="form-control">                                <option value="">Selecione o curso abaixo corretamente...</option>                                @foreach ($courses as $key => $value)                                    <option value="{{$value->id}}">{{$value->name}}</option>                                @endforeach                            </select>                            <label for="turmaCadastro">Turma: </label>                            <select name="turmaCadastro" id="turmaCadastro" required class="form-control">                                <option value="">Selecione a turma abaixo corretamente...</option>                                <option value="M">Manhã</option>                                <option value="T">Tarde</option>                                <option value="N">Noite</option>                            </select>                            <label for="imagemCadastro">Imagem: </label>                            <input type="file" name="imagemCadastro" id="imagemCadastro" value="" class="form-control">                        </div>                        <div class="modal-footer">                            <button type="submit" class="btn btn-primary">Cadastrar</button>                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>                        </div>                    </form>                </div>            </div>        </div>        <div class="modal fade" id="modalEdicao" tabindex="-1" role="dialog" aria-labelledby="modalEdicao" aria-hidden="true">            <div class="modal-dialog" role="document">                <div class="modal-content">                    <div class="modal-header">                        <h5 class="modal-title" id="exampleModalLabel">Edição de Aluno</h5>                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">                            <span aria-hidden="true">&times;</span>                        </button>                    </div>                    <form id="edicaoAlunos">                        <div class="modal-body">                            <input type="hidden" name="urlEdicao" id="urlEdicao" value="{{env('APP_URL')}}">                            <input type="hidden" name="idEdicao" id="idEdicao" value="Aguarde... Carregando...">                            <input type="hidden" name="idUserEdicao" id="idUserEdicao" value="Aguarde... Carregando...">                            <label for="nomeEdicao">Nome: </label>                            <input type="text" name="nomeEdicao" id="nomeEdicao" value="Aguarde... Carregando..." required class="form-control">                            <label for="matriculaEdicao">Matrícula: </label>                            <input type="text" name="matriculaEdicao" required id="matriculaEdicao" class="form-control" value="">                            <label for="situacaoEdicao">Situação: </label>                            <select name="situacaoEdicao" id="situacaoEdicao" class="form-control">                                <option value="0">Inativo</option>                                <option value="1">Ativo</option>                            </select>                            <label for="cepEdicao" style="float:left">CEP: </label>                            <input type="text" name="cepEdicao" required id="cepEdicao" onkeypress='mascara(this,"00000-000",event)' maxlength="9" onkeyup="verificaCepEdicaoAluno(this.value)" class="form-control" value="" style="float:left; width:60%"> <div style="float: Left; width:25%"><input type="button" class="btn btn-warning" onclick="validaCepEdicao($('#cepEdicao').val())" value="Verificar CEP"></div><br><br>                            <label for="logradouroEdicao">Logradouro: </label>                            <input type="text" name="logradouroEdicao" id="logradouroEdicao" value="" required class="form-control">                            <label for="numeroEdicao">Número: </label>                            <input type="text" name="numeroEdicao" id="numeroEdicao" value="" required class="form-control">                            <label for="complementoEdicao">Complemento: </label>                            <input type="text" name="complementoEdicao" id="complementoEdicao" value="" class="form-control">                            <label for="bairroEdicao">Bairro: </label>                            <input type="text" name="bairroEdicao" id="bairroEdicao" value="" required class="form-control">                            <label for="cidadeEdicao">Cidade: </label>                            <input type="text" name="cidadeEdicao" id="cidadeEdicao" value="" required class="form-control">                            <label for="estadoEdicao">Estado: </label>                            <select name="estadoEdicao" id="estadoEdicao" required class="form-control">                                <option value="">Selecione o estado abaixo corretamente...</option>                                @foreach ($states as $key => $value)                                    <option value="{{$value->sigla}}">{{$value->sigla}}</option>                                @endforeach                            </select>                            <label for="cursosEdicao">Curso: </label>                            <select name="cursoEdicao" id="cursoEdicao" required class="form-control">                                <option value="">Selecione o curso abaixo corretamente...</option>                                @foreach ($courses as $key => $value)                                    <option value="{{$value->id}}">{{$value->name}}</option>                                @endforeach                            </select>                            <label for="turmaEdicao">Turma: </label>                            <select name="turmaEdicao" id="turmaEdicao" required class="form-control">                                <option value="">Selecione a turma abaixo corretamente...</option>                                <option value="M">Manhã</option>                                <option value="T">Tarde</option>                                <option value="N">Noite</option>                            </select>                            <label for="imagemEdicao">Imagem: </label>                            <input type="file" name="imagemEdicao" id="imagemEdicao" value="" class="form-control">                        </div>                        <div class="modal-footer">                            <button type="submit" class="btn btn-primary" id="botaoEditar" style="display:none">Editar</button>                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>                        </div>                    </form>                </div>            </div>        </div>        <div class="modal fade" id="modalVisualizacao" tabindex="-1" role="dialog" aria-labelledby="modalVisualizacao" aria-hidden="true">            <div class="modal-dialog" role="document">                <div class="modal-content">                    <div class="modal-header">                        <h5 class="modal-title" id="exampleModalLabel">Visualização de Aluno</h5>                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">                            <span aria-hidden="true">&times;</span>                        </button>                    </div>                    <div class="modal-body" id="visualizacaoAlunos">                        <img src="{{env('APP_URL')}}img/loader.gif" width="20"> Aguarde... Carregando...                    </div>                    <div class="modal-footer">                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>                    </div>                </div>            </div>        </div>        <div class="modal fade" id="modalImporta" tabindex="-1" role="dialog" aria-labelledby="modalImporta" aria-hidden="true">            <div class="modal-dialog" role="document">                <div class="modal-content">                    <div class="modal-header">                        <h5 class="modal-title" id="exampleModalLabel">Importação de Aluno</h5>                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">                            <span aria-hidden="true">&times;</span>                        </button>                    </div>                    <form id="importaAlunos">                        <div class="modal-body">                            <label for="numeroAlunos">Número de Alunos X Turmas:</label>                            <input type="number" id="numeroAlunos" name="numeroAlunos" required class="form-control">                        </div>                        <div class="modal-footer">                            <button type="submit" class="btn btn-primary">Importar</button>                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>                        </div>                    </form>                </div>            </div>        </div>    </div>    <script>        window.setInterval('verificaNovamente("alunos", "{{env('APP_URL')}}", "{{$_SESSION['user']['id']}}")', 60000); window.setTimeout('verificaNovamente("alunos", "{{env('APP_URL')}}", "{{$_SESSION['user']['id']}}")', 2000);    </script>@endsection