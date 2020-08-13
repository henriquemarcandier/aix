<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema da AIX da BH Commerce</title>
    <link rel="icon" href="{{env('APP_URL')}}img/favicon.ico">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{env('APP_URL')}}plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{env('APP_URL')}}plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{env('APP_URL')}}plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{env('APP_URL')}}plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{env('APP_URL')}}dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{env('APP_URL')}}plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{env('APP_URL')}}plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{env('APP_URL')}}plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div id="importacaoRealizadaComSucesso" style="position:fixed; z-index:9999999; width:100%; text-align:center; background-color:#000033; color: #FFFFFF; padding:15px; border:1px solid #FFFFFF; z-indez:9999999; display:none"><div style="position:absolute; float:left; left:95%"><a onclick="$('#importacaoRealizadaComSucesso').hide('fast')" style="cursor: pointer">&times;</a></div>Importação Reallizada com sucesso</div>
<div id="registroInseridoComSucesso" style="position:fixed; z-index:9999999; width:100%; text-align:center; background-color:#000033; color: #FFFFFF; padding:15px; border:1px solid #FFFFFF; z-indez:9999999; display:none"><div style="position:absolute; float:left; left:95%"><a onclick="$('#registroInseridoComSucesso').hide('fast')" style="cursor: pointer">&times;</a></div>Registro Inserido com sucesso</div>
<div id="registroAtualizadoComSucesso" style="position:fixed; z-index:9999999; width:100%; text-align:center; background-color:#003300; color: #FFFFFF; padding:15px; border:1px solid #FFFFFF; z-indez:9999999; display:none"><div style="position:absolute; float:left; left:95%"><a onclick="$('#registroAtualizadoComSucesso').hide('fast')" style="cursor: pointer">&times;</a></div>Registro Atualizado com sucesso</div>
<div id="registroImportadoComSucesso" style="position:fixed; z-index:9999999; width:100%; text-align:center; background-color:#0b2e13; color: #FFFFFF; padding:15px; border:1px solid #FFFFFF; z-indez:9999999; display:none"><div style="position:absolute; float:left; left:95%"><a onclick="$('#registroImporadoComSucesso').hide('fast')" style="cursor: pointer">&times;</a></div>Registro Importado com sucesso</div>
<div id="registroExcluidoComSucesso" style="position:fixed; z-index:9999999; width:100%; text-align:center; background-color:#FF0000; color: #FFFFFF; padding:15px; border:1px solid #FFFFFF; z-indez:9999999; display:none"><div style="position:absolute; float:left; left:95%"><a onclick="$('#registroExcluidoComSucesso').hide('fast')" style="cursor: pointer">&times;</a></div>Registro Excluído com sucesso</div>
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{env('APP_URL')}}admin" class="nav-link">Home</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{env('APP_URL')}}admin" class="brand-link">
            <img src="{{env('APP_URL')}}img/logo.png" alt="BH Commerce" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light" style="font-size:16px">Sistema da AIX<br>da BH Commerce</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image" id="imgUser">
                    @if ($user->img)
                        <img src="{{env('APP_URL')}}storage/{{$user->img}}" onclick="abreFecha('saiUsuarios')" style="cursor:pointer" class="img-circle elevation-2" alt="User Image">
                    @else
                        <img src="{{env('APP_URL')}}storage/user-avatar.svg" onclick="abreFecha('saiUsuarios')" style="cursor:pointer" class="img-circle elevation-2" alt="User Image">
                    @endif
                </div>
                <div class="info">
                    <a onclick="abreFecha('saiUsuarios')" style="cursor:pointer" class="d-block">{{utf8_decode($user->name)}}</a>
                </div>
                <div class="info" id="saiUsuarios" style="display:none; position:absolute; background-color: #343A40;color:#FFFFFF; width:100%"><div style="position:absolute; float:left; left:90%"><a onclick="$('#saiUsuarios').hide('fast')" style="cursor:pointer">&times;</a></div><a href="{{env('APP_URL')}}usuarios">Ver Usuários</a><br><a onclick="if (confirm('Tem certeza que deseja sair do sistema?')){ location.href='{{env('APP_URL')}}logout'; }" style="cursor:pointer">Sair do Sistema</a></div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    @foreach ($typesModules as $key => $value)
                        @if ($key == 0)
                            <li class="nav-item has-treeview menu-open">
                                <a href="{{env('APP_URL')}}" class="nav-link @if ($param == '') active @endif ">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Home
                                    </p>
                                </a>
                            </li>
                        @else
                    <li class="nav-item has-treeview @if (($key == 1 && ($param == 'alunos' || $param == 'cursos' || $param == 'versao' || $param == 'alunosCurso')) || ($key == 2 && ($param == 'usuarios' || $param == 'tiposModulo' || $param == 'modulos' || $param == 'permissao' || $param == 'logsAcesso' || $param == 'usuarios-pre'))) menu-open @endif ">
                        <a href="#" class="nav-link @if (($key == 1 && ($param == 'alunos' || $param == 'cursos' || $param == 'versao' || $param == 'alunosCurso')) || ($key == 2 && ($param == 'usuarios' || $param == 'tiposModulo' || $param == 'modulos' || $param == 'permissao' || $param == 'logsAcesso' || $param == 'usuarios-pre'))) active @endif ">
                            <i class="nav-icon fas @if ($key == 1) fa-book @elseif ($key == 2) fa-user @endif "></i>
                            <p>
                                {{$value->name}}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                                        @foreach ($modules as $chave => $valor)
                                            @if ($value->id == $valor->typeModule)
                                                @if ($permission[$chave] && $permission[$chave]->view)
                                    <li class="nav-item">
                                <a href="{{env('APP_URL')}}{{$valor->slug}}" class="nav-link @if ($valor->slug == $param) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{$valor->name}}</p>
                                </a>
                                    </li>
                                                @endif
                                            @endif
                                        @endforeach
                        </ul>
                    </li>
                        @endif
                    @endforeach
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    @yield('content')
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>&copy; {{$versions[count($versions) - 1]->ano}}-{{date('Y')}} <a href="https://www.bhcommerce.com.br" target="_blank">BH Commerce</a>.</strong>
        Todos os direitos reservados.
        <div class="float-right d-none d-sm-inline-block">
            <b>Versão</b> <a href="#" data-toggle="modal" data-target="#modalVersoes" style="background-color: #E5F1FB; color: #000000; padding7px; text-decoration:none"><img src="{{env('APP_URL')}}storage/{{$versions[count($versions) - 1]->img}}" width="35"></a>
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<div class="modal fade" id="modalVersoes" tabindex="-1" role="dialog" aria-labelledby="modalVersoes" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Versões do Sistema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="visualizacaoVersoes">
                <h5 class="modal-title">Versão Atual</h5>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width:200px"><img src="{{env('APP_URL')}}storage/{{$versaoQual->img}}" width="200"></td>
                        <td style="vertical-align: top">
                            <h5 class="modal-title">Versão {{$versaoQual->name}} - {{$versaoQual->date}}</h5>
                            <p>{{$versaoQual->description}}</p>
                        </td>
                    </tr>
                </table>
                @if (count($versions) >= 2)
                    <h5 class="modal-title">Outras Versões</h5>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        @foreach ($versions as $key => $value)
                            @if ($versaoQual->id != $value->id)
                                <tr>
                                    <td style="width:50px" valign="top"><img src="{{env('APP_URL')}}storage/{{$value->img}}" width="50"></td>
                                    <td style="vertical-align: top"><h5 class="modal-title">Versão {{$value->name}} - {{$value->date}}</h5><p>{{$value->description}}</p></td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{env('APP_URL')}}plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{env('APP_URL')}}plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{env('APP_URL')}}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{env('APP_URL')}}plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{env('APP_URL')}}plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{env('APP_URL')}}plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{env('APP_URL')}}plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{env('APP_URL')}}plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{env('APP_URL')}}plugins/moment/moment.min.js"></script>
<script src="{{env('APP_URL')}}plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{env('APP_URL')}}plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{env('APP_URL')}}plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{env('APP_URL')}}plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{env('APP_URL')}}dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{env('APP_URL')}}dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{env('APP_URL')}}dist/js/demo.js"></script>
<script src="{{env('APP_URL')}}img/scripts.js"></script>
</body>
</html>