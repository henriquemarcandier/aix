<?php
require_once('connect.php');
$sql = "SELECT * FROM users WHERE remember_token = '".$_REQUEST['codigo']."'";
$query = mysqli_query($con, $sql);
if (mysqli_num_rows($query)){
    $row = mysqli_fetch_array($query);
    ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema de Domínios da BH Commerce - Alterar Senha</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="mask-icon" href="<?php echo URL?>img/favicon.ico" color="#563d7c">
    <link rel="icon" href="<?php echo URL?>img/favicon.ico">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo URL?>plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo URL?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo URL?>dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="<?php echo URL?>admin"><b>Sistema de Domínios da </b>BH Commerce<br>
            <img class="mb-4" src="<?php echo URL?>img/logo.png" alt="" width="72"></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Alterar Senha<br><br> Olá <b><?php echo $row['name']?></b></p>

            <form method="post" id="formAlterarSenha" name="formAlterarSenha">
                <div class="alert alert-danger d-none messageBox" role="alert">
                </div>
                <div class="alert alert-success d-none messageBoxSuccess" role="alert">
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Nova Senha" name="password" id="senhaLogin" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Redigite a Nova Senha" name="password2" id="senhaLogin2" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Alterar</button>
                    </div>
                    <!-- /.col -->
                </div>
                <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $row['id']?>">
                <input type="hidden" id="urlAlterarSenha" name="urlAlterarSenha" value="<?php echo URL?>">
            </form>
            <!-- /.social-auth-links -->

            <p class="mb-1">
                <a href="<?php echo URL?>login">Login</a>
            </p>
            <p class="mb-1">
                <a href="<?php echo URL?>esqueceu-sua-senha">Esqueci minha senha</a>
            </p>
            <p class="mb-0">
                <a href="<?php echo URL?>cadastro" class="text-center">Cadastro</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo URL?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo URL?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo URL?>dist/js/adminlte.min.js"></script>
<script src="<?php echo URL?>img/scripts.js"></script>

</body>
</html><?php
}
else{
    ?><script>alert('Nenhum usuário encontrado!'); window.close();</script><?php
}
?>
