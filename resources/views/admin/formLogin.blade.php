<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema da AIX da BH Commerce - Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="mask-icon" href="{{env('APP_URL')}}img/favicon.ico" color="#563d7c">
    <link rel="icon" href="{{env('APP_URL')}}img/favicon.ico">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{env('APP_URL')}}plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{env('APP_URL')}}plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{env('APP_URL')}}dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{env('APP_URL')}}admin"><b>Sistema da AIX da </b>BH Commerce<br>
        <img class="mb-4" src="{{env('APP_URL')}}img/logo.png" alt="AIX Sistemas" width="80%"></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Logue se abaixo:</p>

            <form method="post" id="formLogin" name="formLogin">
                <div class="alert alert-danger d-none messageBox" role="alert">
                </div>
                <div class="alert alert-success d-none messageBoxSuccess" role="alert">
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Seu Email" name="email" id="emailLogin" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Sua Senha" name="password" id="senhaLogin" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <!-- /.col -->
                </div>
                <input type="hidden" id="urlLogin" name="urlLogin" value="{{env('APP_URL')}}">
                @if (isset($_REQUEST['page']))
                <input type="hidden" id="urlVolta" name="urlVolta" value="{{$_REQUEST['page'] ? $_REQUEST['page'] : ""}}">
                @endif
            </form>
            <!-- /.social-auth-links -->

            <p class="mb-1">
                <a href="{{env('APP_URL')}}esqueceu-sua-senha">Esqueci minha senha</a>
            </p>
            <p class="mb-0">
                <a href="{{env('APP_URL')}}cadastro" class="text-center">Cadastro</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{env('APP_URL')}}plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{env('APP_URL')}}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{env('APP_URL')}}dist/js/adminlte.min.js"></script>

<script src="{{env('APP_URL')}}img/scripts.js"></script>
</body>
</html>