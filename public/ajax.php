<?php
ini_set('max_execution_time', '99999999999999s');
require_once('connect.php');
switch ($_GET['acao']) {
    case "importar":
            if (!preg_match('/.xml/', $_FILES['arquivoImporta']['name'])) {
                echo "0|-|Informe um arquivo do tipo '*.xml'.";
            }
            else {
                $arquivo = DIRETORIO."storage/cursos".date('YmdHis').".xml";
                copy($_FILES['arquivoImporta']['tmp_name'], $arquivo);
                $xml = simplexml_load_file(URL."storage/cursos".date('YmdHis').".xml");
                foreach($xml->curso as $item){
                    $sql = "SELECT * FROM courses WHERE name = '".($item->nome)."'";
                    $query = mysqli_query($con, $sql);
                    if (!mysqli_num_rows($query)){
                        $sql = "INSERT INTO courses (id, name, created_at, updated_at) VALUES ('".$item->codigo."', '".($item->nome)."', now(), now())";
                        mysqli_query($con, $sql);
                    }
                }
                unlink ($arquivo);
                echo "1";
            }
        break;
    case "formCadastro":
        $sql = "SELECT * FROM users WHERE email = '".$_REQUEST['email']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)) {
            echo "0|-|Já existe um usuáio cadastrado com esse email! Clique em 'Esqueci a minha senha' caso tenha se esquecido da sua senha ou em 'Login' para se logar no sistema!";
        }
        else{
            $sql = "SELECT * FROM users_pre WHERE email = '".$_REQUEST['email']."'";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query)) {
                echo "0|-|Já existe um usuáio pre-cadastrado com esse email! Aguarde ele ser checado que você vai receber um email nosso informando isso!";
            }
            else{
                if ($_REQUEST['password'] != $_REQUEST['password2']){
                    echo "0|-|As senhas digitadas não conferem. Confira!";
                }
                else {
                    $sql = "INSERT INTO user_pres (name, email, password, created_at, updated_at) VALUES ('".$_REQUEST['nome']."', '".$_REQUEST['email']."', '".md5($_REQUEST['password'])."', now(), now())";
                    mysqli_query($con, $sql);
                    $htmlEnvia = '<html><head><title>Pré cadastro efetuado com sucesso!</title></head><body><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td valign="top" width="200" style="text-align: center"><img src="'.URL.'img/logo.png" width="180"></td><td>Olá,<br><br>Viemos informar que foi feito um novo pré-cadastro no admin do site.<br><br>Nome: '.$_REQUEST['nome'].'<br>Email: '.$_REQUEST['email'].'<br><br>Para visualizar os pré-cadastros no admin, <a href="'.URL.'usuarios-pre">clique aqui</a>.<br><br>Atenciosamente,<br><br>Equipe <a href="https://www.bhcommerce.com.br">BH Commerce</a></td></tr></table></body></html>';
                    $nomeEnvia = "Henrique - BH Commerce";
                    $emailEnvia = "henrique@bhcommerce.com.br";
                    $assuntoEnvia = "BH Commerce - Pré-cadastro efetuado com sucesso";
                    $cabecalhoEmail = "Content-Type: text/html; charset=iso-8859-1\n";
                    $cabecalhoEmail .= "From: Contato - BH Commerce<contato@bhcommerce.com.br>\nReply-To: Henrique Marcandier - BH Commerce<henrique@bhcommerce.com.br>";
                    mail($nomeEnvia."<".$emailEnvia.">", ($assuntoEnvia), ($htmlEnvia), $cabecalhoEmail);
                    echo "1";
                }
            }
        }
        break;
    case "formLogin":
        $sql = "SELECT * FROM users WHERE email = '".$_REQUEST['email']."' AND password = '".md5($_REQUEST['password'])."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            $row = mysqli_fetch_array($query);
            $_SESSION['user'] = $row;
            $action = "Se logou no sistema";
            $idUser = $_SESSION['user']['id'];
            $sql = "INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$idUser."', '".$action."', now(), now())";
            mysqli_query($con, $sql);
            echo "1";
        }
        else{
            echo "0|-|Login e/ou senha inválidos! Confira!";
        }
        break;
    case "formAlterarSenha":
        if ($_REQUEST['password'] != $_REQUEST['password2']){
            echo "0|-|Informe senhhas iguais!";
        }
        else {
            $sql = "UPDATE users SET password = '".md5($_REQUEST['password'])."', remember_token = '', updated_at = now() WHERE id = '".$_REQUEST['idUsuario']."'";
            mysqli_query($con, $sql);
            echo "1";
        }
        break;
    case "formEsqueceuSuaSenha":
        $sql = "SELECT * FROM users WHERE email = '".$_REQUEST['email']."'";
        $query = mysqli_query ($con, $sql);
        if (mysqli_num_rows($query)){
            $row = mysqli_fetch_array($query);
            $digitos = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $sql = "UPDATE users SET remember_token = '".$digitos."' WHERE id = '".$row['id']."'";
            mysqli_query($con,  $sql);
            $html = "<html>
                    <head>
                        <title>BH Commerce - Esqueceu sua senha</title>
<                   </head>
                    <body>
                        <table width='100%' cellspacing='0' cellpadding='0' border='0'>
                            <tr>
                                <td width='100' style='text-align:center' valign='top'><img src='".URL."img/logo.png' width='90'></td>
                                <td>Olá <b>".$row['name']."</b>,<br><br>
                                Este email é porque você solicitou em nosso site um lembrete da sua senha!<br><br>
                                Para alterar a sua senha, <a href='".URL."alterar-senha.php?codigo=".$digitos."'>clique aqui</a>.<br><br>
                                Atenciosamente,<br><br>
                                Equipe <a href='https://www.bhcommerce.com.br'>BH Commerce</a></td>
<                           </tr>
                        </table>
                   </body>
                   </table>";
            $cabecalhoEmail = "Content-Type: text/html; charset=iso-8859-1\n";
            $cabecalhoEmail .= "From: Contato - BH Commerce<contato@bhcommerce.com.br>\nReply-To: Henrique Marcandier - BH Commerce<henrique@bhcommerce.com.br>";
            mail($row['name']."<".$row['email'].">", "BH Commerce - Esqueceu sua senha?", $html, $cabecalhoEmail);
            echo "1|-|".$html;
        }
        else{
            echo "0|-|Esse email não está cadastrado em nossa base de dados!";
        }
        break;
    case 'aprovarUsuario':
        $sql = "SELECT * FROM user_pres WHERE id = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        $sql = "DELETE FROM user_pres WHERE id = '".$_REQUEST['id']."'";
        mysqli_query($con, $sql);
        $sql = "INSERT INTO users (name, email, password, created_at, updated_at) VALUES ('".$row['name']."', '".$row['email']."', '".$row['password']."', now(), now())";
        mysqli_query($con, $sql);
        $html = "<html>
                    <head>
                        <title>BH Commerce - Cadastro Liberado no Admin com Sucesso!</title>
<                   </head>
                    <body>
                        <table width='100%' cellspacing='0' cellpadding='0' border='0'>
                            <tr>
                                <td width='100' style='text-align:center' valign='top'><img src='".URL."img/logo.png' width='90'></td>
                                <td>Olá <b>".$row['name']."</b>,<br><br>
                                Este email é para informar que o seu cadastro foi liberado com sucesso no admin de nosso site!<br><br>
                                Para acessar nosso admin, <a href='https://www.bhcommerce.com.br/admin'>clique aqui</a>.<br><br>
                                Seu email: ".$row['email']."<br><br>
                                Atenciosamente,<br><br>
                                Equipe <a href='https://www.bhcommerce.com.br'>BH Commerce</a></td>
<                           </tr>
                        </table>
                   </body>
                   </table>";
        $cabecalhoEmail = "Content-Type: text/html; charset=iso-8859-1\n";
        $cabecalhoEmail .= "From: Contato - BH Commerce<contato@bhcommerce.com.br>\nReply-To: Henrique Marcandier - BH Commerce<henrique@bhcommerce.com.br>";
        mail($row['name']."<".$row['email'].">", "BH Commerce - Cadastro Liberado no Admin com Sucesso!", $html, $cabecalhoEmail);
        echo "1";
        break;
    case "editar":
        switch ($_REQUEST['table']){
            case "alunos":
                $sql = ("UPDATE students SET name = '".$_REQUEST['nomeEdicao']."', registration = '".($_REQUEST['matriculaEdicao'])."', status = '".$_REQUEST['situacaoEdicao']."', zip = '".$_REQUEST['cepEdicao']."', address = '".$_REQUEST['logradouroEdicao']."', number = '".$_REQUEST['numeroEdicao']."', complement = '".$_REQUEST['complementoEdicao']."', neighborhood = '".$_REQUEST['bairroEdicao']."', city = '".$_REQUEST['cidadeEdicao']."', state = '".$_REQUEST['estadoEdicao']."', course = '".$_REQUEST['cursoEdicao']."', turma = '".$_REQUEST['turmaEdicao']."', updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'");
                $artigo = "o";
                if ($_FILES['imagemEdicao'] && $_FILES['imagemEdicao']['error'] == 0){
                    $filesImg = $_FILES['imagemEdicao']['tmp_name'];
                    $nameImg = $_FILES['imagemEdicao']['name'];
                    $qualEdicao = "aluno";
                    $tableEditar = "students";
                }
                break;
            case "cursos":
                $sql = "UPDATE courses SET name = '".($_REQUEST['nomeEdicao'])."', updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                break;
            case "tiposDocumento":
                $sql = "UPDATE type_documents SET name = '".($_REQUEST['nomeEdicao'])."', status = '".($_REQUEST['statusEdicao'])."', updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                break;
            case "clientes":
                $sql = "UPDATE clients SET name = '".($_REQUEST['nomeEdicao'])."', email = '".($_REQUEST['emailEdicao'])."', cel = '".$_REQUEST['celularEdicao']."', typeDocument = '".$_REQUEST['tipoDocumentoEdicao']."', document = '".$_REQUEST['documentoEdicao']."'";
                if ($_REQUEST['senhaEdicao']){
                    $sql .= ", password = '".md5($_REQUEST['senhaEdicao'])."'";
                }
                $sql .= ", updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                break;
            case "tiposProduto":
                $sql = "UPDATE types_products SET name = '".($_REQUEST['nomeEdicao'])."', status = '".($_REQUEST['statusEdicao'])."', updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                break;
            case "produto":
                $sql = "UPDATE products SET name = '".($_REQUEST['nomeEdicao'])."', description = '".($_REQUEST['descricaoEdicao'])."', status = '".($_REQUEST['statusEdicao'])."'";
                $sql .= ", updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                if ($_FILES['imagemEdicao'] && $_FILES['imagemEdicao']['error'] == 0){
                    $filesImg = $_FILES['imagemEdicao']['tmp_name'];
                    $nameImg = $_FILES['imagemEdicao']['name'];
                    $qualEdicao = "produto";
                    $tableEditar = "products";
                }
                break;
            case "formaPagamento":
                $sql = "UPDATE payment_methods SET name = '".($_REQUEST['nomeEdicao'])."'";
                $sql .= ", updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                if ($_FILES['imagemEdicao'] && $_FILES['imagemEdicao']['error'] == 0){
                    $filesImg = $_FILES['imagemEdicao']['tmp_name'];
                    $nameImg = $_FILES['imagemEdicao']['name'];
                    $qualEdicao = "formaPagamento";
                    $tableEditar = "payment_methods";
                }
                break;
            case "dominio":
                $sql = "UPDATE domines SET alias = '".($_REQUEST['aliasEdicao']."', domine = '".$_REQUEST['dominioEdicao']."', user = '".$_REQUEST['usuarioEdicao']."', password = '".$_REQUEST['senhaEdicao']."'");
                $sql .= ", updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                break;
            case "pagina":
                $sql = "UPDATE pages SET name = '".($_REQUEST['nomeEdicao']."', description = '".$_REQUEST['descricaoEdicao']."', subname = '".$_REQUEST['subtituloEdicao']."', appearsMenu = '".$_REQUEST['apareceMenuEdicao']."', appearsSite = '".$_REQUEST['apareceSiteEdicao']."', status = '".$_REQUEST['statusEdicao']."'");
                $sql .= ", updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "a";
                $qualE = "pages";
                if ($_FILES['imagemEdicao'] && $_FILES['imagemEdicao']['error'] == 0){
                    $filesImg = $_FILES['imagemEdicao']['tmp_name'];
                    $nameImg = $_FILES['imagemEdicao']['name'];
                    $qualEdicao = "pagina";
                    $tableEditar = "pages";
                }
                break;
            case "subitem":
                $sql = "UPDATE subitems SET name = '".($_REQUEST['nomeEdicao']."', description = '".$_REQUEST['descricaoEdicao']."', subname = '".$_REQUEST['subtituloEdicao']."', appearsImg = '".$_REQUEST['mostraImagemEdicao']."', page = '".$_REQUEST['paginaEdicao']."', status = '".$_REQUEST['statusEdicao']."'");
                $sql .= ", updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                $qualE = "subitems";
                if ($_FILES['imagemEdicao'] && $_FILES['imagemEdicao']['error'] == 0){
                    $filesImg = $_FILES['imagemEdicao']['tmp_name'];
                    $nameImg = $_FILES['imagemEdicao']['name'];
                    $qualEdicao = "subitem";
                    $tableEditar = "subitems";
                }
                break;
            case "tipoServico":
                $sql = "UPDATE types_services SET name = '".($_REQUEST['nomeEdicao'])."', status = '".($_REQUEST['statusEdicao'])."', updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                break;
            case "tipoModulo":
                $sql = "UPDATE type_modules SET name = '".($_REQUEST['nomeEdicao'])."', status = '".($_REQUEST['statusEdicao'])."', updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                break;
            case "modulo":
                $sql = "UPDATE modules SET name = '".($_REQUEST['nomeEdicao'])."', status = '".($_REQUEST['statusEdicao'])."', typeModule = '".$_REQUEST['tipoModuloEdicao']."', slug = '".$_REQUEST['urlAmigavelEdicao']."', updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                break;
            case "prioridade":
                $sql = "UPDATE priorities SET name = '".($_REQUEST['nomeEdicao'])."', status = '".($_REQUEST['statusEdicao'])."', updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "a";
                break;
            case "tipoVersao":
                $sql = "UPDATE type_versions SET name = '".($_REQUEST['nomeEdicao'])."', typeService = '".($_REQUEST['tipoServicoEdicao'])."', status = '".($_REQUEST['statusEdicao'])."', updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                break;
            case "categoria":
                $sql = "UPDATE categories SET name = '".($_REQUEST['nomeEdicao'])."', typeService = '".($_REQUEST['tipoServicoEdicao'])."', status = '".($_REQUEST['statusEdicao'])."', updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "a";
                break;
            case "parametroSite":
                $sql = "UPDATE param_sites SET name = '".($_REQUEST['nomeEdicao'])."', value = '".($_REQUEST['valorEdicao'])."', updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                break;
            case "parametroAdmin":
                $sql = "UPDATE param_admins SET name = '".($_REQUEST['nomeEdicao'])."', value = '".($_REQUEST['valorEdicao'])."', updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                break;
            case "versao":
                $sql = "UPDATE versions SET name = '".($_REQUEST['nomeEdicao'])."', description = '".($_REQUEST['descricaoEdicao'])."', date = '".($_REQUEST['dataEdicao'])."'";
                $sql .= ", updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "a";
                if ($_FILES['imagemEdicao'] && $_FILES['imagemEdicao']['error'] == 0){
                    $filesImg = $_FILES['imagemEdicao']['tmp_name'];
                    $nameImg = $_FILES['imagemEdicao']['name'];
                    $qualEdicao = "versao";
                    $tableEditar = "versions";
                }
                break;
            case "usuario":
                $sql = "UPDATE users SET name = '".($_REQUEST['nomeEdicao'])."', email = '".($_REQUEST['emailEdicao'])."'";
                if ($_REQUEST['senhaEdicao']){
                    $sql .= ", password = '".md5($_REQUEST['senhaEdicao'])."'";
                }
                $sql .= ", updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                if ($_FILES['imagemEdicao'] && $_FILES['imagemEdicao']['error'] == 0){
                    $filesImg = $_FILES['imagemEdicao']['tmp_name'];
                    $nameImg = $_FILES['imagemEdicao']['name'];
                    $qualEdicao = "usuarios";
                    $tableEditar = "users";
                }
                break;
            case "usuarioPre":
                $sql = "UPDATE user_pres SET name = '".($_REQUEST['nomeEdicao'])."', email = '".($_REQUEST['emailEdicao'])."'";
                if ($_REQUEST['senhaEdicao']){
                    $sql .= ", password = '".md5($_REQUEST['senhaEdicao'])."'";
                }
                $sql .= ", updated_at = now() WHERE id = '".$_REQUEST['idEdicao']."'";
                $artigo = "o";
                break;
        }
        mysqli_query($con, $sql) or die(mysqli_error($con));
        if ($qualE){
            $sql = "SELECT * FROM ".$qualE." WHERE id = '".$_REQUEST['idEdicao']."'";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($query);
            $slug = retirarAcentos($row['name']);
            $sql = "UPDATE ".$qualE." SET slug = '". $slug."' WHERE id = '".$_REQUEST['idEdicao']."'";
            mysqli_query($con, $sql);

        }
        if ($filesImg && $qualEdicao){
            if (preg_match('/.jpg/', $nameImg) || preg_match('/.jpeg/', $nameImg)){
                $arquivo = $qualEdicao.$_REQUEST['idEdicao'].".jpg";
            }
            elseif (preg_match('/.gif/', $nameImg)){
                $arquivo = $qualEdicao.$_REQUEST['idEdicao'].".gif";
            }
            elseif (preg_match('/.png/', $nameImg)){
                $arquivo = $qualEdicao.$_REQUEST['idEdicao'].".png";
            }
            elseif (preg_match('/.bmp/', $nameImg)){
                $arquivo = $qualEdicao.$_REQUEST['idEdicao'].".bmp";
            }
            elseif (preg_match('/.svg/', $nameImg)){
                $arquivo = $qualEdicao.$_REQUEST['idEdicao'].".svg";
            }
            if ($arquivo){
                copy($filesImg, DIRETORIO."storage/".$arquivo);
                $sql = "UPDATE ".$tableEditar." SET img = '".$arquivo."' WHERE id = '".$_REQUEST['idEdicao']."'";
                mysqli_query($con, $sql);
                $img = URL."storage/".$arquivo;
            }
        }
        $action = "Atualizou ".$artigo." ".$_REQUEST['table']." ".$_REQUEST['idEdicao'];
        $sql = "INSERT INTO logs (action, user, created_at, updated_at) VALUES ('".$action."', '".$_REQUEST['idUserEdicao']."', now(), now())";
        mysqli_query($con, $sql);
        echo "1|-|".$_REQUEST['idUserEdicao']."|-|".$img;
        break;
    case "cadastrar":
        switch ($_REQUEST['table']){
            case "alunos":
                $sql = ("INSERT INTO students (name, registration, status, zip, address, number, complement, neighborhood, city, state, course, turma, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['matriculaCadastro']."', '".$_REQUEST['situacaoCadastro']."', '".$_REQUEST['cepCadastro']."', '".$_REQUEST['logradouroCadastro']."', '".$_REQUEST['numeroCadastro']."', '".$_REQUEST['complementoCadastro']."', '".$_REQUEST['bairroCadastro']."', '".$_REQUEST['cidadeCadastro']."', '".$_REQUEST['estadoCadastro']."', '".$_REQUEST['cursoCadastro']."', '".$_REQUEST['turmaCadastro']."', now(), now())");
                $artigo = "o";
                if ($_FILES['imagemCadastro'] && $_FILES['imagemCadastro']['error'] == 0){
                    $filesImg = $_FILES['imagemCadastro']['tmp_name'];
                    $nameImg = $_FILES['imagemCadastro']['name'];
                    $qualEdicao = "aluno";
                    $tableEditar = "students";
                }
                break;
            case "cursos":
                $sql = ("INSERT INTO courses (name, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', now(), now())");
                $artigo = "o";
                break;
            case "tiposDocumento":
                $sql = ("INSERT INTO type_documents (name, status, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['statusCadastro']."', now(), now())");
                $artigo = "o";
                break;
            case "tiposProduto":
                $sql = ("INSERT INTO types_products (name, status, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['statusCadastro']."', now(), now())");
                $artigo = "o";
                break;
            case "produto":
                $sql = ("INSERT INTO products (name, description, status, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['descricaoCadastro']."', '".$_REQUEST['statusCadastro']."', now(), now())");
                $artigo = "o";
                if ($_FILES['imagemCadastro'] && $_FILES['imagemCadastro']['error'] == 0){
                    $filesImg = $_FILES['imagemCadastro']['tmp_name'];
                    $nameImg = $_FILES['imagemCadastro']['name'];
                    $qualEdicao = "produto";
                    $tableEditar = "products";
                }
                break;
            case "formaPagamento":
                $sql = ("INSERT INTO payment_methods (name, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', now(), now())");
                $artigo = "o";
                if ($_FILES['imagemCadastro'] && $_FILES['imagemCadastro']['error'] == 0){
                    $filesImg = $_FILES['imagemCadastro']['tmp_name'];
                    $nameImg = $_FILES['imagemCadastro']['name'];
                    $qualEdicao = "formaPagamento";
                    $tableEditar = "payment_methods";
                }
                break;
            case "dominio":
                $sql = ("INSERT INTO domines (alias, domine, user, password, created_at, updated_at) VALUES ('".$_REQUEST['aliasCadastro']."', '".$_REQUEST['dominioCadastro']."', '".$_REQUEST['usuarioCadastro']."', '".$_REQUEST['senhaCadastro']."', now(), now())");
                $artigo = "o";
                break;
            case "pagina":
                $sql = ("INSERT INTO pages (name, description, subname, appearsMenu, appearsSite, status, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['descricaoCadastro']."', '".$_REQUEST['subtituloCadastro']."', '".$_REQUEST['apareceMenuCadastro']."', '".$_REQUEST['apareceSiteCadastro']."', '".$_REQUEST['statusCadastro']."', now(), now())");
                $artigo = "a";
                $qualE = "pages";
                if ($_FILES['imagemCadastro'] && $_FILES['imagemCadastro']['error'] == 0){
                    $filesImg = $_FILES['imagemCadastro']['tmp_name'];
                    $nameImg = $_FILES['imagemCadastro']['name'];
                    $qualEdicao = "pagina";
                    $tableEditar = "pages";
                }
                break;
            case "subitem":
                $sql = ("INSERT INTO subitems (page, name, description, subname, appearsImg, status, created_at, updated_at) VALUES ('".$_REQUEST['paginaCadastro']."', '".$_REQUEST['nomeCadastro']."', '".$_REQUEST['descricaoCadastro']."', '".$_REQUEST['subtituloCadastro']."', '".$_REQUEST['mostraImagemCadastro']."', '".$_REQUEST['statusCadastro']."', now(), now())");
                $artigo = "a";
                $qualE = "subitems";
                if ($_FILES['imagemCadastro'] && $_FILES['imagemCadastro']['error'] == 0){
                    $filesImg = $_FILES['imagemCadastro']['tmp_name'];
                    $nameImg = $_FILES['imagemCadastro']['name'];
                    $qualEdicao = "subitem";
                    $tableEditar = "subitems";
                }
                break;
            case "tipoServico":
                $sql = ("INSERT INTO types_services (name, status, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['statusCadastro']."', now(), now())");
                $artigo = "o";
                break;
            case "prioridade":
                $sql = ("INSERT INTO priorities (name, status, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['statusCadastro']."', now(), now())");
                $artigo = "a";
                break;
            case "tipoVersao":
                $sql = ("INSERT INTO type_versions (name, typeService, status, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['tipoServicoCadastro']."', '".$_REQUEST['statusCadastro']."', now(), now())");
                $artigo = "o";
                break;
            case "categoria":
                $sql = ("INSERT INTO categories (name, typeService, status, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['tipoServicoCadastro']."', '".$_REQUEST['statusCadastro']."', now(), now())");
                $artigo = "a";
                break;
            case "parametroSite":
                $sql = ("INSERT INTO param_sites (name, value, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['valorCadastro']."', now(), now())");
                $artigo = "o";
                break;
            case "parametroAdmin":
                $sql = ("INSERT INTO param_admins (name, value, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['valorCadastro']."', now(), now())");
                $artigo = "o";
                break;
            case "versao":
                $sql = ("INSERT INTO versions (name, description, date, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['descricaoCadastro']."', '".($_REQUEST['dataCadastro'])."', now(), now())");
                $artigo = "a";
                if ($_FILES['imagemCadastro'] && $_FILES['imagemCadastro']['error'] == 0){
                    $filesImg = $_FILES['imagemCadastro']['tmp_name'];
                    $nameImg = $_FILES['imagemCadastro']['name'];
                    $qualEdicao = "versao";
                    $tableEditar = "versions";
                }
                break;
            case "usuarios":
                $sql = ("INSERT INTO users (name, email, password, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['emailCadastro']."', '".md5($_REQUEST['senhaCadastro'])."', now(), now())");
                $artigo = "o";
                if ($_FILES['imagemCadastro'] && $_FILES['imagemCadastro']['error'] == 0){
                    $filesImg = $_FILES['imagemCadastro']['tmp_name'];
                    $nameImg = $_FILES['imagemCadastro']['name'];
                    $qualEdicao = "usuario";
                    $tableEditar = "users";
                }
                break;
            case "tipoModulo":
                $sql = ("INSERT INTO type_modules (name, status, created_at, updated_at) VALUES ('".$_REQUEST['nomeCadastro']."', '".$_REQUEST['statusCadastro']."', now(), now())");
                $artigo = "o";
                break;
            case "modulo":
                $sql = ("INSERT INTO modules (typeModule, name, slug, status, created_at, updated_at) VALUES ('".$_REQUEST['tipoModuloCadastro']."', '".$_REQUEST['nomeCadastro']."', '".$_REQUEST['urlAmigavelCadastro']."', '".$_REQUEST['statusCadastro']."', now(), now())");
                $artigo = "o";
                break;
        }
        mysqli_query($con, $sql) or die(mysqli_error($con));
        $_REQUEST['idCadastro'] = mysqli_insert_id($con);
        if ($qualE){
            $sql = "SELECT * FROM ".$qualE." WHERE id = '".$_REQUEST['idCadastro']."'";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($query);
            $slug = retirarAcentos($row['name']);
            $sql = "UPDATE ".$qualE." SET slug = '". $slug."' WHERE id = '".$_REQUEST['idCadastro']."'";
            mysqli_query($con, $sql);
        }
        if ($filesImg && $qualEdicao){
            if (preg_match('/.jpg/', $nameImg) || preg_match('/.jpeg/', $nameImg)){
                $arquivo = $qualEdicao.$_REQUEST['idCadastro'].".jpg";
            }
            elseif (preg_match('/.gif/', $nameImg)){
                $arquivo = $qualEdicao.$_REQUEST['idCadastro'].".gif";
            }
            elseif (preg_match('/.png/', $nameImg)){
                $arquivo = $qualEdicao.$_REQUEST['idCadastro'].".png";
            }
            elseif (preg_match('/.bmp/', $nameImg)){
                $arquivo = $qualEdicao.$_REQUEST['idCadastro'].".bmp";
            }
            elseif (preg_match('/.svg/', $nameImg)){
                $arquivo = $quaclEdicao.$_REQUEST['idCadastro'].".svg";
            }
            if ($arquivo){
                copy($filesImg, DIRETORIO."storage/".$arquivo);
                $sql = "UPDATE ".$tableEditar." SET img = '".$arquivo."' WHERE id = '".$_REQUEST['idCadastro']."'";
                mysqli_query($con, $sql);
            }
        }
        $action = "Cadastrou ".$artigo." ".$_REQUEST['table']." ".$_REQUEST['idCadastro'];
        $sql = "INSERT INTO logs (action, user, created_at, updated_at) VALUES ('".$action."', '".$_REQUEST['idUserCadastro']."', now(), now())";
        mysqli_query($con, $sql);
        echo "1";
        break;
    case "visualizar":
        switch ($_REQUEST['table']){
            case "alunos":
                $sql = "SELECT a.*, b.name AS curso FROM students a INNER JOIN courses b ON (a.course = b.id) WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                if ($row['turma'] == 'M'){
                    $turma = "Manhã";
                }
                elseif ($row['turma'] == 'T'){
                    $turma = "Tarde";
                }
                elseif ($row['turma'] == 'N'){
                    $turma = "Noite";
                }
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>";
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                if (file_exists(DIRETORIO."storage/".$row['img'])){
                    $img = URL."storage/".$row['img'];
                }
                else{
                    $img = URL."storage/user-avatar.svg";
                }
                echo ("1|-|Nome: <b>".$row['name']."</b><br>".("Matrícula").": <b>".$row['registration']."</b><br>".("Situação").": <b>".$status."</b><br>CEP: <b>".$row['zip']."</b><br>Logradouro: <b>".$row['address']."</b><br>".("Número").": <b>".$row['number']."</b><br>Complemento: <b>".$row['complement']."</b><br>Bairro: <b>".$row['neighborhood']."</b><br>Cidade: <b>".$row['city']."</b><br>Estado: <b>".$row['state']."</b><br>Curso: <b>".$row['curso']."</b><br>Turma: <b>".($turma)."</b><br>Imagem: <b><img src='".$img."' width='50'> - <button class='btn btn-danger' onclick=excluirImg('alunos','".$row['id']."','".URL."','".$_SESSION['user']['id']."','o')>Excluir Imagem</button></b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "a";
                break;
            case "cursos":
                $sql = "SELECT a.* FROM courses a  WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "faleConosco":
                $sql = "SELECT a.* FROM messages a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#FFFF00'>Enviado</span>" : "<span style='color:#000033'>Respondido</span>";
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Email: <b>".$row['email']."</b><br>".("Assunto").": <b>".$row['subject']."</b><br>".("Telefone").": <b>".$row['phone']."</b><br>".("Mensagem").": <b>".nl2br($row['text'])."</b><br>Status: <b>".$status."</b>");
                if ($row['status'] == 2){
                    echo ('<br>Resposta: <b>'.nl2br($row['answer']).'</b>');
                }
                echo ("<br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "statusPedido":
                $sql = "SELECT a.* FROM requests_statuses a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>";
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Sigla: <b>".$row['sigla']."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "tiposDocumento":
                $sql = "SELECT a.* FROM type_documents a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>" ;
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Status: <b>".$status."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "clientes":
                $sql = "SELECT a.*, b.name AS nomeTipoDocumento FROM clients a INNER JOIN type_documents b ON (a.typeDocument = b.id) WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Email: <b>".$row['email']."</b><br>Celular: <b>".$row['cel']."</b><br>Tipo de Documento: <b>".$row['nomeTipoDocumento']."</b><br>Documento: <b>".$row['document']."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "tiposProduto":
                $sql = "SELECT a.* FROM types_products a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>" ;
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Status: <b>".$status."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "produto":
                $sql = "SELECT a.* FROM products a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>" ;
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                if (!file_exists(DIRETORIO."storage/".$row['img']) || !$row['img']){
                    $row['img'] = URL."img/noFoto1.gif";
                    $excluirImg = 0;
                }
                else{
                    $row['img'] = URL."storage/".$row['img'];
                    $excluirImg = 1;
                }
                echo ("1|-|Nome: <b>".$row['name']."</b><br>".("Descrição").": <b>".$row['description']."</b><br>");
                if ($excluirImg) {
                    echo "Imagem: <img src='" . $row['img'] . "' width='150'><input type='button' value='Excluir Imagem' class='btn btn-danger' onclick=excluirImg('produto','" . $row['id'] . "','" . URL . "','" . $_REQUEST['idUser'] . "','o')><br>";
                }
                echo ("Status: <b>".$status."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "formaPagamento":
                $sql = "SELECT a.* FROM payment_methods a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>" ;
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                if (!file_exists(DIRETORIO."storage/".$row['img']) || !$row['img']){
                    $row['img'] = URL."img/noFoto1.gif";
                    $excluirImg = 0;
                }
                else{
                    $row['img'] = URL."storage/".$row['img'];
                    $excluirImg = 1;
                }
                echo ("1|-|Nome: <b>".$row['name']."</b><br>");
                if ($excluirImg) {
                    echo "Imagem: <img src='" . $row['img'] . "' width='150'><input type='button' value='Excluir Imagem' class='btn btn-danger' onclick=excluirImg('formaPagamento','" . $row['id'] . "','" . URL . "','" . $_REQUEST['idUser'] . "','a')><br>";
                }
                echo ("Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "a";
                break;
            case "dominios":
                $sql = "SELECT a.* FROM domines a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                 $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|".("Aliás").": <b>".$row['alias']."</b><br>".("Domínio").": <b>".$row['domine']."</b><br>".('Usuário: ')."<b>".$row['user']."</b><br>");
                echo ("Senha: <b>".$row['password']."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "pagina":
                $sql = "SELECT a.* FROM pages a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $apareceMenu = ($row['appearsMenu'] == 1) ? "<span style='color:#000033'>Sim</span>" : "<span style='color:#FF0000'>Não</span>" ;
                $apareceSite = ($row['appearsSite'] == 1) ? "<span style='color:#000033'>Sim</span>" : "<span style='color:#FF0000'>Não</span>" ;
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>" ;
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                if (!file_exists(DIRETORIO."storage/".$row['img']) || !$row['img']){
                    $row['img'] = URL."img/noFoto1.gif";
                    $excluirImg = 0;
                }
                else{
                    $row['img'] = URL."storage/".$row['img'];
                    $excluirImg = 1;
                }
                if ($row['position'] == 1){
                    $row['position'] = "Banner Topo";
                }
                echo ("1|-|Nome: <b>".$row['name']."</b><br>".("Subtítulo").": <b>".$row['subname']."</b><br>".("Descrição").": <b>".$row['description']."</b><br>");
                if ($excluirImg) {
                    echo "Imagem: <img src='" . $row['img'] . "' width='150'><input type='button' value='Excluir Imagem' class='btn btn-danger' onclick=excluirImg('pagina','" . $row['id'] . "','" . URL . "','" . $_REQUEST['idUser'] . "','a')><br>";
                }
                echo ("Aparece no Menu: <b>".($apareceMenu)."</b><br>Aparece no Site: <b>".($apareceSite)."</b><br>Status: <b>".$status."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "a";
                break;
            case "subitem":
                $sql = "SELECT a.*, b.name AS nomePagina FROM subitems a INNER JOIN pages b ON (a.page = b.id) WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $apareceImagem = ($row['appearsImg'] == 1) ? "<span style='color:#000033'>Sim</span>" : "<span style='color:#FF0000'>Não</span>";
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>" ;
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                if (!file_exists(DIRETORIO."storage/".$row['img']) || !$row['img']){
                    $row['img'] = URL."img/noFoto1.gif";
                    $excluirImg = 0;
                }
                else{
                    $row['img'] = URL."storage/".$row['img'];
                    $excluirImg = 1;
                }
                if ($row['position'] == 1){
                    $row['position'] = "Banner Topo";
                }
                echo ("1|-|".("Página").": <b>".$row['nomePagina']."</b><br>Nome: <b>".$row['name']."</b><br>".("Subtítulo").": <b>".$row['subname']."</b><br>".("Descrição").": <b>".$row['description']."</b><br>");
                if ($excluirImg) {
                    echo "Imagem: <img src='" . $row['img'] . "' width='150'><input type='button' value='Excluir Imagem' class='btn btn-danger' onclick=excluirImg('subitem','" . $row['id'] . "','" . URL . "','" . $_REQUEST['idUser'] . "','o')><br>";
                }
                echo ("Aparece Imagem no ".("Subítem").": <b>".($apareceImagem)."</b><br>Status: <b>".$status."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "tipoServico":
                $sql = "SELECT a.* FROM types_services a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>" ;
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Status: <b>".$status."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "tipoModulo":
                $sql = "SELECT a.* FROM type_modules a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>" ;
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Status: <b>".$status."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "modulo":
                $sql = "SELECT a.*, b.name AS nomeTipoModulo FROM modules a INNER JOIN type_modules b ON (a.typeModule = b.id) WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>" ;
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|".("Nome do Tipo Módulo").": <b>".$row['nomeTipoModulo']."</b><br>Nome: <b>".$row['name']."</b><br>".("Url Amigável").": <b>".$row['slug']."</b><br>Status: <b>".$status."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "prioridade":
                $sql = "SELECT a.* FROM priorities a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>" ;
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Status: <b>".$status."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "a";
                break;
            case "tipoVersao":
                $sql = "SELECT a.*, b.name AS nomeTipoServico FROM type_versions a INNER JOIN types_services b ON (a.typeService = b.id) WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>";
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|".("Nome do Tipo de Serviço").": <b>".$row['nomeTipoServico']."</b><br>Nome: <b>".$row['name']."</b><br>Status: <b>".$status."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "categorias":
                $sql = "SELECT a.*, b.name AS nomeTipoServico FROM categories a INNER JOIN types_services b ON (a.typeService = b.id) WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>";
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|".("Nome do Tipo de Serviço").": <b>".$row['nomeTipoServico']."</b><br>Nome: <b>".$row['name']."</b><br>Status: <b>".$status."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "a";
                break;
            case "parametroSite":
                $sql = "SELECT a.* FROM param_sites a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>";
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Valor: <b>".$row['value']."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "parametroAdmin":
                $sql = "SELECT a.* FROM param_admins a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $status = ($row['status'] == 1) ? "<span style='color:#000033'>Ativo</span>" : "<span style='color:#FF0000'>Inativo</span>";
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Valor: <b>".$row['value']."</b><br>Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "versao":
                $sql = "SELECT a.* FROM versions a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                if (!file_exists(DIRETORIO."storage/".$row['img'])){
                    $row['img'] = URL."img/noFotoUsuario.png";
                    $excluirImg = 0;
                }
                else{
                    $row['img'] = URL."storage/".$row['img'];
                    $excluirImg = 1;
                }
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode('-', $row['date']);
                $row['data'] = $vet[2]."/".$vet[1]."/".$vet[0];
                echo ("1|-|Nome: <b>".$row['name']."</b><br>".("Descrição")." <b>".$row['description']."</b><br>Data: <b>".$row['data']."</b><br>");
                if ($excluirImg) {
                    echo "Imagem: <img src='" . $row['img'] . "' width='150'><input type='button' value='Excluir Imagem' class='btn btn-danger' onclick=excluirImg('versao','" . $row['id'] . "','" . URL . "','" . $_REQUEST['idUser'] . "','a')><br>";
                }
                echo ("Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "usuarios":
                $sql = "SELECT a.* FROM users a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                if (!file_exists(DIRETORIO."storage/".$row['img'])){
                    $row['img'] = URL."img/user-avatar.svg";
                    $excluirImg = 0;
                }
                else{
                    $row['img'] = URL."storage/".$row['img'];
                    $excluirImg = 1;
                }
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Email: <b>".$row['email']."</b><br>Foto: <img src='");
                if ($excluirImg){
                    echo $row['img'];
                    echo "' width='100'> <a class='btn btn-primary' style='color:#FFFFFF' onclick=excluirImg('usuarios','".$row['id']."','".URL."','".$_SESSION['user']['id']."','a');>Excluir Foto</a><br>";
                }
                else{
                    echo URL."img/noFotoUsuario.png' width='100'><br>";
                }
                echo ("Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
            case "usuariosPre":
                $sql = "SELECT a.* FROM user_pres a WHERE a.id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $vet = explode(' ', $row['created_at']);
                $vet2 = explode('-', $vet[0]);
                $row['created_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                $vet = explode(' ', $row['updated_at']);
                $vet2 = explode('-', $vet[0]);
                $row['updated_at'] = ($vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h");
                echo ("1|-|Nome: <b>".$row['name']."</b><br>Email: <b>".$row['email']."</b><br>");
                echo ("Data de Cadastro: <b>".$row['created_at']."</b><br>".("Data de Atualização").": <b>".$row['updated_at']."</b>");
                $artigo = "o";
                break;
        }
        $action = "Visualizou ".$artigo." ".$_REQUEST['table']." ".$_REQUEST['id'];
        $sql = "INSERT INTO logs (action, user, created_at, updated_at) VALUES ('".$action."', '".$_REQUEST['idUser']."', now(), now())";
        mysqli_query($con, $sql);
        break;
     case 'excluirImg':
        unlink(DIRETORIO."storage/".$_REQUEST['table'].$_REQUEST['id'].".jpg");
        unlink(DIRETORIO."storage/".$_REQUEST['table'].$_REQUEST['id'].".gif");
        unlink(DIRETORIO."storage/".$_REQUEST['table'].$_REQUEST['id'].".png");
        unlink(DIRETORIO."storage/".$_REQUEST['table'].$_REQUEST['id'].".bmp");
        unlink(DIRETORIO."storage/".$_REQUEST['table'].$_REQUEST['id'].".svg");
        if ($_REQUEST['table'] == 'usuarios'){
            $table = "usuario";
        }
        elseif ($_REQUEST['table'] == 'produto'){
            $table = "produto";
        }
        elseif ($_REQUEST['table'] == 'formaPagamento'){
            $table = "forma de pagamento";
        }
        elseif ($_REQUEST['table'] == 'banner'){
            $table = "banner";
        }
        elseif ($_REQUEST['table'] == 'pagina'){
            $table = "página";
        }
        elseif ($_REQUEST['table'] == 'subitem'){
            $table = "subitem";
        }
        elseif ($_REQUEST['table'] == 'versao'){
            $table = "versao";
        }
        elseif ($_REQUEST['table'] == 'usuario'){
            $table = "usuario";
        }
        elseif ($_REQUEST['table'] == 'alunos'){
            $table = "aluno";
            $sql = "UPDATE students SET img = '".$_RE."'";
        }
        $action = "Excluiu a imagem d".$_REQUEST['artigo']." ".$table." ".$_REQUEST['id'];
        $sql = "INSERT INTO logs (action, user, created_at, updated_at) VALUES ('".$action."', '".$_REQUEST['idUser']."', now(), now())";
        mysqli_query($con, $sql);
        echo "1|-|".$_SESSION['user']['id']."|-|".URL."img/user-avatar.svg";
        break;
    case "selecionaCliente":
        $sql = "SELECT a.*, b.name AS nomeTipoDocumento FROM clients a INNER JOIN type_documents b ON (a.typeDocument = b.id) WHERE a.id = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        $html = "Nome do Cliente: <b>".($row['name'])."</b><br>
                Email do Cliente: <b>".($row['email'])."</b><br>
                Telefone do Cliente: <b>".($row['cel'])."</b><br>
                Tipo de Documento do Cliente: <b>".($row['nomeTipoDocumento'])."</b><br>
                Documento do Cliente: <b>".($row['document'])."</b> ";
        $sql = "SELECT * FROM addresses WHERE idClient = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        $html2 = "<select name='enderecoEditar' id='enderecoEditar' class='form-control' onchange='selecionaEndereco(this.value,\"".URL."\")'><option value=''>Selecione o endereço abaixo corretamente...</option>";
        if (mysqli_num_rows($query)){
            while ($row = mysqli_fetch_array($query)){
                $html2 .= "<option value='".$row['id']."'>".($row['name'])."</option>";
            }
        }
        $html2 .= "</select><span id='dadosEndereco'>Selecione o endereco acima corretamente!</span>";
        echo "1|-|".($html)."|-|".$html2;
        break;
    case "selecionaEndereco":
        $sql = "SELECT * FROM addresses WHERE id = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        $html = "Nome do Endereço: <b>".($row['name'])."</b><br>
                CEP do Endereço: <b>".($row['cep'])."</b><br>
                Logradouro do Endereço: <b>".($row['address'])."</b><br>
                Número do Endereço: <b>".($row['number'])."</b><br>
                Complemento do Endereço: <b>".($row['complement'])."</b><br>
                Bairro do Endereço: <b>".($row['neighborhood'])."</b><br>
                Cidade do Endereço: <b>".($row['city'])."</b><br>
                Estado do Endereço: <b>".($row['state'])."</b>";
        echo "1|-|".($html);
        break;
    case "pegaDados":
        switch ($_REQUEST['table']){
            case 'alunos':
                $sql = "SELECT * FROM students WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['registration']."|-|".$row['status']."|-|".$row['zip']."|-|".$row['address']."|-|".$row['number']."|-|".$row['complement']."|-|".$row['neighborhood']."|-|".$row['city']."|-|".$row['state']."|-|".$row['course']."|-|".$row['turma']);
                break;
            case 'cursos':
                $sql = "SELECT * FROM courses WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']);
                break;
            case 'faleConosco':
                $sql = "SELECT * FROM messages WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['email']."|-|".$row['status']."|-|".$row['subject']."|-|".$row['phone']."|-|".$row['text']."|-|".$row['answer']);
                break;
            case 'statusPedido':
                $sql = "SELECT * FROM requests_statuses WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['sigla']."|-|".$row['name']);
                break;
            case 'tipoDocumento':
                $sql = "SELECT * FROM type_documents WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['status']);
                break;
            case 'clientes':
                $sql = "SELECT * FROM clients WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['email']."|-|".$row['cel']."|-|".$row['typeDocument']."|-|".$row['document']);
                break;
            case 'tiposProduto':
                $sql = "SELECT * FROM types_products WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['status']);
                break;
            case 'produto':
                $sql = "SELECT * FROM products WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['status']."|-|".$row['description']."|-|".URL."itensVendaProduto.php?idProduto=".$_REQUEST['id']);
                break;
            case 'formaPagamento':
                $sql = "SELECT * FROM payment_methods WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']);
                break;
            case 'dominio':
                $sql = "SELECT * FROM domines WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['alias']."|-|".$row['domine']."|-|".$row['user']."|-|".$row['password']);
                break;
            case 'pagina':
                $sql = "SELECT * FROM pages WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['status']."|-|".$row['description']."|-|".$row['subname']."|-|".$row['appearsMenu']."|-|".$row['appearsSite']);
                break;
            case 'subitem':
                $sql = "SELECT * FROM subitems WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['status']."|-|".$row['description']."|-|".$row['subname']."|-|".$row['appearsImg']."|-|".$row['page']);
                break;
            case 'tipoServico':
                $sql = "SELECT * FROM types_services WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['status']);
                break;
            case 'prioridade':
                $sql = "SELECT * FROM priorities WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['status']);
                break;
            case 'tipoVersao':
                $sql = "SELECT * FROM type_versions WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['typeService']."|-|".$row['name']."|-|".$row['status']);
                break;
            case 'categorias':
                $sql = "SELECT * FROM categories WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['typeService']."|-|".$row['name']."|-|".$row['status']);
                break;
            case 'parametroAdmin':
                $sql = "SELECT * FROM param_admins WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['value']."|-|".$row['status']);
                break;
            case 'parametroSite':
                $sql = "SELECT * FROM param_sites WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['value']."|-|".$row['status']);
                break;
            case 'versao':
                $sql = "SELECT * FROM versions WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['description']."|-|".$row['date']);
                break;
            case 'tipoModulo':
                $sql = "SELECT * FROM type_modules WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['status']);
                break;
            case 'modulo':
                $sql = "SELECT * FROM modules WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['status']."|-|".$row['typeModule']."|-|".$row['slug']);
                break;
            case 'usuarios':
                $sql = "SELECT * FROM users WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['email']);
                break;
            case 'usuariosPre':
                $sql = "SELECT * FROM user_pres WHERE id = '".$_REQUEST['id']."'";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['email']);
                break;
        }
        break;
    case "excluir":
        $sql = "DELETE FROM ".$_REQUEST['table']." WHERE id = '".$_REQUEST['id']."'";
        mysqli_query($con, $sql) or die(mysqli_error($con));
        $acao = "Excluiu ".$_REQUEST['artigo']." ".$_REQUEST['tabela']." ".$_REQUEST['id'];
        $sql = "INSERT INTO logs (action, user, created_at, updated_at) VALUES ('".$acao."', '".$_REQUEST['idUser']."', now(), now())";
        mysqli_query($con, $sql) or die(mysqli_error($con));
        echo "1";
        break;
    case 'importacaoAlunos':
        if ($_REQUEST['numeroAlunos']){
            $nomes[0] = "Henrique";
            $nomes[1] = "Mônica";
            $nomes[2] = "Daniel";
            $nomes[3] = "Andréia";
            $nomes[4] = "Breno";
            $nomes[5] = "Letícia";
            $nomes[6] = "Rogério";
            $nomes[7] = "Tatiana";
            $nomes[8] = "Artur";
            $nomes[9] = "Isabela";
            $sobrenomes[0] = "Marcandier";
            $sobrenomes[1] = "Marques";
            $sobrenomes[2] = "Gonçalves";
            $sobrenomes[3] = "Oliveira";
            $sobrenomes[4] = "Silva";
            $sobrenomes[5] = "Melo";
            $sobrenomes[6] = "Andrade";
            $sobrenomes[7] = "Amaral";
            $sobrenomes[8] = "de Sá";
            $sobrenomes[9] = "Gontijo";
            $sql = "SELECT * FROM students ORDER BY registration ASC";
            $query = mysqli_query($con, $sql);
            $m = mysqli_num_rows($query) + 1;
            $sql = "SELECT * FROM courses ORDER BY id ASC";
            $query = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_array($query)) {
                for ($i = 1; $i <= 3; $i++) {
                    if ($i == 1) {
                        $turma = "M";
                    } elseif ($i == 2) {
                        $turma = "T";
                    } elseif ($i == 3) {
                        $turma = "N";
                    }
                    for ($j = 0; $j < $_REQUEST['numeroAlunos']; $j++) {
                        $nome = $nomes[rand(0, 9)] . " " . $sobrenomes[rand(0, 9)] . " " . $sobrenomes[rand(0, 9)];
                        $sql = ("INSERT INTO students (name, registration, status, zip, address, number, complement, neighborhood, city, state, course, turma, created_at, updated_at) VALUES ('" . $nome . "', '" . $m . "', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', '" . $row['id'] . "', '" . $turma . "', now(), now())");
                        mysqli_query($con, $sql);
                        $m++;
                    }
                }
            }
            echo "1";
        }
        else{
            echo "0|-|Sem o número de alunos informado!";
        }
        break;
    case 'verificaNovamente':
        switch ($_REQUEST['tela']) {
            case 'index':
                $sql = "SELECT * FROM domines";
                $query = mysqli_query($con, $sql);
                $dominios = mysqli_num_rows($query);
                $html = '
                    <div class="col-lg-12 col-12">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>'.$dominios.'</h3>

                                <p>Domínios</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-edit"></i>
                            </div>
                            <a href="'.URL.'dominios" class="small-box-footer">Maiores Informações <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>';
                break;
            case 'cursos':
                $sql = "SELECT a.* FROM courses a ";
                if ($_REQUEST['nomeFiltro']) {
                    $sql .= "WHERE a.name LIKE '%" . $_REQUEST['nomeFiltro'] . "%' ";
                    $where = 1;
                }
                $sql .= "ORDER BY a.id ASC";
                $query = mysqli_query($con, $sql);
                $total = mysqli_num_rows($query);
                $offSet = $_REQUEST['pagina'] < 1 ? 0 : ((15 * ($_REQUEST['pagina'] - 1) > $total) ? $total - ($total % 15) : 15 * ($_REQUEST['pagina'] - 1));
                $totalPaginacao = ceil($total / 15);
                if ($totalPaginacao == $_REQUEST['pagina']) {
                    $paginacaoProxima = $_REQUEST['pagina'];
                } elseif ($totalPaginacao > 1) {
                    $paginacaoProxima = $_REQUEST['pagina'] + 1;
                } else {
                    $paginacaoAnterior = 1;
                }
                if ($_REQUEST['pagina'] <= 10) {
                    $inicial = 1;
                } else {
                    $inicial = ((ceil($_REQUEST['pagina'] / 10) - 1) * 10) + 1;
                }
                $final = $inicial + 10;
                $sql .= " LIMIT " . $offSet . ", 15";
                $query = mysqli_query($con, $sql);
                if (mysqli_num_rows($query)) {
                    $html .= '
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>

                <th style="padding:5px">ID</th>
                
                <th style="padding:5px">Nome</th>

                <th style="padding:5px">Ações</th>

            </tr>
            </thead>
            <tbody>';
                    $key = 0;
                    while ($cursos = mysqli_fetch_object($query)) {
                        $vet = explode(' ', $cursos->created_at);
                        $vet2 = explode('-', $vet[0]);
                        $cursos->created_at = $vet2[2] . "/" . $vet2[1] . "/" . $vet2[0];
                        $status = ($cursos->status == 1) ? "<div style='background-color: #FFFF00; color: #000000; float:left; padding:5px'>Enviado</div>" : "<div style='background-color: #000033; color: #FFFFFF;  float:left; padding:5px'>Respondido</div>";
                        $html .= '<tr>

                    <td style="padding:5px">' . $cursos->id . '</td>

                    <td style="padding:5px">' . ($cursos->name) . '</td>

                    <td style="padding:5px">
                         <a href="#" data-toggle="modal" data-target="#modalVisualizacao" onclick=visualizarCursos("' . $cursos->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/visualizar.svg" width="20"></a>
                         <a href="#" data-toggle="modal" data-target="#modalEdicao" onclick=editarCursos("' . $cursos->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/editar.png" width="20"></a>
                        <a style="cursor:pointer" onclick=excluirCursos("' . $cursos->id . '","' . URL . '","' . $_REQUEST['idUser'] . '","o","curso")><img src="' . URL . 'img/excluir.png" width="20"></a>
                    </td>

                </tr>';
                        $key++;
                    }
                    $paginacaoAnterior = ($_REQUEST['pagina'] == 1) ? 1 : $_REQUEST['pagina'] - 1;
                    $html .= '</tbody></table>|-|<div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ion pagination mr-1"></i>
                  Paginação
                </h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm" style="width:100%; text-align:center">
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("cursos","' . URL . '","' . $_REQUEST['idUser'] . '","1")>&laquo;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("cursos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $paginacaoAnterior . '")>&leftarrow;</a></li>
                        ';
                    $background = ($_REQUEST['pagina'] == 1) ? "#cccccc" : "";
                    $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("cursos","' . URL . '","' . $_REQUEST['idUser'] . '","1")>1</a></li>';
                    if ($_REQUEST['pagina'] >= 11) {
                        $proxima2 = $inicial - 1;
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("cursos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>
                   ';
                    }
                    for ($j = $inicial; $j < $final; $j++) {
                        if ($j < $totalPaginacao && $j > 1) {
                            $background = ($_REQUEST['pagina'] == $j) ? "#cccccc" : "";
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("cursos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $j . '")>' . $j . '</a></li>
                        ';
                        }
                    }
                    if ($totalPaginacao > 11) {
                        $vaiAte = (floor($totalPaginacao / 10)) * 10;
                        if ($vaiAte >= $_REQUEST['pagina']) {
                            $proxima2 = $final;
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("cursos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>';
                        }
                    }
                    if ($totalPaginacao > 1) {
                        $background = ($_REQUEST['pagina'] == $totalPaginacao) ? "#cccccc" : "";
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("cursos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>' . $totalPaginacao . '</a></li>
                   ';
                        $proxima = $_REQUEST['pagina'] + 1;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    } else {
                        $proxima = 2;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    }
                    $html .= '
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("cursos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima . '")>&rightarrow;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("cursos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>&raquo;</a></li>
                   </ul></div>
                    </div>
                    </div>';
                } else {
                    $html = '<div style="text-align:center; background-color:#FF0000; color:#FFFFFF; padding:5px; width:100%">Sem nenhum registro encontrado!</div>';
                }
                break;
            case 'alunos':
                $sql = "SELECT a.* FROM students a  ";
                if ($_REQUEST['nomeFiltro']) {
                    $sql .= "WHERE a.name LIKE '%" . $_REQUEST['nomeFiltro'] . "%' ";
                    $where = 1;
                }
                if ($_REQUEST['idFiltro']) {
                    if ($where){
                        $sql .= "AND";
                    }
                    else{
                        $sql .= "WHERE";
                    }
                    $sql .= " a.registration = '" . $_REQUEST['idFiltro'] . "' ";
                    $where = 1;
                }
                if ($_REQUEST['cursoFiltro']) {
                    if ($where){
                        $sql .= "AND";
                    }
                    else{
                        $sql .= "WHERE";
                    }
                    $sql .= " a.course = '" . $_REQUEST['cursoFiltro'] . "' ";
                    $where = 1;
                }
                if ($_REQUEST['turmaFiltro']) {
                    if ($where){
                        $sql .= "AND";
                    }
                    else{
                        $sql .= "WHERE";
                    }
                    $sql .= " a.turma = '" . $_REQUEST['turmaFiltro'] . "' ";
                    $where = 1;
                }
                $sql .= "ORDER BY a.id ASC";
                $query = mysqli_query($con, $sql);
                $total = mysqli_num_rows($query);
                $offSet = $_REQUEST['pagina'] < 1 ? 0 : ((15 * ($_REQUEST['pagina'] - 1) > $total) ? $total - ($total % 15) : 15 * ($_REQUEST['pagina'] - 1));
                $totalPaginacao = ceil($total / 15);
                if ($totalPaginacao == $_REQUEST['pagina']) {
                    $paginacaoProxima = $_REQUEST['pagina'];
                } elseif ($totalPaginacao > 1) {
                    $paginacaoProxima = $_REQUEST['pagina'] + 1;
                } else {
                    $paginacaoAnterior = 1;
                }
                if ($_REQUEST['pagina'] <= 10) {
                    $inicial = 1;
                } else {
                    $inicial = ((ceil($_REQUEST['pagina'] / 10) - 1) * 10) + 1;
                }
                $final = $inicial + 10;
                $sql .= " LIMIT " . $offSet . ", 15";
                $query = mysqli_query($con, $sql);
                if (mysqli_num_rows($query)) {
                    $html .= '<table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>

                <th style="padding:5px">Matrícula</th>

                <th style="padding:5px">Nome</th>

                <th style="padding:5px">Ações</th>

            </tr>
            </thead>
            <tbody>';
                    $key = 0;
                    while ($alunos = mysqli_fetch_object($query)) {
                        $html .= '<tr>

                    <td style="padding:5px">' . $alunos->registration . '</td>

                    <td style="padding:5px">' . ($alunos->name) . '</td>

                    <td style="padding:5px">
                         <a href="#" data-toggle="modal" data-target="#modalVisualizacao" onclick=visualizarAlunos("' . $alunos->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/visualizar.svg" width="20"></a>
                         <a href="#" data-toggle="modal" data-target="#modalEdicao" onclick=editarAlunos("' . $alunos->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/editar.png" width="20"></a>
                         <a style="cursor:pointer" onclick=excluirAlunos("' . $alunos->id . '","' . URL . '","' . $_REQUEST['idUser'] . '","o","aluno")><img src="' . URL . 'img/excluir.png" width="20"></a>
                    </td>
                </tr>';
                        $key++;
                    }
                    $paginacaoAnterior = ($_REQUEST['pagina'] == 1) ? 1 : $_REQUEST['pagina'] - 1;
                    $html .= '</tbody></table>|-|<div class="card-header">
                <h3 class="card-title">
                  <i class="ion pagination mr-1"></i>
                  Paginação
                </h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm" style="width:100%; text-align:center">
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","1")>&laquo;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $paginacaoAnterior . '")>&leftarrow;</a></li>
                        ';
                    $background = ($_REQUEST['pagina'] == 1) ? "#cccccc" : "";
                    $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","1")>1</a></li>';
                    if ($_REQUEST['pagina'] >= 11) {
                        $proxima2 = $inicial - 1;
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>
                   ';
                    }
                    for ($j = $inicial; $j < $final; $j++) {
                        if ($j < $totalPaginacao && $j > 1) {
                            $background = ($_REQUEST['pagina'] == $j) ? "#cccccc" : "";
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $j . '")>' . $j . '</a></li>
                        ';
                        }
                    }
                    if ($totalPaginacao > 11) {
                        $vaiAte = (floor($totalPaginacao / 10)) * 10;
                        if ($vaiAte >= $_REQUEST['pagina']) {
                            $proxima2 = $final;
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>';
                        }
                    }
                    if ($totalPaginacao > 1) {
                        $background = ($_REQUEST['pagina'] == $totalPaginacao) ? "#cccccc" : "";
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>' . $totalPaginacao . '</a></li>
                   ';
                        $proxima = $_REQUEST['pagina'] + 1;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    } else {
                        $proxima = 2;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    }
                    $html .= '
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima . '")>&rightarrow;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>&raquo;</a></li>
                   </ul></div>
                    </div>
                    </div>';
                } else {
                    $html = '<div style="text-align:center; background-color:#FF0000; color:#FFFFFF; padding:5px; width:100%">Sem nenhum registro encontrado!</div>';
                }
                break;case 'alunos':
            $sql = "SELECT a.* FROM students a  ";
            if ($_REQUEST['nomeFiltro']) {
                $sql .= "WHERE a.name LIKE '%" . $_REQUEST['nomeFiltro'] . "%' ";
                $where = 1;
            }
            if ($_REQUEST['idFiltro']) {
                if ($where){
                    $sql .= "AND";
                }
                else{
                    $sql .= "WHERE";
                }
                $sql .= " a.registration = '" . $_REQUEST['idFiltro'] . "' ";
                $where = 1;
            }
            if ($_REQUEST['cursoFiltro']) {
                if ($where){
                    $sql .= "AND";
                }
                else{
                    $sql .= "WHERE";
                }
                $sql .= " a.course = '" . $_REQUEST['cursoFiltro'] . "' ";
                $where = 1;
            }
            if ($_REQUEST['turmaFiltro']) {
                if ($where){
                    $sql .= "AND";
                }
                else{
                    $sql .= "WHERE";
                }
                $sql .= " a.turma = '" . $_REQUEST['turmaFiltro'] . "' ";
                $where = 1;
            }
            $sql .= "ORDER BY a.id ASC";
            $query = mysqli_query($con, $sql);
            $total = mysqli_num_rows($query);
            $offSet = $_REQUEST['pagina'] < 1 ? 0 : ((15 * ($_REQUEST['pagina'] - 1) > $total) ? $total - ($total % 15) : 15 * ($_REQUEST['pagina'] - 1));
            $totalPaginacao = ceil($total / 15);
            if ($totalPaginacao == $_REQUEST['pagina']) {
                $paginacaoProxima = $_REQUEST['pagina'];
            } elseif ($totalPaginacao > 1) {
                $paginacaoProxima = $_REQUEST['pagina'] + 1;
            } else {
                $paginacaoAnterior = 1;
            }
            if ($_REQUEST['pagina'] <= 10) {
                $inicial = 1;
            } else {
                $inicial = ((ceil($_REQUEST['pagina'] / 10) - 1) * 10) + 1;
            }
            $final = $inicial + 10;
            $sql .= " LIMIT " . $offSet . ", 15";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query)) {
                $html .= '<table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>

                <th style="padding:5px">Matrícula</th>

                <th style="padding:5px">Nome</th>

                <th style="padding:5px">Ações</th>

            </tr>
            </thead>
            <tbody>';
                $key = 0;
                while ($alunos = mysqli_fetch_object($query)) {
                    $html .= '<tr>

                    <td style="padding:5px">' . $alunos->registration . '</td>

                    <td style="padding:5px">' . ($alunos->name) . '</td>

                    <td style="padding:5px">
                         <a href="#" data-toggle="modal" data-target="#modalVisualizacao" onclick=visualizarAlunos("' . $alunos->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/visualizar.svg" width="20"></a>
                         <a href="#" data-toggle="modal" data-target="#modalEdicao" onclick=editarAlunos("' . $alunos->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/editar.png" width="20"></a>
                         <a style="cursor:pointer" onclick=excluirAlunos("' . $alunos->id . '","' . URL . '","' . $_REQUEST['idUser'] . '","o","aluno")><img src="' . URL . 'img/excluir.png" width="20"></a>
                    </td>
                </tr>';
                    $key++;
                }
                $paginacaoAnterior = ($_REQUEST['pagina'] == 1) ? 1 : $_REQUEST['pagina'] - 1;
                $html .= '</tbody></table>|-|<div class="card-header">
                <h3 class="card-title">
                  <i class="ion pagination mr-1"></i>
                  Paginação
                </h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm" style="width:100%; text-align:center">
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","1")>&laquo;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $paginacaoAnterior . '")>&leftarrow;</a></li>
                        ';
                $background = ($_REQUEST['pagina'] == 1) ? "#cccccc" : "";
                $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","1")>1</a></li>';
                if ($_REQUEST['pagina'] >= 11) {
                    $proxima2 = $inicial - 1;
                    $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>
                   ';
                }
                for ($j = $inicial; $j < $final; $j++) {
                    if ($j < $totalPaginacao && $j > 1) {
                        $background = ($_REQUEST['pagina'] == $j) ? "#cccccc" : "";
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $j . '")>' . $j . '</a></li>
                        ';
                    }
                }
                if ($totalPaginacao > 11) {
                    $vaiAte = (floor($totalPaginacao / 10)) * 10;
                    if ($vaiAte >= $_REQUEST['pagina']) {
                        $proxima2 = $final;
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>';
                    }
                }
                if ($totalPaginacao > 1) {
                    $background = ($_REQUEST['pagina'] == $totalPaginacao) ? "#cccccc" : "";
                    $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>' . $totalPaginacao . '</a></li>
                   ';
                    $proxima = $_REQUEST['pagina'] + 1;
                    if ($proxima > $totalPaginacao) {
                        $proxima = $totalPginacao;
                    }
                } else {
                    $proxima = 2;
                    if ($proxima > $totalPaginacao) {
                        $proxima = $totalPginacao;
                    }
                }
                $html .= '
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima . '")>&rightarrow;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("alunos","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>&raquo;</a></li>
                   </ul></div>
                    </div>
                    </div>';
            } else {
                $html = '<div style="text-align:center; background-color:#FF0000; color:#FFFFFF; padding:5px; width:100%">Sem nenhum registro encontrado!</div>';
            }
            break;
            case 'alunosCurso':
                $sql = "SELECT a.* FROM students a ";
                $sql .= "Where a.course = '" . $_REQUEST['cursoFiltro'] . "' ";
                $where = 1;
                if ($_REQUEST['turmaFiltro']) {
                    if ($where){
                        $sql .= "AND";
                    }
                    else{
                        $sql .= "WHERE";
                    }
                    $sql .= " a.turma = '" . $_REQUEST['turmaFiltro'] . "' ";
                    $where = 1;
                }
                $sql .= "ORDER BY a.name ASC";
                $query = mysqli_query($con, $sql);
                $total = mysqli_num_rows($query);
                if (mysqli_num_rows($query)) {
                    $html .= '<table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>

                <th style="padding:5px">Matrícula</th>

                <th style="padding:5px">Nome</th>

            </tr>
            </thead>
            <tbody>';
                    $key = 0;
                    while ($alunos = mysqli_fetch_object($query)) {
                        $html .= '<tr>

                    <td style="padding:5px">' . $alunos->registration . '</td>

                    <td style="padding:5px">' . ($alunos->name) . '</td>
                </tr>';
                        $key++;
                    }
                    $paginacaoAnterior = ($_REQUEST['pagina'] == 1) ? 1 : $_REQUEST['pagina'] - 1;
                    $html .= '</tbody></table>|-|';
                } else {
                    $html = '<div style="text-align:center; background-color:#FF0000; color:#FFFFFF; padding:5px; width:100%">Sem nenhum registro encontrado!</div>';
                }
                break;
            case 'versao':
                $sql = "SELECT a.* FROM versions a ";
                if ($_REQUEST['nomeFiltro']) {
                    $sql .= "WHERE a.name LIKE '%" . $_REQUEST['nomeFiltro'] . "%' ";
                    $where = 1;
                }
                $sql .= "ORDER BY a.id ASC";
                $query = mysqli_query($con, $sql);
                $total = mysqli_num_rows($query);
                $offSet = $_REQUEST['pagina'] < 1 ? 0 : ((15 * ($_REQUEST['pagina'] - 1) > $total) ? $total - ($total % 15) : 15 * ($_REQUEST['pagina'] - 1));
                $totalPaginacao = ceil($total / 15);
                if ($totalPaginacao == $_REQUEST['pagina']) {
                    $paginacaoProxima = $_REQUEST['pagina'];
                } elseif ($totalPaginacao > 1) {
                    $paginacaoProxima = $_REQUEST['pagina'] + 1;
                } else {
                    $paginacaoAnterior = 1;
                }
                if ($_REQUEST['pagina'] <= 10) {
                    $inicial = 1;
                } else {
                    $inicial = ((ceil($_REQUEST['pagina'] / 10) - 1) * 10) + 1;
                }
                $final = $inicial + 10;
                $sql .= " LIMIT " . $offSet . ", 15";
                $query = mysqli_query($con, $sql);
                if (mysqli_num_rows($query)) {
                    $html .= '<table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>

                <th style="padding:5px">ID</th>

                <th style="padding:5px">Nome</th>

                <th style="padding:5px">Ações</th>

            </tr>
            </thead>';
                    $key = 0;
                    while ($parametroAdmin = mysqli_fetch_object($query)) {
                        $html .= '<tr>

                    <td style="padding:5px">' . $parametroAdmin->id . '</td>

                    <td style="padding:5px">' . ($parametroAdmin->name) . '</td>

                    <td style="padding:5px">
                         <a href="#" data-toggle="modal" data-target="#modalVisualizacao" onclick=visualizarVersao("' . $parametroAdmin->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/visualizar.svg" width="20"></a>
                         <a href="#" data-toggle="modal" data-target="#modalEdicao" onclick=editarVersao("' . $parametroAdmin->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/editar.png" width="20"></a>
                        <a style="cursor:pointer" onclick=excluirVersao("' . $parametroAdmin->id . '","' . URL . '","' . $_REQUEST['idUser'] . '","a","versao")><img src="' . URL . 'img/excluir.png" width="20"></a>
                    </td>
                </tr>';
                        $key++;
                    }
                    $paginacaoAnterior = ($_REQUEST['pagina'] == 1) ? 1 : $_REQUEST['pagina'] - 1;
                    $html .= '</tbody></table>|-|<div class="card-header">
                <h3 class="card-title">
                  <i class="ion pagination mr-1"></i>
                  Paginação
                </h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm" style="width:100%; text-align:center">
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("versao","' . URL . '","' . $_REQUEST['idUser'] . '","1")>&laquo;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("versao","' . URL . '","' . $_REQUEST['idUser'] . '","' . $paginacaoAnterior . '")>&leftarrow;</a></li>
                        ';
                    $background = ($_REQUEST['pagina'] == 1) ? "#cccccc" : "";
                    $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("versao","' . URL . '","' . $_REQUEST['idUser'] . '","1")>1</a></li>';
                    if ($_REQUEST['pagina'] >= 11) {
                        $proxima2 = $inicial - 1;
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("versao","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>
                   ';
                    }
                    for ($j = $inicial; $j < $final; $j++) {
                        if ($j < $totalPaginacao && $j > 1) {
                            $background = ($_REQUEST['pagina'] == $j) ? "#cccccc" : "";
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("versao","' . URL . '","' . $_REQUEST['idUser'] . '","' . $j . '")>' . $j . '</a></li>
                        ';
                        }
                    }
                    if ($totalPaginacao > 11) {
                        $vaiAte = (floor($totalPaginacao / 10)) * 10;
                        if ($vaiAte >= $_REQUEST['pagina']) {
                            $proxima2 = $final;
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("versao","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>';
                        }
                    }
                    if ($totalPaginacao > 1) {
                        $background = ($_REQUEST['pagina'] == $totalPaginacao) ? "#cccccc" : "";
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("versao","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>' . $totalPaginacao . '</a></li>
                   ';
                        $proxima = $_REQUEST['pagina'] + 1;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    } else {
                        $proxima = 2;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    }
                    $html .= '
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("versao","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima . '")>&rightarrow;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("versao","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>&raquo;</a></li>
                   </ul></div>
                    </div>
                    </div>';
                } else {
                    $html = '<div style="text-align:center; background-color:#FF0000; color:#FFFFFF; padding:5px; width:100%">Sem nenhum registro encontrado!</div>';
                }
                break;
            case 'usuarios':
                $sql = "SELECT a.* FROM users a ";
                if ($_REQUEST['nomeFiltro']) {
                    $sql .= "WHERE a.name LIKE '%" . $_REQUEST['nomeFiltro'] . "%' ";
                    $where = 1;
                }
                if ($_REQUEST['emailFiltro']) {
                    if ($where) {
                        $sql .= "AND ";
                    } else {
                        $sql .= "WHERE ";
                    }
                    $sql .= "a.email = '" . $_REQUEST['emailFiltro'] . "' ";
                    $where = 1;
                }
                if ($_REQUEST['idUser'] != 1) {
                    if ($where) {
                        $sql .= "AND ";
                    } else {
                        $sql .= "WHERE ";
                    }
                    $sql .= "a.id = '" . $_REQUEST['idUser'] . "' ";
                    $where = 1;
                }
                $sql .= "ORDER BY a.id ASC";
                $query = mysqli_query($con, $sql);
                $total = mysqli_num_rows($query);
                $offSet = $_REQUEST['pagina'] < 1 ? 0 : ((15 * ($_REQUEST['pagina'] - 1) > $total) ? $total - ($total % 15) : 15 * ($_REQUEST['pagina'] - 1));
                $totalPaginacao = ceil($total / 15);
                if ($totalPaginacao == $_REQUEST['pagina']) {
                    $paginacaoProxima = $_REQUEST['pagina'];
                } elseif ($totalPaginacao > 1) {
                    $paginacaoProxima = $_REQUEST['pagina'] + 1;
                } else {
                    $paginacaoAnterior = 1;
                }
                if ($_REQUEST['pagina'] <= 10) {
                    $inicial = 1;
                } else {
                    $inicial = ((ceil($_REQUEST['pagina'] / 10) - 1) * 10) + 1;
                }
                $final = $inicial + 10;
                $sql .= " LIMIT " . $offSet . ", 15";
                $query = mysqli_query($con, $sql);
                if (mysqli_num_rows($query)) {
                    $html .= '<table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>

                <th style="padding:5px">ID</th>

                <th style="padding:5px">Nome</th>

                <th style="padding:5px">Email</th>

                <th style="padding:5px">Ações</th>

            </tr>
            </thead>
            <tbody>';
                    $key = 0;
                    while ($usuarios = mysqli_fetch_object($query)) {
                        $html .= '<tr>

                    <td style="padding:5px">' . $usuarios->id . '</td>

                    <td style="padding:5px">' . ($usuarios->name) . '</td>

                    <td style="padding:5px">' . ($usuarios->email) . '</td>

                    <td style="padding:5px">
                         <a href="#" data-toggle="modal" data-target="#modalVisualizacao" onclick=visualizarUsuarios("' . $usuarios->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/visualizar.svg" width="20"></a>
                         <a href="#" data-toggle="modal" data-target="#modalEdicao" onclick=editarUsuarios("' . $usuarios->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/editar.png" width="20"></a>
                        <a style="cursor:pointer" onclick=excluirUsuarios("' . $usuarios->id . '","' . URL . '","' . $_REQUEST['idUser'] . '","o","usuário")><img src="' . URL . 'img/excluir.png" width="20"></a>
                    </td>

                </tr>';
                        $key++;
                    }
                    $paginacaoAnterior = ($_REQUEST['pagina'] == 1) ? 1 : $_REQUEST['pagina'] - 1;
                    $html .= '</tbbody></table>|-|<div class="card-header">
                <h3 class="card-title">
                  <i class="ion pagination mr-1"></i>
                  Paginação
                </h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm" style="width:100%; text-align:center">
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("usuarios","\'' . URL . '","' . $_REQUEST['idUser'] . '","1")>&laquo;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("usuarios","' . URL . '","' . $_REQUEST['idUser'] . '","' . $paginacaoAnterior . '")>&leftarrow;</a></li>
                        ';
                    $background = ($_REQUEST['pagina'] == 1) ? "#cccccc" : "";
                    $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("usuarios","' . URL . '","' . $_REQUEST['idUser'] . '","1")>1</a></li>';
                    if ($_REQUEST['pagina'] >= 11) {
                        $proxima2 = $inicial - 1;
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("usuarios","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>
                   ';
                    }
                    for ($j = $inicial; $j < $final; $j++) {
                        if ($j < $totalPaginacao && $j > 1) {
                            $background = ($_REQUEST['pagina'] == $j) ? "#cccccc" : "";
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("usuarios","' . URL . '","' . $_REQUEST['idUser'] . '","' . $j . '")>' . $j . '</a></li>
                        ';
                        }
                    }
                    if ($totalPaginacao > 11) {
                        $vaiAte = (floor($totalPaginacao / 10)) * 10;
                        if ($vaiAte >= $_REQUEST['pagina']) {
                            $proxima2 = $final;
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("usuarios","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>';
                        }
                    }
                    if ($totalPaginacao > 1) {
                        $background = ($_REQUEST['pagina'] == $totalPaginacao) ? "#cccccc" : "";
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("usuarios","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>' . $totalPaginacao . '</a></li>
                   ';
                        $proxima = $_REQUEST['pagina'] + 1;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    } else {
                        $proxima = 2;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    }
                    $html .= '
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("usuarios","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima . '")>&rightarrow;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("usuarios","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>&raquo;</a></li>
                   </ul></div>
                    </div>
                    </div>';
                } else {
                    $html = '<div style="text-align:center; background-color:#FF0000; color:#FFFFFF; padding:5px; width:100%">Sem nenhum registro encontrado!</div>';
                }
                break;
            case 'usuarios-pre':
                $sql = "SELECT a.* FROM user_pres a ";
                if ($_REQUEST['nomeFiltro']) {
                    $sql .= "WHERE a.name LIKE '%" . $_REQUEST['nomeFiltro'] . "%' ";
                    $where = 1;
                }
                if ($_REQUEST['emailFiltro']) {
                    if ($where) {
                        $sql .= "AND ";
                    } else {
                        $sql .= "WHERE ";
                    }
                    $sql .= "a.email = '" . $_REQUEST['emailFiltro'] . "' ";
                    $where = 1;
                }
                $sql .= "ORDER BY a.id ASC";
                $query = mysqli_query($con, $sql);
                $total = mysqli_num_rows($query);
                $offSet = $_REQUEST['pagina'] < 1 ? 0 : ((15 * ($_REQUEST['pagina'] - 1) > $total) ? $total - ($total % 15) : 15 * ($_REQUEST['pagina'] - 1));
                $totalPaginacao = ceil($total / 15);
                if ($totalPaginacao == $_REQUEST['pagina']) {
                    $paginacaoProxima = $_REQUEST['pagina'];
                } elseif ($totalPaginacao > 1) {
                    $paginacaoProxima = $_REQUEST['pagina'] + 1;
                } else {
                    $paginacaoAnterior = 1;
                }
                if ($_REQUEST['pagina'] <= 10) {
                    $inicial = 1;
                } else {
                    $inicial = ((ceil($_REQUEST['pagina'] / 10) - 1) * 10) + 1;
                }
                $final = $inicial + 10;
                $sql .= " LIMIT " . $offSet . ", 15";
                $query = mysqli_query($con, $sql);
                if (mysqli_num_rows($query)) {
                    $html .= '<table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>

                <th style="padding:5px">ID</th>

                <th style="padding:5px">Nome</th>

                <th style="padding:5px">Email</th>

                <th style="padding:5px">Ações</th>

            </tr>
            </thead>
            <tbody>';
                    $key = 0;
                    while ($usuarios = mysqli_fetch_object($query)) {
                        $html .= '<tr>

                    <td style="padding:5px">' . $usuarios->id . '</td>

                    <td style="padding:5px">' . ($usuarios->name) . '</td>

                    <td style="padding:5px">' . ($usuarios->email) . '</td>

                    <td style="padding:5px">
                         <a href="#" onclick=aprovaUsuario("'.$usuarios->id.'","'.URL.'","'.$_SESSION['user']['id'].'")><img src="' . URL . 'img/sucesso.png" width="20"></a>
                         <a href="#" data-toggle="modal" data-target="#modalVisualizacao" onclick=visualizarUsuariosPre("' . $usuarios->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/visualizar.svg" width="20"></a>
                         <a href="#" data-toggle="modal" data-target="#modalEdicao" onclick=editarUsuariosPre("' . $usuarios->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/editar.png" width="20"></a>
                        <a style="cursor:pointer" onclick=excluirUsuariosPre("' . $usuarios->id . '","' . URL . '","' . $_REQUEST['idUser'] . '","o","usuário_pre")><img src="' . URL . 'img/excluir.png" width="20"></a>
                    </td>

                </tr>';
                        $key++;
                    }
                    $paginacaoAnterior = ($_REQUEST['pagina'] == 1) ? 1 : $_REQUEST['pagina'] - 1;
                    $html .= '</tbbody></table>|-|<div class="card-header">
                <h3 class="card-title">
                  <i class="ion pagination mr-1"></i>
                  Paginação
                </h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm" style="width:100%; text-align:center">
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("usuarios-pre","\'' . URL . '","' . $_REQUEST['idUser'] . '","1")>&laquo;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("usuarios-pre","' . URL . '","' . $_REQUEST['idUser'] . '","' . $paginacaoAnterior . '")>&leftarrow;</a></li>
                        ';
                    $background = ($_REQUEST['pagina'] == 1) ? "#cccccc" : "";
                    $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("usuarios-pre","' . URL . '","' . $_REQUEST['idUser'] . '","1")>1</a></li>';
                    if ($_REQUEST['pagina'] >= 11) {
                        $proxima2 = $inicial - 1;
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("usuarios-pre","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>
                   ';
                    }
                    for ($j = $inicial; $j < $final; $j++) {
                        if ($j < $totalPaginacao && $j > 1) {
                            $background = ($_REQUEST['pagina'] == $j) ? "#cccccc" : "";
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("usuarios-pre","' . URL . '","' . $_REQUEST['idUser'] . '","' . $j . '")>' . $j . '</a></li>
                        ';
                        }
                    }
                    if ($totalPaginacao > 11) {
                        $vaiAte = (floor($totalPaginacao / 10)) * 10;
                        if ($vaiAte >= $_REQUEST['pagina']) {
                            $proxima2 = $final;
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("usuarios-pre","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>';
                        }
                    }
                    if ($totalPaginacao > 1) {
                        $background = ($_REQUEST['pagina'] == $totalPaginacao) ? "#cccccc" : "";
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("usuarios-pre","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>' . $totalPaginacao . '</a></li>
                   ';
                        $proxima = $_REQUEST['pagina'] + 1;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    } else {
                        $proxima = 2;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    }
                    $html .= '
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("usuarios-pre","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima . '")>&rightarrow;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("usuarios-pre","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>&raquo;</a></li>
                   </ul></div>
                    </div>
                    </div>';
                } else {
                    $html = '<div style="text-align:center; background-color:#FF0000; color:#FFFFFF; padding:5px; width:100%">Sem nenhum registro encontrado!</div>';
                }
                break;
            case 'tipoModulo':
                $sql = "SELECT a.* FROM type_modules a ";
                if ($_REQUEST['nomeFiltro']) {
                    $sql .= "WHERE a.name LIKE '%" . $_REQUEST['nomeFiltro'] . "%' ";
                    $where = 1;
                }
                $sql .= "ORDER BY a.id ASC";
                $query = mysqli_query($con, $sql);
                $total = mysqli_num_rows($query);
                $offSet = $_REQUEST['pagina'] < 1 ? 0 : ((15 * ($_REQUEST['pagina'] - 1) > $total) ? $total - ($total % 15) : 15 * ($_REQUEST['pagina'] - 1));
                $totalPaginacao = ceil($total / 15);
                if ($totalPaginacao == $_REQUEST['pagina']) {
                    $paginacaoProxima = $_REQUEST['pagina'];
                } elseif ($totalPaginacao > 1) {
                    $paginacaoProxima = $_REQUEST['pagina'] + 1;
                } else {
                    $paginacaoAnterior = 1;
                }
                if ($_REQUEST['pagina'] <= 10) {
                    $inicial = 1;
                } else {
                    $inicial = ((ceil($_REQUEST['pagina'] / 10) - 1) * 10) + 1;
                }
                $final = $inicial + 10;
                $sql .= " LIMIT " . $offSet . ", 15";
                $query = mysqli_query($con, $sql);
                if (mysqli_num_rows($query)) {
                    $html .= '<table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                <th style="padding:5px">ID</th>

                <th style="padding:5px">Nome</th>

                <th style="padding:5px">Ações</th>

            </tr>
            </thead>
            <tbody>';
                    $key = 0;
                    while ($tipoModulo = mysqli_fetch_object($query)) {
                        $html .= '<tr>

                    <td style="padding:5px">' . $tipoModulo->id . '</td>

                    <td style="padding:5px">' . ($tipoModulo->name) . '</td>

                    <td style="padding:5px">
                         <a href="#" data-toggle="modal" data-target="#modalVisualizacao" onclick=visualizarTipoModulo("' . $tipoModulo->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/visualizar.svg" width="20"></a>
                         <a href="#" data-toggle="modal" data-target="#modalEdicao" onclick=editarTipoModulo("' . $tipoModulo->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/editar.png" width="20"></a>
                        <a style="cursor:pointer" onclick=excluirTipoModulo("' . $tipoModulo->id . '","' . URL . '","' . $_REQUEST['idUser'] . '","o","tipoModulo")><img src="' . URL . 'img/excluir.png" width="20"></a>
                    </td>
                </tr>';
                        $key++;
                    }
                    $paginacaoAnterior = ($_REQUEST['pagina'] == 1) ? 1 : $_REQUEST['pagina'] - 1;
                    $html .= '</tbbody></table>|-|<div class="card-header">
                <h3 class="card-title">
                  <i class="ion pagination mr-1"></i>
                  Paginação
                </h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm" style="width:100%; text-align:center">
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("tipoModulo","\'' . URL . '","' . $_REQUEST['idUser'] . '","1")>&laquo;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("tipoModulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $paginacaoAnterior . '")>&leftarrow;</a></li>
                        ';
                    $background = ($_REQUEST['pagina'] == 1) ? "#cccccc" : "";
                    $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("tipoModulo","' . URL . '","' . $_REQUEST['idUser'] . '","1")>1</a></li>';
                    if ($_REQUEST['pagina'] >= 11) {
                        $proxima2 = $inicial - 1;
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("tipoModulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>
                   ';
                    }
                    for ($j = $inicial; $j < $final; $j++) {
                        if ($j < $totalPaginacao && $j > 1) {
                            $background = ($_REQUEST['pagina'] == $j) ? "#cccccc" : "";
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("tipoModulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $j . '")>' . $j . '</a></li>
                        ';
                        }
                    }
                    if ($totalPaginacao > 11) {
                        $vaiAte = (floor($totalPaginacao / 10)) * 10;
                        if ($vaiAte >= $_REQUEST['pagina']) {
                            $proxima2 = $final;
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("tipoModulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>';
                        }
                    }
                    if ($totalPaginacao > 1) {
                        $background = ($_REQUEST['pagina'] == $totalPaginacao) ? "#cccccc" : "";
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("tipoModulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>' . $totalPaginacao . '</a></li>
                   ';
                        $proxima = $_REQUEST['pagina'] + 1;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    } else {
                        $proxima = 2;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    }
                    $html .= '
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("tipoModulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima . '")>&rightarrow;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("tipoModulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>&raquo;</a></li>
                   </ul></div>
                    </div>
                    </div>';
                } else {
                    $html = '<div style="text-align:center; background-color:#FF0000; color:#FFFFFF; padding:5px; width:100%">Sem nenhum registro encontrado!</div>';
                }
                break;
            case 'modulo':
                $sql = "SELECT a.*, b.name AS nomeTipoModulo FROM modules a INNER JOIN type_modules b ON (a.typeModule = b.id) ";
                if ($_REQUEST['nomeFiltro']) {
                    $sql .= "WHERE a.name LIKE '%" . $_REQUEST['nomeFiltro'] . "%' ";
                    $where = 1;
                }
                if ($_REQUEST['tipoModuloFiltro']) {
                    if ($where){
                        $sql .= "AND ";
                    }
                    else{
                        $sql .= "WHERE ";
                    }
                    $sql .= "a.typeModule = '" . $_REQUEST['tipoModuloFiltro'] . "' ";
                    $where = 1;
                }
                $sql .= "ORDER BY a.typeModule ASC, a.id ASC";
                $query = mysqli_query($con, $sql);
                $total = mysqli_num_rows($query);
                $offSet = $_REQUEST['pagina'] < 1 ? 0 : ((15 * ($_REQUEST['pagina'] - 1) > $total) ? $total - ($total % 15) : 15 * ($_REQUEST['pagina'] - 1));
                $totalPaginacao = ceil($total / 15);
                if ($totalPaginacao == $_REQUEST['pagina']) {
                    $paginacaoProxima = $_REQUEST['pagina'];
                } elseif ($totalPaginacao > 1) {
                    $paginacaoProxima = $_REQUEST['pagina'] + 1;
                } else {
                    $paginacaoAnterior = 1;
                }
                if ($_REQUEST['pagina'] <= 10) {
                    $inicial = 1;
                } else {
                    $inicial = ((ceil($_REQUEST['pagina'] / 10) - 1) * 10) + 1;
                }
                $final = $inicial + 10;
                $sql .= " LIMIT " . $offSet . ", 15";
                $query = mysqli_query($con, $sql);
                if (mysqli_num_rows($query)) {
                        $html .= '<table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>

                <th style="padding:5px">ID</th>

                <th style="padding:5px">Tipo de Módulo</th>
                <th style="padding:5px">Nome</th>

                <th style="padding:5px">Ações</th>

            </tr>
            </thead>
            <tbody>';
                    ;$key = 0;
                    while ($modulo = mysqli_fetch_object($query)) {
                        $html .= '<tr>

                    <td style="padding:5px">' . $modulo->id . '</td>

                    <td style="padding:5px">' . ($modulo->nomeTipoModulo) . '</td>

                    <td style="padding:5px">' . ($modulo->name) . '</td>

                    <td style="padding:5px">
                         <a href="#" data-toggle="modal" data-target="#modalVisualizacao" onclick=visualizarModulo("' . $modulo->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/visualizar.svg" width="20"></a>
                         <a href="#" data-toggle="modal" data-target="#modalEdicao" onclick=editarModulo("' . $modulo->id . '","' . URL . '","' . $_REQUEST['idUser'] . '")><img src="' . URL . 'img/editar.png" width="20"></a>
                        <a style="cursor:pointer" onclick=excluirModulo("' . $modulo->id . '","' . URL . '","' . $_REQUEST['idUser'] . '","o","modulo")><img src="' . URL . 'img/excluir.png" width="20"></a>
                    </td>
                </tr>';
                        $key++;
                    }
                    $html .= '</tbbody></table>|-|<div class="card-header">
                <h3 class="card-title">
                  <i class="ion pagination mr-1"></i>
                  Paginação
                </h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm" style="width:100%; text-align:center">
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("modulo","\'' . URL . '","' . $_REQUEST['idUser'] . '","1")>&laquo;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("modulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $paginacaoAnterior . '")>&leftarrow;</a></li>
                        ';
                        $background = ($_REQUEST['pagina'] == 1) ? "#cccccc" : "";
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("modulo","' . URL . '","' . $_REQUEST['idUser'] . '","1")>1</a></li>';
                        if ($_REQUEST['pagina'] >= 11) {
                            $proxima2 = $inicial - 1;
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("modulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>
                   ';
                        }
                        for ($j = $inicial; $j < $final; $j++) {
                            if ($j < $totalPaginacao && $j > 1) {
                                $background = ($_REQUEST['pagina'] == $j) ? "#cccccc" : "";
                                $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("modulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $j . '")>' . $j . '</a></li>
                        ';
                            }
                        }
                        if ($totalPaginacao > 11) {
                            $vaiAte = (floor($totalPaginacao / 10)) * 10;
                            if ($vaiAte >= $_REQUEST['pagina']) {
                                $proxima2 = $final;
                                $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("modulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>';
                            }
                        }
                        if ($totalPaginacao > 1) {
                            $background = ($_REQUEST['pagina'] == $totalPaginacao) ? "#cccccc" : "";
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("modulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>' . $totalPaginacao . '</a></li>
                   ';
                            $proxima = $_REQUEST['pagina'] + 1;
                            if ($proxima > $totalPaginacao) {
                                $proxima = $totalPginacao;
                            }
                        } else {
                            $proxima = 2;
                            if ($proxima > $totalPaginacao) {
                                $proxima = $totalPginacao;
                            }
                        }
                        $html .= '
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("modulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima . '")>&rightarrow;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("modulo","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>&raquo;</a></li>
                   </ul></div>
                    </div>
                    </div>';
                } else {
                    $html = '<div style="text-align:center; background-color:#FF0000; color:#FFFFFF; padding:5px; width:100%">Sem nenhum registro encontrado!</div>';
                }
                break;
            case 'logs':
                $sql = "SELECT a.*, b.name AS nomeUsuario FROM logs a INNER JOIN users b ON (a.user = b.id) ";
                if ($_REQUEST['usuarioFiltro']) {
                    $sql .= "WHERE a.user = '" . $_REQUEST['usuarioFiltro'] . "' ";
                    $where = 1;
                }
                if ($_REQUEST['acaoFiltro']) {
                    if ($where) {
                        $sql .= "AND ";
                    } else {
                        $sql .= "WHERE ";
                    }
                    $sql .= "a.action LIKE '%" . $_REQUEST['acaoFiltro'] . "%' ";
                    $where = 1;
                }
                if ($_REQUEST['idUser'] != 1) {
                    if ($where) {
                        $sql .= "AND ";
                    } else {
                        $sql .= "WHERE ";
                    }
                    $sql .= "a.user = '" . $_REQUEST['idUser'] . "' ";
                    $where = 1;
                }
                $sql .= "ORDER BY a.id DESC";
                $query = mysqli_query($con, $sql);
                $total = mysqli_num_rows($query);
                $offSet = $_REQUEST['pagina'] < 1 ? 0 : ((15 * ($_REQUEST['pagina'] - 1) > $total) ? $total - ($total % 15) : 15 * ($_REQUEST['pagina'] - 1));
                $totalPaginacao = ceil($total / 15);
                if ($totalPaginacao == $_REQUEST['pagina']) {
                    $paginacaoProxima = $_REQUEST['pagina'];
                } elseif ($totalPaginacao > 1) {
                    $paginacaoProxima = $_REQUEST['pagina'] + 1;
                } else {
                    $paginacaoAnterior = 1;
                }
                if ($_REQUEST['pagina'] <= 10) {
                    $inicial = 1;
                } else {
                    $inicial = ((ceil($_REQUEST['pagina'] / 10) - 1) * 10) + 1;
                }
                $final = $inicial + 10;
                $sql .= " LIMIT " . $offSet . ", 15";
                $query = mysqli_query($con, $sql);
                if (mysqli_num_rows($query)) {
                    $html .= '<table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Nome do Usuário</th>
                                    <th>Ação</th>
                                    <th>Data / Hora</th>
                                </tr>
                                </thead>
                                <tbody>';
                    $key = 0;
                    while ($usuarios = mysqli_fetch_object($query)) {
                        $vet = explode(' ', $usuarios->created_at);
                        $vet2 = explode('-', $vet[0]);
                        $usuarios->created_at = $vet2[2]."/".$vet2[1]."/".$vet2[0]." às ".$vet[1]."h";
                        $html .= '<tr>

                    <td style="padding:5px">' . ($usuarios->nomeUsuario) . '</td>

                    <td style="padding:5px">' . ($usuarios->action) . '</td>

                    <td style="padding:5px">' . ($usuarios->created_at) . '</td>

                </tr>';
                        $key++;
                    }
                    $paginacaoAnterior = ($_REQUEST['pagina'] == 1) ? 1 : $_REQUEST['pagina'] - 1;
                    $html .= '</table>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ion pagination mr-1"></i>
                  Paginação
                </h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm" style="width:100%; text-align:center">
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("logs","' . URL . '","' . $_REQUEST['idUser'] . '","1")>&laquo;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("logs","' . URL . '","' . $_REQUEST['idUser'] . '","' . $paginacaoAnterior . '")>&leftarrow;</a></li>
                        ';
                    $background = ($_REQUEST['pagina'] == 1) ? "#CCCCCC" : "";
                    $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("logs","' . URL . '","' . $_REQUEST['idUser'] . '","1")>1</a></li>';
                    if ($_REQUEST['pagina'] >= 11) {
                        $proxima2 = $inicial - 1;
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("logs","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>
                   ';
                    }
                    for ($j = $inicial; $j < $final; $j++) {
                        if ($j < $totalPaginacao && $j > 1) {
                            $background = ($_REQUEST['pagina'] == $j) ? "#CCCCCC" : "";
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("logs","' . URL . '","' . $_REQUEST['idUser'] . '","' . $j . '")>' . $j . '</a></li>
                        ';
                        }
                    }
                    if ($totalPaginacao > 11) {
                        $vaiAte = (floor($totalPaginacao / 10)) * 10;
                        if ($vaiAte >= $_REQUEST['pagina']) {
                            $proxima2 = $final;
                            $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("logs","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima2 . '")>...</a></li>';
                        }
                    }
                    if ($totalPaginacao > 1) {
                        $background = ($_REQUEST['pagina'] == $totalPaginacao) ? "#CCCCCC" : "";
                        $html .= '<li class="page-item"><a class="page-link" style="cursor:pointer; background-color: '.$background.'" onClick=verificaNovamente("logs","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>' . $totalPaginacao . '</a></li>
                   ';
                        $proxima = $_REQUEST['pagina'] + 1;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    } else {
                        $proxima = 2;
                        if ($proxima > $totalPaginacao) {
                            $proxima = $totalPginacao;
                        }
                    }
                    $html .= '
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("logs","' . URL . '","' . $_REQUEST['idUser'] . '","' . $proxima . '")>&rightarrow;</a></li>
                        <li class="page-item"><a class="page-link" style="cursor:pointer" onClick=verificaNovamente("logs","' . URL . '","' . $_REQUEST['idUser'] . '","' . $totalPaginacao . '")>&raquo;</a></li>
                   </ul></div>
                    </div>
                    </div>';
                } else {
                    $html = '<div style="text-align:center; background-color:#FF0000; color:#FFFFFF; padding:5px; width:100%">Sem nenhum registro encontrado!</div>';
                }
                break;
        }
        echo "1|-|".$html;
        break;
    case "editaProdutoPedido":
        $sql = "SELECT * FROM requests_items WHERE id = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        echo "1|-|".$row['product']."|-|".$row['product_item']."|-|".$row['id'];
        break;
    case "excluirItemPedido":
        $sql = "DELETE FROM requests_items WHERE id = '".$_REQUEST['id']."'";
        mysqli_query($con, $sql);
        echo "1";
        break;
    case "incluirItemPedido":
        $sql = "SELECT * FROM products_items WHERE id = '".$_REQUEST['product_item']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        $valor = ($row['promotion'] && $row['validity_promotion'] > date('Y-m-d')) ? $row['promotion'] : $row['value'];
        $sql = "INSERT INTO requests_items (request, product, product_item, name, domine, quantity, value, created_at, updated_at) VALUES ('".$_REQUEST['request']."', '".$_REQUEST['product']."', '".$_REQUEST['product_item']."', '".$row['name']."', '".$_REQUEST['domine']."', '1', '".$valor."', now(), now())";
        mysqli_query($con, $sql);
        $idRequestItem = mysqli_insert_id($con);
        if ($_REQUEST['product'] == 3){
            $sql = "INSERT INTO cashier_system (razao_social, nome_fantasia, email, cnpj, cep, logradouro, numero, complemento, bairro, cidade, estado, tipoEstabelecimento, quantidade, numeroPessoasPorMesa, percentual) VALUES ('".$_REQUEST['razaoSocial']."', '".$_REQUEST['nomeFantasia']."', '".$_REQUEST['email']."', '".$_REQUEST['cnpj']."', '".$_REQUEST['cep']."', '".$_REQUEST['logradouro']."', '".$_REQUEST['numero']."', '".$_REQUEST['complemento']."', '".$_REQUEST['bairro']."', '".$_REQUEST['cidade']."', '".$_REQUEST['estado']."', '".$_REQUEST['tipoEstabelecimento']."', '".$_REQUEST['quantidade']."', '".$_REQUEST['numPessoas']."', '".$_REQUEST['perGarcom']."')";
            mysqli_query($con, $sql);
            $idSistemaCaixa = mysqli_insert_id($con);
            $sql = "UPDATE requests_items SET cashier_system = '".$idSistemaCaixa."' WHERE id = '".$idRequestItem."'";
            mysqli_query($con, $sql);
        }
        if ($_REQUEST['product'] == 4){
            $sql = "INSERT INTO school_system (nome, email, cep, logradouro, numero, complemento, bairro, cidade, estado, tipoNota, turno, letra) VALUES ('".$_REQUEST['nome']."', '".$_REQUEST['email']."', '".$_REQUEST['cep']."', '".$_REQUEST['logradouro']."', '".$_REQUEST['numero']."', '".$_REQUEST['complemento']."', '".$_REQUEST['bairro']."', '".$_REQUEST['cidade']."', '".$_REQUEST['estado']."', '".$_REQUEST['tipoNota']."', '".$_REQUEST['turno']."', '".$_REQUEST['letra']."')";
            mysqli_query($con, $sql);
            $idSistemaEscola = mysqli_insert_id($con);
            $sql = "UPDATE requests_items SET school_system = '".$idSistemaEscola."' WHERE id = '".$idRequestItem."'";
            mysqli_query($con, $sql);
        }
        echo "1";
        break;
    case "editarItemPedido":
        $sql = "SELECT * FROM products_items WHERE id = '".$_REQUEST['product_item']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        $valor = ($row['promotion'] && $row['validity_promotion'] > date('Y-m-d')) ? $row['promotion'] : $row['value'];
        $sql = "UPDATE requests_items SET product = '".$_REQUEST['product']."', product_item = '".$_REQUEST['product_item']."', name = '".$row['name']."', domine = '".$_REQUEST['domine']."', quantity = '1', value = '".$valor."', updated_at = now() WHERE id = '".$_REQUEST['id']."'";
        mysqli_query($con, $sql);
        echo "1";
        break;
    case "productItemCadastro":
        $sql = "SELECT * FROM products_items WHERE id = '".$_REQUEST['id']."' ";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        if ($row['product'] != 3 && $row['product'] != 4) {
            $html .= "<label for='domineCadastro'>Domínio:</label><input type='text' name='domineCadastro' id='domineCadastro' required class='form-control'>";
        }
        elseif ($row['product'] == 3){
            $html .= "
            <label for='razaoSocialCaixa'>Razão Social:</label>
            <input type='text' name='razaoSocialCaixa' id='razaoSocialCaixa' required class='form-control'>
            <label for='nomeFantasiaCaixa'>Nome Fantasia:</label>
            <input type='text' name='nomeFantasiaCaixa' id='nomeFantasiaCaixa' required class='form-control'>
            <label for='emailCaixa'>Email:</label>
            <input type='email' name='emailCaixa' id='emailCaixa' required class='form-control'>
            <label for='cnpjCaixa'>CNPJ:</label>
            <input type='text' name='cnpjCaixa' id='cnpjCaixa' required class='form-control' onkeypress=\"return mascara(this, '00.000.000/0000-00', event)\">
            <label for='cepCaixa'>CEP:</label>
            <input type='text' name='cepCaixa' id='cepCaixa' required class='form-control' onkeypress=\"return mascara(this, '00000-000', event)\" onkeyup=\"verificacepcaixa(this.value)\">
            <label for='logradouroCaixa'>Logradouro:</label>
            <input type='text' name='logradouroCaixa' id='logradouroCaixa' required class='form-control'>
            <label for='numeroCaixa'>Numero:</label>
            <input type='text' name='numeroCaixa' id='numeroCaixa' required class='form-control'>
            <label for='complementoCaixa'>Complemento:</label>
            <input type='text' name='complementoCaixa' id='complementoCaixa' class='form-control'>
            <label for='bairroCaixa'>Bairro:</label>
            <input type='text' name='bairroCaixa' id='bairroCaixa' required class='form-control'>
            <label for='cidadeCaixa'>Cidade:</label>
            <input type='text' name='cidadeCaixa' id='cidadeCaixa' required class='form-control'>
            <label for='estadoCaixa'>Estado:</label>
            <select name='estadoCaixa' id='estadoCaixa' required class='form-control'>
                <option value=''>Selecione o estado corretamente...</option>";
            $sql = "SELECT * FROM states ORDER BY sigla ASC";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query)){
                while ($row = mysqli_fetch_array($query)){
                    $html .= "<option value='".$row['sigla']."'>".$row['sigla']."</option>";
                }
            }
            $html .="
            </select>
            <label for='tipoEstabelecimentoCaixa'>Tipo do Estabelecimento:</label>
            <select name='tipoEstabelecimentoCaixa' id='tipoEstabelecimentoCaixa' required class='form-control' onchange='selecionaTipoEstabelecimento(this.value)'>
                <option value=''>Selecione o tipo do estabelecimento corretamente...</option>
                <option value='1'>Mesas</option>
                <option value='2'>Caixas</option>
            </select>
            <div id='tiposEstabelecimentoRealizarPedido'></div>";
        }
        elseif ($row['product'] == 4){
            $html .= "
            <label for='nomeEscola'>Nome da Escola:</label>
            <input type='text' name='nomeEscola' id='nomeEscola' required class='form-control'>
            <label for='emailEscola'>Email da Escola:</label>
            <input type='text' name='emailEscola' id='emailEscola' required class='form-control'>
            <label for='cepEscola'>CEP:</label>
            <input type='text' name='cepEscola' id='cepEscola' required class='form-control' onkeypress=\"return mascara(this, '00000-000', event)\" onkeyup=\"verificacepescolar(this.value)\">
            <label for='logradouroEscola'>Logradouro:</label>
            <input type='text' name='logradouroEscola' id='logradouroEscola' required class='form-control'>
            <label for='numeroEscola'>Numero:</label>
            <input type='text' name='numeroEscola' id='numeroEscola' required class='form-control'>
            <label for='complementoEscola'>Complemento:</label>
            <input type='text' name='complementoEscola' id='complementoEscola' class='form-control'>
            <label for='bairroEscola'>Bairro:</label>
            <input type='text' name='bairroEscola' id='bairroEscola' required class='form-control'>
            <label for='cidadeEscola'>Cidade:</label>
            <input type='text' name='cidadeEscola' id='cidadeEscola' required class='form-control'>
            <label for='estadoEscola'>Estado:</label>
            <select name='estadoEscola' id='estadoEscola' required class='form-control'>
                <option value=''>Selecione o estado corretamente...</option>";
            $sql = "SELECT * FROM states ORDER BY sigla ASC";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query)){
                while ($row = mysqli_fetch_array($query)){
                    $html .= "<option value='".$row['sigla']."'>".$row['sigla']."</option>";
                }
            }
            $html .="
            </select>
            <label for='tipoNotaEscola'>Tipo de Nota:</label>
            <select name='tipoNotaEscola' id='tipoNotaEscola' required class='form-control'>
                <option value=''>Selecione o tipo de nota corretamente...</option>
                <option value='1'>Bimestral</option>
                <option value='2'>Trimestral</option>
                <option value='3'>Semestral</option>
                <option value='4'>Anual</option>
            </select>
            <label for='turnoEscola'>Turno da Escola:</label>
            <select name='turnoEscola' id='turnoEscola' required class='form-control'>
                <option value=''>Selecione o turno da escola corretamente...</option>
                <option value='1'>Manhã</option>
                <option value='2'>Tarde</option>
                <option value='3'>Noite</option>
                <option value='4'>Único</option>
                <option value='5'>Todos</option>
            </select>
                <label for='letraEscola'>Letra da Escola:</label>
                     <select name='letraEscola' id='letraEscola' required class='form-control'>
                     <option value=''>Selecione até que letra a escola vai abaixo...</option>";
                     for($i = 0; $i <= 26; $i++) {
                         switch ($i){
                             case 0:
                                 $letra = "Única";
                                 $l = "Un";
                                 break;
                             case 1:
                                 $letra = "A";
                                 break;
                             case 2:
                                 $letra = "B";
                                 break;
                             case 3:
                                 $letra = "C";
                                 break;
                             case 4:
                                 $letra = "D";
                                 break;
                             case 5:
                                 $letra = "E";
                                 break;
                             case 6:
                                 $letra = "F";
                                 break;
                             case 7:
                                 $letra = "G";
                                 break;
                             case 8:
                                 $letra = "H";
                                 break;
                             case 9:
                                 $letra = "I";
                                 break;
                             case 10:
                                 $letra = "J";
                                 break;
                             case 11:
                                 $letra = "K";
                                 break;
                             case 12:
                                 $letra = "L";
                                 break;
                             case 13:
                                 $letra = "M";
                                 break;
                             case 14:
                                 $letra = "N";
                                 break;
                             case 15:
                                 $letra = "O";
                                 break;
                             case 16:
                                 $letra = "P";
                                 break;
                             case 17:
                                 $letra = "Q";
                                 break;
                             case 18:
                                 $letra = "R";
                                 break;
                             case 19:
                                 $letra = "S";
                                 break;
                             case 20:
                                 $letra = "T";
                                 break;
                             case 21:
                                 $letra = "U";
                                 break;
                             case 22:
                                 $letra = "V";
                                 break;
                             case 23:
                                 $letra = "W";
                                 break;
                             case 24:
                                 $letra = "X";
                                 break;
                             case 25:
                                 $letra = "Y";
                                 break;
                             case 26:
                                 $letra = "Z";
                                 break;
                         }
                         if ($i > 0){
                             $l = $letra;
                         }
                         $html .= "<option value='".$l."'>".$letra."</option>";
                     }
                     $html .= "
                     </select>";
        }
        $html .= "<br>
                            <button type=\"button\" onclick=\"incluirItem('".URL."')\"class=\"btn btn-primary\">Gravar</button>";
        echo "1|-|".$html;
        break;
    case "productItemEdita":
        $sql = "SELECT * FROM requests_items WHERE product_item = '".$_REQUEST['id']."' AND request = '".$_REQUEST['request']."' AND product = '".$_REQUEST['product']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        if ($row['product'] != 3 && $row['product'] != 4) {
            $html .= "<label for='domineEdita'>Domínio:</label><input type='text' name='domineEdita' id='domineEdita' required class='form-control' value='".$row['domine']."'>";
        }
        $html .= "<br>
                            <button type=\"button\" onclick=\"atualizarItem('".URL."')\"class=\"btn btn-primary\">Gravar</button>";
        echo "1|-|".$html;
        break;
    case "selecionaProdutoCadastro":
        $html = "<label for='productItemCadastro'>Item do Produto</label>
                 <select name='productItemCadastro' id='productItemCadastro' required class='form-control' onchange=selectProductItemCadastro(this.value,'".URL."')>
                    <option value=''>Selecione o item do produto abaixo...</option>";
        $sql = "SELECT * FROM products_items WHERE product = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            while ($row = mysqli_fetch_array($query)){
                $valor = ($row['promotion'] && $row['validity_promotion'] >= date('Y-m-d')) ? $row['promotion'] : $row['value'];
                $html .= "<option value='".$row['id']."'>".($row['name'])." - R$ ".number_format($valor, 2, ',', '.')."</option>";
            }
        }
        $html .= "</select><div id='productsItemCadastro'></div>";
        echo "1|-|".$html;
        break;
    case "selecionaEnderecoPedido":
        $sql = "SELECT * FROM addresses WHERE id = '" . $_REQUEST['id'] . "'";
        $query = mysqli_query($con, $sql);
        $endereco = mysqli_fetch_object($query);
        $html = "<b>Nome do Endereço:</b> " . ($endereco->name) . "<br>
                                          <b>CEP do Endereço:</b> " . ($endereco->cep) . "<br>
                                          <b>Logradouro do Endereço:</b> " . ($endereco->address) . "<br>
                                          <b>Número do Endereço:</b> " . ($endereco->number);
        if ($endereco->complement) {
            $html .= "<br>
                                          <b>Complemento do Endereço:</b> " . ($endereco->complement);
        }
        $html .= "<br>
                                          <b>Bairro do Endereço:</b> " . ($endereco->neighborhood);
        $html .= "<br>
                                          <b>Cidade do Endereço:</b> " . ($endereco->city);
        $html .= "<br>
                                          <b>Estado do Endereço:</b> " . ($endereco->state);
        echo "1|-|" . $html;
        break;
    case "pegaEnderecosCliente":
        $sql = "SELECT * FROM addresses WHERE idClient = '" . $_REQUEST['idCliente'] . "'";
        $query = mysqli_query($con, $sql);
        $html = "<label for='enderecoPedido'>Endereço do Cliente:</label><select name='enderecoPedido' id='enderecoPedido' class='form-control' required onchange=selecionaEnderecoPedido(this.value,'" . URL . "')><option value=''>Selecione o endereço abaixo corretamente...</option>";
        while ($value = mysqli_fetch_object($query)) {
            $html .= "<option value='$value->id'";
            if ($_REQUEST['idEndereco'] == $value->id) {
                $endereco = $value;
                $html .= " selected";
            }
            $html .= ">" . ($value->name . " - " . $value->address . " ... " . $value->city . " - " . $value->state) . "</option>";
        }
        $html .= "</select>";
        if (count($endereco)) {
            $html2 = "<b>Nome do Endereço:</b> " . ($endereco->name) . "<br>
                                          <b>CEP do Endereço:</b> " . ($endereco->cep) . "<br>
                                          <b>Logradouro do Endereço:</b> " . ($endereco->address) . "<br>
                                          <b>Número do Endereço:</b> " . ($endereco->number);
            if ($endereco->complement) {
                $html2 .= "<br>
                                          <b>Complemento do Endereço:</b> " . ($endereco->complement);
            }
            $html2 .= "<br>
                                          <b>Bairro do Endereço:</b> " . ($endereco->neighborhood);
            $html2 .= "<br>
                                          <b>Cidade do Endereço:</b> " . ($endereco->city);
            $html2 .= "<br>
                                          <b>Estado do Endereço:</b> " . ($endereco->state);
        }
    echo "1|-|$html|-|".$html2;
    break;
    case "selecionaClientePedido":
        $sql = "SELECT a.*, b.name AS nameTypeDocument FROM clients a INNER JOIN type_documents b ON (a.typeDocument = b.id)  WHERE a.id = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        $cliente = mysqli_fetch_object($query);
        $html = "
                            <div class=\"media text-muted pt-3\">
                                <p><b>Nome do Cliente: </b>".($cliente->name)."</p>
                            </div>
                            <div class=\"media text-muted pt-3\">
                                <p><b>Email do Cliente: </b>".$cliente->email."</p>
                            </div>
                            <div class=\"media text-muted pt-3\">
                                <p><b>Celular do Cliente: </b>$cliente->cel</p>
                            </div>
                            <div class=\"media text-muted pt-3\">
                                <p><b>Tipo de Documento do Cliente: </b>$cliente->nameTypeDocument</p>
                            </div>
                            <div class=\"media text-muted pt-3\">
                                <p><b>Documento do Cliente: </b>$cliente->document</p>
                            </div>";
        echo "1|-|".$html;
        break;
    case "pegaItensPedido":
        $sql = "SELECT * FROM products WHERE status = '1'";
        $query = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($query)){
            $products[] = $row;
        }
        $sql = "SELECT * FROM requests_items WHERE request = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            $html .= '<table border="0" width="100%" cellpadding="0" cellspacing="0">';
            if ($_REQUEST['cadastrar']){
                $html .= "<tr><td colspan='6'><button class='btn btn-primary' onClick='abre(\"cadastrarItem\")'>Cadastrar Item</button><div id='cadastrarItem' style='position: absolute; display:none; float: left; width:70%; padding:10px; background-color:#FFFFFF; border:1px solid #e7e7e7'><div style='position:absolute; float:left; left:95%; cursor:pointer' onclick=fecha('cadastrarItem')>&times;</div><input type='hidden' value='".$_REQUEST['id']."' name='requestCadastro' id='requestCadastro'><h3>Cadastro de Item</h3><label for='productCadastro'>Produto: </label><select class='form-control' name='productCadastro' id='productCadastro' onchange=selectProductCadastro(this.value,'".URL."')><option value=''>Selecione o produto...</option>";
                foreach($products as $key => $value){
                    $html .= "<option value='".$value['id']."'>".($value['name'])."</option>";
                }
                $html .= "</select><div id='selecionadoProdutoCadastro'></div></td></tr>";
            }
            $html .= "<div id='atualizarItem' style='position: absolute; display:none; float: left; width:70%; padding:10px; background-color:#FFFFFF; border:1px solid #e7e7e7'><div style='position:absolute; float:left; left:95%; cursor:pointer' onclick=fecha('atualizarItem')>&times;</div><input type='hidden' value='' name='idEdita' id='idEdita'><input type='hidden' value='".$_REQUEST['id']."' name='requestEdita' id='requestEdita'><h3>Edição de Item</h3><label for='productEdita'>Produto: </label><select class='form-control' name='productEdita' id='productEdita' onchange=selecionaProdutoEdita(this.value,'".$_REQUEST['id']."','".$_REQUEST['product']."','','".URL."')><option value=''>Selecione o produto...</option>";
                foreach($products as $key => $value){
                    $html .= "<option value='".$value['id']."'>".($value['name'])."</option>";
                }
                $html .= "</select><div id='selecionadoProdutoEdita'></div>
                        <tr>
                            <th style='text-align: center'>ID do Produto</th>
                            <th style='text-align: center'>Nome do Produto</th>
                            <th style='text-align: center'>Valor Unitário do Produto</th>
                            <th style='text-align: center'>Quantidade</th>
                            <th style='text-align: center'>Valor Total</th>";
            if ($_REQUEST['editar'] == 1 || $_REQUEST['excluir'] == 1){
                $html .= '<th style="text-align: center">Ações</th>';
            }
            $HTML .= '
                        </tr>';
            while ($row = mysqli_fetch_array($query)){
                $background = ($i % 2 == 0) ? "#e7e7e7" : "#ffffff";
                $html .= '<tr>
                            <td style="text-align:center; padding:5px; background-color: '.$background.'">'.$row['product'].'</td>
                            <td style="text-align:center; padding:5px; background-color: '.$background.'">'.($row['name']);
                if ($row['cashier_system']){
                    $sql = "SELECT * FROM cashier_system WHERE id = '".$row['cashier_system']."'";
                    $query2 = mysqli_query($con, $sql);
                    $row2 = mysqli_fetch_array($query2);
                    $html .= ' - <a onclick=verInformacoesCaixa("'.$row['cashier_system'].'") style="cursor:pointer">Ver informações do sistema</a>
                             <div id="informacoesCaixa" style="display:none; position:absolute; width:50%; background-color: #FFFFFF; border:1px solid #e7e7e7">
                                <div style="position:absolute; float::left; left: 95%; cursor: pointer" onclick=fecha("informacoesCaixa")>&times;</div>
                                <h3>Informações do Sistema de Caixa</h3>
                                Razão Social: <b>'.$row2['razao_social'].'</b><br>                                
                                Nome Fantasia: <b>'.$row2['nome_fantasia'].'</b><br>                                
                                E-mail: <b>'.$row2['email'].'</b><br>                                
                                CNPJ: <b>'.$row2['cnpj'].'</b><br>                                
                                CEP: <b>'.$row2['cep'].'</b><br>                                
                                Logradouro: <b>'.$row2['logradouro'].'</b><br>                                
                                Número: <b>'.$row2['numero'].'</b><br>';
                    if ($row2['complemento']){
                        $html .= "Complemento: <b>".$row2['complemento']."</b><br>";
                    }
                    $html .= '  Bairro: <b>'.$row2['bairro'].'</b><br>
                                Cidade: <b>'.$row2['cidade'].'</b><br>
                                Estado: <b>'.$row2['estado'].'</b><br>
                                Tipo do Estabelecimento: <b>';
                    if ($row2['tipoEstabelecimento'] == 1){
                        $tipoEstabelecimento = "Mesas";
                    }
                    else{
                        $tipoEstabelecimento = "Caixas";
                    }
                    $html .= $tipoEstabelecimento;
                    $html .= '</b><br>
                                Quantidade de '.$tipoEstabelecimento.': <b>'.$row2['quantidade'].'</b>';
                    if ($row2['tipoEstabelecimento'] == 1){
                        $html .= '<br>Número de Pessoas Por Mesa: <b>'.$row2['numeroPessoasPorMesa'].'</b>
                                    <br>Gorjeta do Garçom: <b>'.$row2['percentual'].'%</b>';
                    }
                   $html .= '</div>';
                }
                if ($row['school_system']){
                    $sql = "SELECT * FROM school_system WHERE id = '".$row['school_system']."'";
                    $query2 = mysqli_query($con, $sql);
                    $row2 = mysqli_fetch_array($query2);
                    $html .= ' - <a onclick=verInformacoesEscolar("'.$row['school_system'].'") style="cursor:pointer">Ver informações do sistema</a>
                             <div id="informacoesEscolar" style="display:none; position:absolute; width:50%; background-color: #FFFFFF; border:1px solid #e7e7e7">
                                <div style="position:absolute; float::left; left: 95%; cursor: pointer" onclick=fecha("informacoesEscolar")>&times;</div>
                                <h3>Informações do Sistema Escolar</h3>                             
                                Nome: <b>'.$row2['nome'].'</b><br>                                
                                E-mail: <b>'.$row2['email'].'</b><br>                              
                                CEP: <b>'.$row2['cep'].'</b><br>                                
                                Logradouro: <b>'.$row2['logradouro'].'</b><br>                                
                                Número: <b>'.$row2['numero'].'</b><br>';
                    if ($row2['complemento']){
                        $html .= "Complemento: <b>".$row2['complemento']."</b><br>";
                    }
                    $html .= '  Bairro: <b>'.$row2['bairro'].'</b><br>
                                Cidade: <b>'.$row2['cidade'].'</b><br>
                                Estado: <b>'.$row2['estado'].'</b><br>
                                Tipo de Nota: <b>';
                    if ($row2['tipoNota'] == 1){
                        $html .= 'Bimestral';
                    }
                    elseif ($row2['tipoNota'] == 2){
                        $html .= 'Trimestral';
                    }
                    elseif ($row2['tipoNota'] == 3){
                        $html .= 'Semestral';
                    }
                    elseif ($row2['tipoNota'] == 4){
                        $html .= 'Anual';
                    }
                    $html .= '</b><br>Turno: <b>';
                    if ($row2['turno'] == 1){
                        $html .= 'Manhã';
                    }
                    elseif ($row2['turno'] == 2){
                        $html .= 'Tarde';
                    }
                    elseif ($row2['turno'] == 3){
                        $html .= 'Noite';
                    }
                    elseif ($row2['turno'] == 4){
                        $html .= 'Único';
                    }
                    elseif ($row2['turno'] == 5){
                        $html .= 'Todos';
                    }
                    $html .= '</b><br>Letra: <b>';
                    if ($row2['letra'] == 'Un'){
                        $html .= "Única";
                    }
                    else{
                        $html .= $row2['letra'];
                    }
                    $html .= '</b></div>';
                }
                if ($row['domine']){
                    $html .= ' - <a href="'.$row['domine'].'" target="_blank" title="'.$row['domine'].'">'.substr($row['domine'], 0, 15)."...</a>";
                }
                $html .= '</td>
                            <td style="text-align:center; padding:5px; background-color: '.$background.'">R$'.number_format($row['value'], 2, ',', '.').'</td>
                            <td style="text-align:center; padding:5px; background-color: '.$background.'">'.$row['quantity'].'</td>
                            <td style="text-align:center; padding:5px; background-color: '.$background.'">R$'.number_format($row['value'] * $row['quantity'], 2, ',', '.').'</td>';
                if ($_REQUEST['editar'] == 1 || $_REQUEST['excluir'] == 1){
                    $html .= '<td style="text-align: center; padding:5px; background-color: '.$background.'">';
                    /*if ($_REQUEST['editar'] == 1){
                        $html .= '<img src="'.URL.'img/editar.png" style="cursor:pointer" onclick=editaProdutoPedido("'.$row['id'].'","'.$_REQUEST['id'].'","'.URL.'") width="15">';
                    }*/
                    if ($_REQUEST['excluir'] == 1){
                        $html .= '<img src="'.URL.'img/excluir.png" style="cursor:pointer" onclick=excluirItemPedido("'.$row['id'].'","'.$_REQUEST['id'].'","'.URL.'") width="15">';
                    }
                    $html .= '</td>';
                }

                $html .= '            
                        </tr>';
                $i++;
                $valorTotal += $row['value'] * $row['quantity'];
            }
            $html .= '<tr>
                            <td style="padding:5px; text-align:center; width: 100%; background-color:#0069D9; color:#FFFFFF" colspan="6">Valor Total do Pedido: R$ '.number_format($valorTotal, 2, ',','.').'</td>
                        </tr></table>';
        }
        else{
            $html = "<div style='padding:5px; text-align:center; width: 100%; color:#FFFFFF; background-color: #FF0000'>Sem nenhum item encontrado!</div>";
        }
        echo "1|-|".$html;
        break;
    case "addPermissao":
        if ($_REQUEST['field'] == 'view'){
            $permissao = "visualizar";
        }
        elseif ($_REQUEST['field'] == 'register'){
            $permissao = "cadastrar";
        }
        elseif ($_REQUEST['field'] == 'delete'){
            $permissao = "excluir";
        }
        $sql = "INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_REQUEST['userLog']."', '".("Adicionou a permissão de ".$permissao." o módulo ".$_REQUEST['module']."  do usuário  ").$_REQUEST['user']."', now(), now())";
        mysqli_query($con, $sql);
        $sql = "SELECT * FROM permissions WHERE module = '".$_REQUEST['module']."' AND user = '".$_REQUEST['user']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            $row = mysqli_fetch_array($query);
            $sql = "UPDATE permissions SET `".$_REQUEST['field']."` = '1' WHERE id = '".$row['id']."'";
        }
        else{
            $sql = "INSERT INTO permissions (module, user, `".$_REQUEST['field']."`, created_at, updated_at) VALUES ('".$_REQUEST['module']."', '".$_REQUEST['user']."', '1', now(), now())";
        }
        mysqli_query($con, $sql) or die(mysqli_error($con));
        echo "1";
        break;
    case "removePermissao":
        if ($_REQUEST['field'] == 'view'){
            $permissao = "visualizar";
        }
        elseif ($_REQUEST['field'] == 'register'){
            $permissao = "cadastrar";
        }
        elseif ($_REQUEST['field'] == 'delete'){
            $permissao = "excluir";
        }
        $sql = "INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_REQUEST['userLog']."', '".("Removeu a permissão de ".$permissao." o módulo ".$_REQUEST['module']."  do usuário  ").$_REQUEST['user']."', now(), now())";
        mysqli_query($con, $sql);
        $sql = "SELECT * FROM permissions WHERE module = '".$_REQUEST['module']."' AND user = '".$_REQUEST['user']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            $row = mysqli_fetch_array($query);
            $sql = "UPDATE permissions SET `".$_REQUEST['field']."` = '0' WHERE id = '".$row['id']."'";
        }
        else{
            $sql = "INSERT INTO permissions (module, user, `".$_REQUEST['field']."`, created_at, updated_at) VALUES ('".$_REQUEST['module']."', '".$_REQUEST['user']."', '0', now(), now())";
        }
        mysqli_query($con, $sql) or die(mysqli_error($con));
        echo "1";
        break;
    case "pegaPermissaoUsuario":
        echo "1|-|";
        $sql = "INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_REQUEST['user']."', '".("Visualizou as permissões do usuário  ").$_REQUEST['id']."', now(), now())";
        mysqli_query($con, $sql);
        $sql = "SELECT a.*, b.name AS nameTypeModule FROM modules a INNER JOIN type_modules b ON (a.typeModule = b.id) ORDER BY a.typeModule ASC, a.id ASC";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            echo '
          <div style="float:left; width:25%">Módulo</div>  
          <div style="float:left; width:25%">Visualiar</div>  
          <div style="float:left; width:25%">Cadastrar</div>  
          <div style="float:left; width:25%">Excluir</div> <br>        
    ';
            while($row = mysqli_fetch_array($query)){
                $sql = "SELECT * FROM permissions WHERE user = '".$_REQUEST['id']."' AND module = '".$row['id']."'";
                $query2 = mysqli_query($con, $sql);
                $row2 = mysqli_fetch_array($query2);
                echo '<div style="float: left; width:25%; height:50px;';
                if ($i % 2 == 0){
                    echo 'background-color: #e7e7e7';
                }
                echo '">'.($row['nameTypeModule'].' => '.$row['name']).'</div>
    <div style="float: left; width:25%; height:50px; ';
                if ($i % 2 == 0){
                    echo 'background-color: #e7e7e7';
                }
                echo '" id="view'.$row['id'].$_REQUEST['id'].'">';
                if ($row2['view']){
                    echo '<img src="'.URL.'img/sucesso.png" width="20" style="cursor:pointer" onclick=removePermissao("'.$_REQUEST['id'].'","'.$row['id'].'","view","'.URL.'","'.$_REQUEST['user'].'")>';
                }
                else{
                    echo '<img src="'.URL.'img/erro.ico" width="20" style="cursor:pointer" onclick=adicionaPermissao("'.$_REQUEST['id'].'","'.$row['id'].'","view","'.URL.'","'.$_REQUEST['user'].'")>';
                }
                echo '</div>
    <div style="float: left; width:25%; height:50px; ';
                if ($i % 2 == 0){
                    echo 'background-color: #e7e7e7';
                }
                echo '" id="register'.$row['id'].$_REQUEST['id'].'">';
                if ($row2['register']){
                    echo '<img src="'.URL.'img/sucesso.png" width="20" style="cursor:pointer" onclick=removePermissao("'.$_REQUEST['id'].'","'.$row['id'].'","register","'.URL.'","'.$_REQUEST['user'].'")>';
                }
                else{
                    echo '<img src="'.URL.'img/erro.ico" width="20" style="cursor:pointer" onclick=adicionaPermissao("'.$_REQUEST['id'].'","'.$row['id'].'","register","'.URL.'","'.$_REQUEST['user'].'")>';
                }
                echo '</div>
    <div style="float: left; width:25%; height:50px; ';
                if ($i % 2 == 0){
                echo 'background-color: #e7e7e7';
                }
                echo '" id="delete'.$row['id'].$_REQUEST['id'].'">';
                if ($row2['delete']){
                    echo '<img src="'.URL.'img/sucesso.png" width="20" style="cursor:pointer" onclick=removePermissao("'.$_REQUEST['id'].'","'.$row['id'].'","delete","'.URL.'","'.$_REQUEST['user'].'")>';
                }
                else{
                    echo '<img src="'.URL.'img/erro.ico" width="20" style="cursor:pointer" onclick=adicionaPermissao("'.$_REQUEST['id'].'","'.$row['id'].'","delete","'.URL.'","'.$_REQUEST['user'].'")>';
                }
                echo '</div><br>
';
                $i++;
            }
        }
        else{
            echo '<div style="text-align:center; padding:10px; color:#FFFFFF; background-color: #FF0000">Sem nenhum módulo encontrado!</div>';
        }
        break;
    case "contaAcessoBanner":
        $sql = "SELECT * FROM counters_banners WHERE data = '".date('Y-m-d')."' AND banner = '".$_GET['id']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            $row = mysqli_fetch_array($query);
            $acessos = $row['acessos'] + 1;
            $sql = "UPDATE counters_banners SET acessos = '".$acessos."', updated_at = now() WHERE id = '".$row['id']."'";
            mysqli_query($con, $sql);
        }
        else{
            $sql = "INSERT INTO counters_banners (banner, data, acessos, created_at, updated_at) VALUES ('".$_GET['id']."', '".date('Y-m-d')."', '1', now(), now())";
            mysqli_query($con, $sql);
        }
        echo "1";
        break;
    case "contaAcessoSubitem":
        $sql = "SELECT * FROM counters_subitems WHERE data = '".date('Y-m-d')."' AND subitem = '".$_GET['id']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            $row = mysqli_fetch_array($query);
            $acessos = $row['acessos'] + 1;
            $sql = "UPDATE counters_subitems SET acessos = '".$acessos."', updated_at = now() WHERE id = '".$row['id']."'";
            mysqli_query($con, $sql);
        }
        else{
            $sql = "INSERT INTO counters_subitems (subitem, data, acessos, created_at, updated_at) VALUES ('".$_GET['id']."', '".date('Y-m-d')."', '1', now(), now())";
            mysqli_query($con, $sql);
        }
        echo "1";
        break;
    case "contaAcessoPagina":
        $sql = "SELECT * FROM counters_pages WHERE data = '".date('Y-m-d')."' AND page = '".$_GET['id']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            $row = mysqli_fetch_array($query);
            $acessos = $row['acessos'] + 1;
            $sql = "UPDATE counters_pages SET acessos = '".$acessos."', updated_at = now() WHERE id = '".$row['id']."'";
            mysqli_query($con, $sql);
        }
        else{
            $sql = "INSERT INTO counters_pages (page, data, acessos, created_at, updated_at) VALUES ('".$_GET['id']."', '".date('Y-m-d')."', '1', now(), now())";
            mysqli_query($con, $sql);
        }
        echo "1";
        break;
    case "contaAcesso":
        if (!$_SESSION['contador']){
            $sql = "SELECT * FROM counters WHERE data = '".date('Y-m-d')."'";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query)){
                $row = mysqli_fetch_array($query);
                $acessos = $row['acessos'] + 1;
                $sql = "UPDATE counters SET acessos = '".$acessos."', updated_at = now() WHERE id = '".$row['id']."'";
                mysqli_query($con, $sql);
            }
            else{
                $sql = "INSERT INTO counters (data, acessos, created_at, updated_at) VALUES ('".date('Y-m-d')."', '1', now(), now())";
                mysqli_query($con, $sql);
            }
            $_SESSION['contador'] = 1;
        }
        if (!$_GET['url']){
            $page = 1;
        }
        else{
            $sql = "SELECT * FROM pages WHERE slug = '".$_GET['url']."'";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($query);
            $page = $row['id'];
        }
        $sql = "SELECT * FROM counters_pages WHERE data = '".date('Y-m-d')."' AND page = '".$page."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            $row = mysqli_fetch_array($query);
            $acessos = $row['acessos'] + 1;
            $sql = "UPDATE counters_pages SET acessos = '".$acessos."', updated_at = now() WHERE id = '".$row['id']."'";
            mysqli_query($con, $sql);
        }
        else{
            $sql = "INSERT INTO counters_pages (page, data, acessos, created_at, updated_at) VALUES ('".$page."', '".date('Y-m-d')."', '1', now(), now())";
            mysqli_query($con, $sql);
        }
        echo "1";
        break;
    case "editaItensVenda":
        $sql = "SELECT * FROM products_items WHERE id = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        echo ("1|-|".$row['id']."|-|".$row['product_type']."|-|".$row['code']."|-|".$row['name']."|-|".number_format($row['value'], 2, ',', '.')."|-|".number_format($row['promotion'], 2, ',', '.')."|-|".$row['validity_promotion']."|-|".$row['status']);
        break;
    case "listarItensVenda":
        $sql = "SELECT * FROM products_items WHERE product = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        echo "1|-|";
        if (mysqli_num_rows($query)){
            while ($row = mysqli_fetch_array($query)){
                ?><div style="width:100%; padding:10px"id="itemVenda<?php echo $row['id']?>" onmouseover="this.style.backgroundColor='#F7F7F7'" onmouseout="this.style.backgroundColor='#FFFFFF'"><?php echo ($row['name'])?> <img src="<?php echo URL?>img/editar.png" width="20" style="cursor:pointer" onclick="editaItemVenda('<?php echo $row['id']?>', '<?php echo URL?>', '<?php echo $_REQUEST['id']?>')"> <img src="<?php echo URL?>img/excluir.png" width="20" style="cursor:pointer" onclick="excluirItemVenda('<?php echo $row['id']?>', '<?php echo URL?>', '<?php echo $_REQUEST['id']?>')"></div><?php
            }
        }
        break;
    case "cadastrarItemVenda":
        $_REQUEST['value'] = str_replace('.', '', $_REQUEST['value']);
        $_REQUEST['value'] = str_replace(',', '.', $_REQUEST['value']);
        $_REQUEST['promotion'] = str_replace('.', '', $_REQUEST['promotion']);
        $_REQUEST['promotion'] = str_replace(',', '.', $_REQUEST['promotion']);
        $sql = ("INSERT INTO products_items (product, product_type, code, name, value, promotion, validity_promotion, status, created_at, updated_at) VALUES ('".$_REQUEST['product']."', '".$_REQUEST['product_type']."', '".$_REQUEST['code']."', '".$_REQUEST['name']."', '".$_REQUEST['value']."', '".$_REQUEST['promotion']."', '".$_REQUEST['validity_promotion']."', '".$_REQUEST['status']."', now(), now())");
        mysqli_query($con, $sql);
        echo "1|-|";
        break;
    case "editarItemVenda":
        $_REQUEST['value'] = str_replace('.', '', $_REQUEST['value']);
        $_REQUEST['value'] = str_replace(',', '.', $_REQUEST['value']);
        $_REQUEST['promotion'] = str_replace('.', '', $_REQUEST['promotion']);
        $_REQUEST['promotion'] = str_replace(',', '.', $_REQUEST['promotion']);
        $sql = ("UPDATE products_items SET product_type = '".$_REQUEST['product_type']."', code = '".$_REQUEST['code']."', name = '".$_REQUEST['name']."', value = '".$_REQUEST['value']."', promotion = '".$_REQUEST['promotion']."', validity_promotion = '".$_REQUEST['validity_promotion']."', status = '".$_REQUEST['status']."', updated_at = now() WHERE id = '".$_REQUEST['id']."'");
        mysqli_query($con, $sql);
        echo "1|-|";
        break;
    case "excluirItensVenda":
        $sql = "DELETE FROM products_items WHERE id = '".$_REQUEST['id']."'";
        mysqli_query($con, $sql);
        echo "1|-|";
        break;
    case "mostra_comprovante":
        echo "1|-|";
        $_REQUEST['id'] = $_REQUEST['request_id'];
        require_once('enviaComprovante.php');
        break;
    case "comprar":
        $sql = "SELECT * FROM cart WHERE session_id = '".session_id()."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)) {
            while ($row = mysqli_fetch_array($query)) {
                $subtotal += $row['value'] * $row['quantity'];
            }
        }
        $sql = "INSERT INTO requests (client, paymentMethod, address, valuePayment, status, created_at, updated_at) VALUES ('".$_SESSION['cliente']['id']."', '".$_REQUEST['payment_method']."', '".$_REQUEST['address']."', '".$subtotal."', '3', now(), now())";
        $query = mysqli_query($con, $sql);
        $idPedido = mysqli_insert_id($con);
        $sql = "SELECT * FROM cart WHERE session_id = '".session_id()."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            while ($row = mysqli_fetch_array($query)){
                $sql = "INSERT INTO requests_items (request, product, product_item, school_system, cashier_system, name, domine, quantity, value, created_at, updated_at) VALUES ('".$idPedido."', '".$row['product']."', '".$row['product_item']."', '".$row['school_system']."', '".$row['cashier_system']."', '".$row['name']."', '".$row['domine']."', '".$row['quantity']."', '".$row['value']."', now(), now())";
                $query2 = mysqli_query($con, $sql);
            }
        }
        $sql = "DELETE FROM cart WHERE session_id = '".session_id()."'";
        $query = mysqli_query($con, $sql);
        echo '1|-|<img src="'.URL.'img/loader.gif" width="20"> Aguarde... Carregando Comprovante...|-|'.$idPedido;
        break;
    case "enderecosCompra":
        $sql = "SELECT * FROM payment_methods WHERE id = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        echo "1|-|Forma de Pagamento escolhida: <b>".($row['name'])."</b><input type='hidden' name='formaPagamentoCompra' id='formaPagamentoCompra' value='".$row['id']."'><br>
                  <label for='enderecoCompra'>Endereço:</label> ";
        $sql = "SELECT * FROM addresses WHERE idClient = '".$_SESSION['cliente']['id']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            echo "<select name='enderecoCompra' id='enderecoCompra' class='form-control' required>
            <option value=''>Seleione o endereço corretamente...</option>";
            while ($row = mysqli_fetch_array($query)){
                echo "<option value='".$row['id']."'>".($row['name']." - ".$row['address'].", ".$row['number']);
                if ($row['complement']){
                    echo (", ".$row['complement']);
                }
                echo (" - B. ".$row['neighborhood']." - ".$row['city']." - ".$row['state']."</option>");
            }
            echo '</select>
            <br>
            <button type="button" class="btn btn-secondary" onClick="fecha(\'finalizarPedido\')">Fechar</button>
            <button type="button" class="btn btn-primary" onclick="comprar(\''.URL.'\')">Realizar Compra</button>';
            mysqli_num_rows($query);
        }
        else{
            echo "Sem endereço encontrado para o cliente! Cadastre um novo agora!";
        }
        break;
    case "finalizarPedido":
        echo '1|-|<button type="button" class="close" onClick=fecha("finalizarPedido")><span aria-hidden="true">&times;</span></button>Escolha a forma de pagamento abaixo:
            <table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
            $sql = "SELECT * FROM payment_methods";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query)){
                while ($row = mysqli_fetch_array($query)){
                    echo '<td style="width: 50%; text-align: center; cursor:pointer" onclick="selecionaFormaPagamento(\''.$row['id'].'\', \''.URL.'\', this)" id="formaPagamento'.$row['id'].'">
                    <img src="'.URL.'storage/'.$row['img'].'" width="200">
                    '.($row['name']).'
                    </td>';
                }
            }
        echo '</tr></table><div id="enderecosCompra"></div>';
        break;
    case "limparCarrinho":
        $sql .= "DELETE FROM cart WHERE session_id = '".session_id()."'";
        mysqli_query($con, $sql);
        echo "1";
        break;
    case "excluirCarrinho":
        $sql .= "DELETE FROM cart WHERE id = '".$_REQUEST['id']."'";
        mysqli_query($con, $sql);
        echo "1";
        break;
    case "mostraCarrinhoDeCompras":
        echo '1|-|';
        $sql = "SELECT a.* FROM cart a WHERE a.session_id = '".session_id()."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            echo "<h5>Produtos no Carrinho</h5>";
            echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                           <th>Nome do Produto</th>
                           <th>Valor do Produto</th>
                           <th>Quantidade</th>
                           <th>Valor Total</th>
                           <th>Excluir</th>
                      </tr>';
            $i = 0;
            while ($row = mysqli_fetch_array($query)){
                $backgroundColor = ($i % 2 == 1) ? "#E7E7E7" : "";
                echo ('<tr style="background-color:'.$backgroundColor.'">
                    <td style="text-align: center">'.$row['name']);
                if($row['domine']) {
                    echo (' - <a href="' . $row['domine'] . '" target="_blank">' . substr($row['domine'], 0, 15) . '...</a>');
                }
                if ($row['school_system']){
                    $sql = "SELECT * FROM school_system WHERE id = '".$row['school_system']."'";
                    $query2 = mysqli_query($con, $sql);
                    $rowSistemaEscolar = mysqli_fetch_array($query2);
                    if ($rowSistemaEscolar['tipoNota'] == 1){
                        $rowSistemaEscolar['tipoNota'] = "Bimestral";
                    }
                    elseif ($rowSistemaEscolar['tipoNota'] == 2){
                        $rowSistemaEscolar['tipoNota'] = "Trimestral";
                    }
                    elseif ($rowSistemaEscolar['tipoNota'] == 3){
                        $rowSistemaEscolar['tipoNota'] = "Semestral";
                    }
                    elseif ($rowSistemaEscolar['tipoNota'] == 4){
                        $rowSistemaEscolar['tipoNota'] = "Anual";
                    }
                    if ($rowSistemaEscolar['turno'] == 1){
                        $rowSistemaEscolar['turno'] = "Manhã";
                    }
                    elseif ($rowSistemaEscolar['turno'] == 2){
                        $rowSistemaEscolar['turno'] = "Tarde";
                    }
                    elseif ($rowSistemaEscolar['turno'] == 3){
                        $rowSistemaEscolar['turno'] = "Noite";
                    }
                    elseif ($rowSistemaEscolar['turno'] == 4){
                        $rowSistemaEscolar['turno'] = "Único";
                    }
                    elseif ($rowSistemaEscolar['turno'] == 5){
                        $rowSistemaEscolar['turno'] = "Todos";
                    }
                    if ($rowSistemaEscolar['letra'] == "Un"){
                        $rowSistemaEscolar['letra'] = "Única";
                    }
                    echo ' - <a onclick="verInformacoesSistemaEscolar(\''.$row['school_system'].'\')" style="color: #0077A4; cursor: pointer" title="Ver informações do sistema">Ver Informações do Sistema</a>
                            <div id="informacoesSistemaEscolar'.$row['school_system'].'" style="display: none; position:absolute; width:92%; background-color:#FFFFFF">
                                <button type"button" class="close" onClick=fecha("informacoesSistemaEscolar'.$row['school_system'].'")><span aria-hidden="true">&times;</span></button>
                                <h3>Informações do Sistema Escolar</h3>
                                <b>Nome da Escola:</b> '.$rowSistemaEscolar['nome'].'<br>
                                <b>Email da Escola:</b> '.$rowSistemaEscolar['email'].'<br>
                                <b>CEP da Escola:</b> '.$rowSistemaEscolar['cep'].'<br>
                                <b>Logradouro da Escola:</b> '.$rowSistemaEscolar['logradouro'].'<br>
                                <b>Número da Escola:</b> '.$rowSistemaEscolar['numero'].'<br>';
                    if ($rowSistemaEscolar['complemento']){
                        echo '<b>Complemento:</b> '.$rowSistemaEscolar['complemento'].'<br>';
                    }
                    echo '<b>Bairro da Escola:</b> '.$rowSistemaEscolar['bairro'].'<br>
                                <b>Cidade da Escola:</b> '.$rowSistemaEscolar['cidade'].'<br>
                                <b>Estado da Escola:</b> '.$rowSistemaEscolar['estado'].'<br>
                                <b>Tipo de Nota da Escola:</b> '.$rowSistemaEscolar['tipoNota'].'<br>
                                <b>Turno da Escola:</b> '.$rowSistemaEscolar['turno'].'<br>
                                <b>Letra da Escola:</b> '.$rowSistemaEscolar['letra'].'
                            </div>';
                }
                if ($row['cashier_system']) {
                    $sql = "SELECT * FROM cashier_system WHERE id = '" . $row['cashier_system'] . "'";
                    $query2 = mysqli_query($con, $sql);
                    $rowSistemaCaixa = mysqli_fetch_array($query2);
                    echo ' - <a onclick="verInformacoesSistemaCaixa(' . $row['cashier_system'] . ')" style="color: #0077A4; cursor: pointer" title="Ver informações do sistema">Ver Informações do Sistema</a>
                    <div id="informacoesSistemaCaixa' . $row['cashier_system'] . '" style="display: none; position:absolute; width:92%; background-color:#FFFFFF">
                                <button type"button" class="close" onClick=fecha("informacoesSistemaCaixa' . $row['cashier_system'] . '")><span aria-hidden="true">&times;</span></button>
                                <h3>Informações do Sistema de Caixa</h3>
                                <b>Razão Social:</b> ' . $rowSistemaCaixa['razao_social'] . '<br>
                                <b>Nome Fantasia:</b> ' . $rowSistemaCaixa['nome_fantasia'] . '<br>
                                <b>Email:</b> ' . $rowSistemaCaixa['email'] . '<br>
                                <b>CNPJ:</b> ' . $rowSistemaCaixa['cnpj'] . '<br>
                                <b>CEP:</b> ' . $rowSistemaCaixa['cep'] . '<br>
                                <b>Logradouro:</b> ' . $rowSistemaCaixa['logradouro'] . '<br>
                                <b>Número:</b> ' . $rowSistemaCaixa['numero'] . '<br>';
                    if ($rowSistemaCaixa['complemento']) {
                        echo '<b>Complemento:</b> ' . $rowSistemaCaixa['complemento'] . '<br>';
                    }
                    echo '<b>Bairro:</b> ' . $rowSistemaCaixa['bairro'] . '<br>
                                <b>Cidade:</b> ' . $rowSistemaCaixa['cidade'] . '<br>
                                <b>Estado:</b> ' . $rowSistemaCaixa['estado'] . '<br>
                                <b>Tipo de Estabelecimento:</b> ';
                    if ($rowSistemaCaixa['tipoEstabelecimento'] == 1) {
                        echo 'Mesa';
                    } else {
                        echo 'Caixa';
                    }
                    echo '<br>
                                <b>Quantidade de ';
                    if ($rowSistemaCaixa['tipoEstabelecimento'] == 1) {
                        echo 'Mesas';
                    } else {
                        echo 'Caixas';
                    }
                    echo ':</b> ' . $rowSistemaCaixa['quantidade'];
                    if ($rowSistemaCaixa['tipoEstabelecimento'] == 1) {
                        echo '<br>
                                <b>Número Pessoas Por Mesa:</b> ' . $rowSistemaCaixa['numeroPessoasPorMesa'] . '<br>
                                <b>Gorjeta do Garçom:</b> ' . $rowSistemaCaixa['percentual'] . '%
                            </div>';
                    }
                }
                    echo ('</td>
                    <td style="text-align: center">R$'.number_format($row['value'], 2, ',', '.').'</td>
                    <td style="text-align: center">'.$row['quantity'].'</td>
                    <td style="text-align: center">R$'.number_format($row['value'] * $row['quantity'], 2, ',', '.').'</td>
                    <td style="text-align: center"><img src="'.URL.'img/excluir.png" width="20" style="cursor:pointer;" onclick=excluirCarrinho("'.$row['id'].'","'.URL.'")></td>
                </tr>');
                $i++;
            }
            echo '</table>';
        }
        else {
            echo '<div style="padding:10px; text-align: center; background-color:#FF0000; color:#FFFFFF"><h5>Sem nenhum produto no carrinho no momento!</h5></div>';
        }
        echo  '<input type="hidden" id="numProdutosCarrinho" name="numProdutosCarrinho" value="0">|-|'.mysqli_num_rows($query);
        break;
        case "salvarCarrinho":
            $sql = 'SELECT * FROM products_items WHERE id = "'.$_REQUEST['produtoItemRealizarPedido'].'"';
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($query);
            $valor = ($row['promotion'] && $row['validity_promotion'] >= date('Y-m-d')) ? $row['promotion'] : $row['value'];
            $sql = "INSERT INTO cart (product, product_item, session_id, domine, name, quantity, value, created_at, updated_at) VALUES ('".$_REQUEST['produtoRealizarPedido']."', '".$_REQUEST['produtoItemRealizarPedido']."', '".session_id()."', '".$_REQUEST['domineRealizarPedido']."', '".$row['name']."', '1', '".$valor."', now(), now())";
            mysqli_query($con, $sql);
            $idCarrinho = mysqli_insert_id($con);
            if ($_REQUEST['hostingRealizarPedido']){
                $sql = 'SELECT * FROM products_items WHERE id = "'.$_REQUEST['hostingRealizarPedido'].'"';
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $valor = ($row['promotion'] && $row['validity_promotion'] >= date('Y-m-d')) ? $row['promotion'] : $row['value'];
                $sql = "INSERT INTO cart (product, product_item, session_id, domine, name, quantity, value, created_at, updated_at) VALUES ('".$row['product']."', '".$_REQUEST['hostingRealizarPedido']."', '".session_id()."', '".$_REQUEST['domineRealizarPedido']."', '".$row['name']."', '1', '".$valor."', now(), now())";
                mysqli_query($con, $sql);
            }
            if ($_REQUEST['registroRealizarPedido']){
                $sql = 'SELECT * FROM products_items WHERE id = "'.$_REQUEST['registroRealizarPedido'].'"';
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $valor = ($row['promotion'] && $row['validity_promotion'] >= date('Y-m-d')) ? $row['promotion'] : $row['value'];
                $sql = "INSERT INTO cart (product, product_item, session_id, domine, name, quantity, value, created_at, updated_at) VALUES ('".$row['product']."', '".$_REQUEST['registroRealizarPedido']."', '".session_id()."', '".$_REQUEST['domineRealizarPedido']."', '".$row['name']."', '1', '".$valor."', now(), now())";
                mysqli_query($con, $sql);
            }
            if ($_REQUEST['modelSiteRealizarPedido']){
                $sql = 'SELECT * FROM subitems WHERE id = "'.$_REQUEST['modelSiteRealizarPedido'].'"';
                $query = mysqli_query($con, $sql);
                $row2 = mysqli_fetch_array($query);
                $sql = 'SELECT * FROM products_items WHERE product = "8"';
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($query);
                $valor = ($row['promotion'] && $row['validity_promotion'] >= date('Y-m-d')) ? $row['promotion'] : $row['value'];
                $sql = "INSERT INTO cart (product, product_item, session_id, domine, name, quantity, value, created_at, updated_at) VALUES ('8', '".$_REQUEST['modelSiteRealizarPedido']."', '".session_id()."', '".$_REQUEST['domineRealizarPedido']."', '".$row['name']." - ".$row2['name']."', '1', '".$valor."', now(), now())";
                mysqli_query($con, $sql);
            }
            if ($_REQUEST['produtoRealizarPedido'] == 3) {
                $sql = "INSERT INTO cashier_system (razao_social, nome_fantasia, email, cnpj, cep, logradouro, numero, complemento, bairro, cidade, estado, tipoEstabelecimento, quantidade, numeroPessoasPorMesa, percentual, created_at, updated_at) VALUES ('" . $_REQUEST['nomeFantasiaRealizarPedido'] . "', '" . $_REQUEST['nomeFantasiaRealizarPedido'] . "', '".$_REQUEST['emailEmpresaRealizarPedido']."', '" . $_REQUEST['cnpjEmpresaRealizarPedido'] . "', '" . $_REQUEST['cepRealizarPedido'] . "', '" . $_REQUEST['logadouroRealizarPedido'] . "', '" . $_REQUEST['numeroRealizarPedido'] . "', '" . $_REQUEST['complementoRealizarPedido'] . "', '" . $_REQUEST['bairroRealizarPedido'] . "', '" . $_REQUEST['cidadeRealizarPedido'] . "', '" . $_REQUEST['estadoRealizarPedido'] . "', '" . $_REQUEST['tipoEstabelecimentoRealizarPedido'] . "', '" . $_REQUEST['quantidadeRealizarPedido'] . "', '" . $_REQUEST['numPessoasRealizarPedido'] . "', '" . $_REQUEST['perGarcomRealizarPedido'] . "', now(), now())";
                mysqli_query($con, $sql) or die(mysqli_error($con));
                $cashier_system = mysqli_insert_id($con);
                $sql = "UPDATE cart SET cashier_system = '".$cashier_system."' WHERE id = '".$idCarrinho."'";
                mysqli_query($con, $sql) or die(mysqli_error($con));
            }
            if ($_REQUEST['produtoRealizarPedido'] == 4) {
                $sql = "INSERT INTO school_system (nome, email, cep, logradouro, numero, complemento, bairro, cidade, estado, tipoNota, turno, letra, created_at, updated_at) VALUES ('" . $_REQUEST['nomeEscolaRealizarPedido'] . "', '" . $_REQUEST['emailEscolaRealizarPedido'] . "', '" . $_REQUEST['cepEscolaRealizarPedido'] . "', '" . $_REQUEST['logadouroEscolaRealizarPedido'] . "', '" . $_REQUEST['numeroEscolaRealizarPedido'] . "', '" . $_REQUEST['complementoEscolaRealizarPedido'] . "', '" . $_REQUEST['bairroEscolaRealizarPedido'] . "', '" . $_REQUEST['cidadeEscolaRealizarPedido'] . "', '" . $_REQUEST['estadoEscolaRealizarPedido'] . "', '" . $_REQUEST['tipoNotaRealizarPedido'] . "', '" . $_REQUEST['turnoEscolaRealizarPedido'] . "', '" . $_REQUEST['letraEscolaRealizarPedido'] . "', now(), now())";
                mysqli_query($con, $sql) or die(mysqli_error($con));
                $school_system = mysqli_insert_id($con);
                $sql = "UPDATE cart SET school_system = '".$school_system."' WHERE id = '".$idCarrinho."'";
                mysqli_query($con, $sql) or die(mysqli_error($con));
            }
        echo "1";
        break;
    case "selecionaPasso03":
        if ($_REQUEST['product'] != 3 && $_REQUEST['product'] != 4) {
            $html = '<label for="domineRealizarPedido">Domínio:</label>
                     <input type="text" name="domineRealizarPedido" id="domineRealizarPedido" required class="form-control" placeholder="Informe aqui o domínio que você comprou ou ainda vai comprar...">';
            if ($_REQUEST['product'] <= 5) {
                $html .= '
                     <label for="hostingRealizarPedido">Hospedagem:</label>
                     <select name="hostingRealizarPedido" id="hostingRealizarPedido" class="form-control">
                        <option value="">Selecione uma hospedagem para o seu site, ou deixe assim se já possuir a hospedagem...</option>
                        ';
                $sql = "SELECT * FROM products_items WHERE product = '6' AND status = '1'";
                $query = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($query)) {
                    $valor = ($row['promotion'] && $row['validity_promotion'] && $row['validity_promotion'] >= date('Y-m-d')) ? $row['promotion'] : $row['value'];
                    $html .= '<option value="' . $row['id'] . '">' . ($row['name']) . ' - R$' . number_format($valor, 2, ',', '.') . '</option>';
                }
                $html .= '</select>
                     ';
            }
            if ($_REQUEST['product'] <= 6) {
                $html .= '<label for="registroRealizarPedido">Registro do Domínio:</label>
                     <select name="registroRealizarPedido" id="registroRealizarPedido" class="form-control">
                        <option value="">Selecione um registro para o seu site, ou deixe assim se já possuir o domínio...</option>
                        ';
                $sql = "SELECT * FROM products_items WHERE product = '7' AND status = '1'";
                $query = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($query)) {
                    $valor = ($row['promotion'] && $row['validity_promotion'] && $row['validity_promotion'] >= date('Y-m-d')) ? $row['promotion'] : $row['value'];
                    $html .= '<option value="' . $row['id'] . '">' . ($row['name']) . ' - R$' . number_format($valor, 2, ',', '.') . '</option>';
                }
                $html .= '</select>';
            }
            if ($_REQUEST['product'] <= 5) {
                $html .= '<label for="modelSiteRealizarPedido">Modelo de Site:</label>
                     <select name="modelSiteRealizarPedido" id="modelSiteRealizarPedido" class="form-control">
                        <option value="">Selecione um modelo de site, ou deixe assim se já possuir um modelo...</option>
                        ';
                $sql = "SELECT * FROM subitems WHERE page = '5' AND status = '1'";
                $query = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($query)) {
                    $sql = "SELECT * FROM products_items WHERE product = '8' AND status = '1'";
                    $query2 = mysqli_query($con, $sql);
                    $rowProductItem = mysqli_fetch_array($query2);
                    $valor = ($rowProductItem['promotion'] && $rowProductItem['validity_promotion'] && $rowProductItem['validity_promotion'] >= date('Y-m-d')) ? $rowProductItem['promotion'] : $rowProductItem['value'];
                    $html .= '<option value="' . $row['id'] . '">' . ($row['name']) . ' - R$' . number_format($valor, 2, ',', '.') . '</option>';
                }
                $html .= '</select>';
            }
        }
        if ($_REQUEST['product'] == 3){
            $html = '<label for="razaoSocialRealizarPedido">Razão Social:</label>
                     <input type="text" name="razaoSocialRealizarPedido" id="razaoSocialRealizarPedido" required class="form-control" placeholder="Informe aqui a razão social da empresa...">
                     <label for="nomeFantasiaRealizarPedido">Nome Fantasia:</label>
                     <input type="text" name="nomeFantasiaRealizarPedido" id="nomeFantasiaRealizarPedido" required class="form-control" placeholder="Informe aqui o nome fantasia da empresa...">
                     <label for="emailEmpresaRealizarPedido">Email:</label>
                     <input type="email" name="emailEmpresaRealizarPedido" id="emailEmpresaRealizarPedido" required class="form-control" placeholder="Informe aqui o email da empresa...">
                     <label for="cnpjEmpresaRealizarPedido">CNPJ:</label>
                     <input type="text" name="cnpjEmpresaRealizarPedido" id="cnpjEmpresaRealizarPedido" onkeypress="return mascara(this, \'00.000.000/0000-00\', event)" required class="form-control" placeholder="Informe aqui o cnpj da empresa... Somente Números...">
                     <label for="cepRealizarPedido">CEP:</label>
                     <input type="text" name="cepRealizarPedido" id="cepRealizarPedido" onkeyup="pesquisacepRealizarPedido(this.value)" onkeypress="return mascara(this, \'00000-000\', event)" required class="form-control" placeholder="Informe aqui o cep da empresa... Somente Números...">
                     <label for="logadouroRealizarPedido">Logradouro:</label>
                     <input type="text" name="logadouroRealizarPedido" id="logadouroRealizarPedido" required class="form-control" placeholder="Informe aqui o logradouro da empresa...">
                     <label for="numeroRealizarPedido">Número:</label>
                     <input type="text" name="numeroRealizarPedido" id="numeroRealizarPedido" required class="form-control" placeholder="Informe aqui o número da empresa...">
                     <label for="complementoRealizarPedido">Complemento:</label>
                     <input type="text" name="complementoRealizarPedido" id="complementoRealizarPedido" class="form-control" placeholder="Informe aqui o complemento da empresa...">
                     <label for="bairroRealizarPedido">Bairro:</label>
                     <input type="text" name="bairroRealizarPedido" id="bairroRealizarPedido" required class="form-control" placeholder="Informe aqui o bairro da empresa..">
                     <label for="cidadeRealizarPedido">Cidade:</label>
                     <input type="text" name="cidadeRealizarPedido" id="cidadeRealizarPedido" required class="form-control" placeholder="Informe aqui a cidade da empresa..">
                     <label for="estadoRealizarPedido">Estado:</label>
                     <select name="estadoRealizarPedido" id="estadoRealizarPedido" required class="form-control">
                     <option value="">UF</option>
                    ';
        $sql = "SELECT * FROM states ORDER BY sigla ASC";
        $query2 = mysqli_query($con, $sql);
        while ($row2 = mysqli_fetch_array($query2)) {
            $html .= '<option value="'.$row2['sigla'].'">'.$row2['sigla'].'</option>';
        }
                $html .= '
                </select>
                <label for="tipoEstabelecimentoRealizarPedido">Tipo do Estabelecimento:</label>
                     <select name="tipoEstabelecimentoRealizarPedido" id="tipoEstabelecimentoRealizarPedido" required class="form-control" onchange="selecionaTipoEstabelecimento(this.value)">
                     <option value="">Selecione o tipo do estabelecimento abaixo...</option>
                     <option value="1">Mesas</option>
                     <option value="2">Caixa</option>
                     </select>
                     <span id="tiposEstabelecimentoRealizarPedido">Selecione o tipo do estabelecimento acima...</span>';
        }
        if ($_REQUEST['product'] == 4){
            $html = '<label for="nomeEscolaRealizarPedido">Nome da Escola:</label>
                     <input type="text" name="nomeEscolaRealizarPedido" id="nomeEscolaRealizarPedido" required class="form-control" placeholder="Informe aqui o nome da escola..">
                     <label for="emailEscolaRealizarPedido">Email da Escola:</label>
                     <input type="text" name="emailEscolaRealizarPedido" id="emailEscolaRealizarPedido" required class="form-control" placeholder="Informe aqui o email da escola..">
                     <label for="cepEscolaRealizarPedido">CEP:</label>
                     <input type="text" name="cepEscolaRealizarPedido" id="cepEscolaRealizarPedido" onkeyup="pesquisacepEscolaRealizarPedido(this.value)" onkeypress="return mascara(this, \'00000-000\', event)" required class="form-control" placeholder="Informe aqui o cep da escola... Somente Números...">
                     <label for="logadouroEscolaRealizarPedido">Logradouro:</label>
                     <input type="text" name="logadouroEscolaRealizarPedido" id="logadouroEscolaRealizarPedido" required class="form-control" placeholder="Informe aqui o logradouro da escola...">
                     <label for="numeroEscolaRealizarPedido">Número:</label>
                     <input type="text" name="numeroEscolaRealizarPedido" id="numeroEscolaRealizarPedido" required class="form-control" placeholder="Informe aqui o número da escola...">
                     <label for="complementoEscolaRealizarPedido">Complemento:</label>
                     <input type="text" name="complementoEscolaRealizarPedido" id="complementoEscolaRealizarPedido" class="form-control" placeholder="Informe aqui o complemento da escola...">
                     <label for="bairroEscolaRealizarPedido">Bairro:</label>
                     <input type="text" name="bairroEscolaRealizarPedido" id="bairroEscolaRealizarPedido" required class="form-control" placeholder="Informe aqui o bairro da escola..">
                     <label for="cidadeEscolaRealizarPedido">Cidade:</label>
                     <input type="text" name="cidadeEscolaRealizarPedido" id="cidadeEscolaRealizarPedido" required class="form-control" placeholder="Informe aqui a cidade da escola..">
                     <label for="estadoEscolaRealizarPedido">Estado:</label>
                     <select name="estadoEscolaRealizarPedido" id="estadoEscolaRealizarPedido" required class="form-control">
                     <option value="">UF</option>
                    ';
        $sql = "SELECT * FROM states ORDER BY sigla ASC";
        $query2 = mysqli_query($con, $sql);
        while ($row2 = mysqli_fetch_array($query2)) {
            $html .= '<option value="'.$row2['sigla'].'">'.$row2['sigla'].'</option>';
        }
                $html .= '
                </select>
                <label for="tipoNotaRealizarPedido">Tipo de Nota:</label>
                     <select name="tipoNotaRealizarPedido" id="tipoNotaRealizarPedido" required class="form-control">
                     <option value="">Selecione o tipo de nota abaixo...</option>
                     <option value="1">Bimestral</option>
                     <option value="2">Trimestral</option>
                     <option value="3">Semestral</option>
                     <option value="4">Anual</option>
                     </select>
                <label for="turnoEscolaRealizarPedido">Turno da Escola:</label>
                     <select name="turnoEscolaRealizarPedido" id="turnoEscolaRealizarPedido" required class="form-control">
                     <option value="">Selecione o turno da escola abaixo...</option>
                     <option value="1">Manhã</option>
                     <option value="2">Tarde</option>
                     <option value="3">Noite</option>
                     <option value="4">Único</option>
                     <option value="5">Todos</option>
                     </select>
                <label for="letraEscolaRealizarPedido">Letra da Escola:</label>
                     <select name="letraEscolaRealizarPedido" id="letraEscolaRealizarPedido" required class="form-control">
                     <option value="">Selecione até que letra a escola vai abaixo...</option>';
                     for($i = 0; $i <= 26; $i++) {
                         switch ($i){
                             case 0:
                                 $letra = "Única";
                                 $l = "Un";
                                 break;
                             case 1:
                                 $letra = "A";
                                 break;
                             case 2:
                                 $letra = "B";
                                 break;
                             case 3:
                                 $letra = "C";
                                 break;
                             case 4:
                                 $letra = "D";
                                 break;
                             case 5:
                                 $letra = "E";
                                 break;
                             case 6:
                                 $letra = "F";
                                 break;
                             case 7:
                                 $letra = "G";
                                 break;
                             case 8:
                                 $letra = "H";
                                 break;
                             case 9:
                                 $letra = "I";
                                 break;
                             case 10:
                                 $letra = "J";
                                 break;
                             case 11:
                                 $letra = "K";
                                 break;
                             case 12:
                                 $letra = "L";
                                 break;
                             case 13:
                                 $letra = "M";
                                 break;
                             case 14:
                                 $letra = "N";
                                 break;
                             case 15:
                                 $letra = "O";
                                 break;
                             case 16:
                                 $letra = "P";
                                 break;
                             case 17:
                                 $letra = "Q";
                                 break;
                             case 18:
                                 $letra = "R";
                                 break;
                             case 19:
                                 $letra = "S";
                                 break;
                             case 20:
                                 $letra = "T";
                                 break;
                             case 21:
                                 $letra = "U";
                                 break;
                             case 22:
                                 $letra = "V";
                                 break;
                             case 23:
                                 $letra = "W";
                                 break;
                             case 24:
                                 $letra = "X";
                                 break;
                             case 25:
                                 $letra = "Y";
                                 break;
                             case 26:
                                 $letra = "Z";
                                 break;
                         }
                         if ($i > 0){
                             $l = $letra;
                         }
                         $html .= '<option value="'.$l.'">'.$letra.'</option>';
                     }
                     $html .= '
                     </select>';
        }
        echo "1|-|".$html;
        break;
    case "selecionaProduto":
        $sql = "SELECT * FROM products_items WHERE product = '".$_REQUEST['product']."' AND status = '1'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)) {
            $html = '<label for="produtoItemRealizarPedido">Selecione o item do produto:</label>
                                            <select name="produtoItemRealizarPedido" id="produtoItemRealizarPedido" required class="form-control" onchange="selecionaProdutoItem(\''.$_REQUEST['product'].'\', \''.URL.'\', this.value)">
                                                <option value="">Selecione o item do produto abaixo corretamente...</option>
                                                ';
            while ($row = mysqli_fetch_array($query)) {
                $valor = (date('Y-m-d') > $row['validaty_promotion']) ? $row['promotion'] : $row['value'];
                $html .= '<option value="'.$row['id'].'">'.($row['name']).' - R$'.number_format($valor, 2, ',', '.').'</option>
';
            }
                                                $html .= '</select><div id="passo03" style="display: none"></div>';
        }
        else{
            $html = "Sem nenhum item do produto encontrado em nossa base de dados!";
        }
        echo "1|-|".$html;
        break;
    case "detalhesPedido":
        $sql = "SELECT a.*, b.name AS nomeCliente, b.email AS emailCliente, b.document AS documentoCliente, c.name AS nomeTipoDocumento, d.name AS nomeFormaPagamento, 
                e.name AS nomeStatus, f.name AS nomeEndereco, f.cep AS cepEndereco, f.address AS endereco, f.number, f.complement, f.neighborhood, f.city, f.state
                FROM requests a 
                INNER JOIN clients b ON (a.client = b.id)
                INNER JOIN type_documents c ON (b.typeDocument = c.id)
                INNER JOIN payment_methods d ON (a.paymentMethod = d.id)
                INNER JOIN requests_statuses e ON (a.status = e.id)
                INNER JOIN addresses f ON (a.address = f.id)
                WHERE a.id = '".$_GET['id']."'";
        $query = mysqli_query($con, $sql);
        $rowPedido = mysqli_fetch_array($query);
        $sql = "SELECT a.* FROM requests_items a WHERE a.request = '".$_GET['id']."'";
        $query = mysqli_query($con, $sql);
        while($rowItensPedido = mysqli_fetch_array($query)){
            $pedidosItens[] = $rowItensPedido;
        }
        echo '1|-|<button type"button" class="close" onClick=fecha("detalhesPedido")><span aria-hidden="true">&times;</span></button>
            <h5>Detalhes do Pedido '.sprintf("%06s\n", $_GET['id']).'</h5>
            <h6><img src="'.URL.'img/cliente.png" width="30"> Dados do Cliente</h6>
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <th>Nome do cliente</th>
                    <th>Email do cliente</th>
                </tr>
                <tr>
                    <td style="text-align:center">'.($rowPedido['nomeCliente']).'</td>
                    <td style="text-align:center">'.$rowPedido['emailCliente'].'</td>
                </tr>
               <tr>
                   <th>Tipo de Documento do cliente</th>
                   <th>Documento do cliente</th>
                </tr> 
                <tr>
                    <td style="text-align:center">'.$rowPedido['nomeTipoDocumento'].'</td>
                    <td style="text-align:center">'.$rowPedido['documentoCliente'].'</td>
                </tr>           
            </table>
            <h6><img src="'.URL.'img/pedido.png" width="30"> Dados do Pedido</h6>
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <th>Número do Pedido</th>
                    <th>Data do Pedido</th>
                </tr>
                <tr>
                    <td style="text-align:center">'.sprintf("%06s\n", $rowPedido['id']).'</td>
                    <td style="text-align:center">';
        $vet = explode(" ", $rowPedido['created_at']);
        $vet2 = explode("-", $vet[0]);
        echo $vet2[2]."/".$vet2[1].'/'.$vet2[0].' às '.$vet[1].'h</td>
                </tr>
               <tr>
                   <th>Nome da Forma de Pagamento</th>
                   <th>Status do Pedido</th>
                </tr> 
                <tr>
                    <td style="text-align:center">'.($rowPedido['nomeFormaPagamento']).'</td>
                    <td style="text-align:center">'.($rowPedido['nomeStatus']);
        if ($rowPedido['status'] <= 3){
            echo " - <a href='".URL."efetuarPagamento?id=".$rowPedido['id']."' target='_blank'>Efetuar Pagamento</a>";
        }
        echo '</td>
                </tr>           
            </table>
            <h6><img src="'.URL.'img/carrinho.png" width="30"> Produtos Comprados</h6>
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                   <th style="text-align: center">ID do Item de Produto</th>
                   <th style="text-align: center">Nome Produto</th>
                   <th style="text-align: center">Quantidade</th>
                   <th style="text-align: center">Valor Unitário</th>
                   <th style="text-align: center">Valor Total</th>
                </tr>
                ';
        foreach ($pedidosItens as $key => $itens){
            foreach($itens as $chave => $valor){
                $itens[$chave] = ($valor);
            }
            echo '<tr>
                        <td style="text-align: center">'.$itens['product_item'].'</td>
                        <td style="text-align: center">'.$itens['name'];
            if ($itens['domine']) {
                echo " - <a href='".$itens['domine']."' target='_blank' title='".$itens['domine']."'>".substr($itens['domine'], 0, 15)."...</a>";
            }
            if ($itens['school_system']){
                $sql = "SELECT * FROM school_system WHERE id = '".$itens['school_system']."'";
                $query2 = mysqli_query($con, $sql);
                $rowSistemaEscolar = mysqli_fetch_array($query2);
                if ($rowSistemaEscolar['tipoNota'] == 1){
                    $rowSistemaEscolar['tipoNota'] = "Bimestral";
                }
                elseif ($rowSistemaEscolar['tipoNota'] == 2){
                    $rowSistemaEscolar['tipoNota'] = "Trimestral";
                }
                elseif ($rowSistemaEscolar['tipoNota'] == 3){
                    $rowSistemaEscolar['tipoNota'] = "Semestral";
                }
                elseif ($rowSistemaEscolar['tipoNota'] == 4){
                    $rowSistemaEscolar['tipoNota'] = "Anual";
                }
                if ($rowSistemaEscolar['turno'] == 1){
                    $rowSistemaEscolar['turno'] = "Manhã";
                }
                elseif ($rowSistemaEscolar['turno'] == 2){
                    $rowSistemaEscolar['turno'] = "Tarde";
                }
                elseif ($rowSistemaEscolar['turno'] == 3){
                    $rowSistemaEscolar['turno'] = "Noite";
                }
                elseif ($rowSistemaEscolar['turno'] == 4){
                    $rowSistemaEscolar['turno'] = "Único";
                }
                elseif ($rowSistemaEscolar['turno'] == 5){
                    $rowSistemaEscolar['turno'] = "Todos";
                }
                if ($rowSistemaEscolar['letra'] == "Un"){
                    $rowSistemaEscolar['letra'] = "Única";
                }
                echo ' - <a onclick="verInformacoesSistemaEscolar(\''.$itens['school_system'].'\')" style="color: #0077A4; cursor: pointer" title="Ver informações do sistema">Ver Informações do Sistema</a>
                            <div id="informacoesSistemaEscolar'.$itens['school_system'].'" style="display: none; position:absolute; width:92%; background-color:#FFFFFF; color:#000000">
                                <button type"button" class="close" onClick=fecha("informacoesSistemaEscolar'.$itens['school_system'].'")><span aria-hidden="true">&times;</span></button>
                                <h3>Informações do Sistema Escolar</h3>
                                <b>Nome da Escola:</b> '.$rowSistemaEscolar['nome'].'<br>
                                <b>Email da Escola:</b> '.$rowSistemaEscolar['email'].'<br>
                                <b>CEP da Escola:</b> '.$rowSistemaEscolar['cep'].'<br>
                                <b>Logradouro da Escola:</b> '.$rowSistemaEscolar['logradouro'].'<br>
                                <b>Número da Escola:</b> '.$rowSistemaEscolar['numero'].'<br>';
                if ($rowSistemaEscolar['complemento']){
                    echo '<b>Complemento:</b> '.$rowSistemaEscolar['complemento'].'<br>';
                }
                echo '<b>Bairro da Escola:</b> '.$rowSistemaEscolar['bairro'].'<br>
                                <b>Cidade da Escola:</b> '.$rowSistemaEscolar['cidade'].'<br>
                                <b>Estado da Escola:</b> '.$rowSistemaEscolar['estado'].'<br>
                                <b>Tipo de Nota da Escola:</b> '.$rowSistemaEscolar['tipoNota'].'<br>
                                <b>Turno da Escola:</b> '.$rowSistemaEscolar['turno'].'<br>
                                <b>Letra da Escola:</b> '.$rowSistemaEscolar['letra'].'
                            </div>';
            }
            if ($itens['cashier_system']) {
                $sql = "SELECT * FROM cashier_system WHERE id = '" . $itens['cashier_system'] . "'";
                $query2 = mysqli_query($con, $sql);
                $rowSistemaCaixa = mysqli_fetch_array($query2);
                echo ' - <a onclick="verInformacoesSistemaCaixa(' . $itens['cashier_system'] . ')" style="color: #0077A4; cursor: pointer" title="Ver informações do sistema">Ver Informações do Sistema</a>
                    <div id="informacoesSistemaCaixa' . $itens['cashier_system'] . '" style="display: none; position:absolute; width:92%; background-color:#FFFFFF; color:#000000">
                                <button type"button" class="close" onClick=fecha("informacoesSistemaCaixa' . $itens['cashier_system'] . '")><span aria-hidden="true">&times;</span></button>
                                <h3>Informações do Sistema de Caixa</h3>
                                <b>Razão Social:</b> ' . $rowSistemaCaixa['razao_social'] . '<br>
                                <b>Nome Fantasia:</b> ' . $rowSistemaCaixa['nome_fantasia'] . '<br>
                                <b>Email:</b> ' . $rowSistemaCaixa['email'] . '<br>
                                <b>CNPJ:</b> ' . $rowSistemaCaixa['cnpj'] . '<br>
                                <b>CEP:</b> ' . $rowSistemaCaixa['cep'] . '<br>
                                <b>Logradouro:</b> ' . $rowSistemaCaixa['logradouro'] . '<br>
                                <b>Número:</b> ' . $rowSistemaCaixa['numero'] . '<br>';
                if ($rowSistemaCaixa['complemento']) {
                    echo '<b>Complemento:</b> ' . $rowSistemaCaixa['complemento'] . '<br>';
                }
                echo '<b>Bairro:</b> ' . $rowSistemaCaixa['bairro'] . '<br>
                                <b>Cidade:</b> ' . $rowSistemaCaixa['cidade'] . '<br>
                                <b>Estado:</b> ' . $rowSistemaCaixa['estado'] . '<br>
                                <b>Tipo de Estabelecimento:</b> ';
                if ($rowSistemaCaixa['tipoEstabelecimento'] == 1) {
                    echo 'Mesa';
                } else {
                    echo 'Caixa';
                }
                echo '<br>
                                <b>Quantidade de ';
                if ($rowSistemaCaixa['tipoEstabelecimento'] == 1) {
                    echo 'Mesas';
                } else {
                    echo 'Caixas';
                }
                echo ':</b> ' . $rowSistemaCaixa['quantidade'];
                if ($rowSistemaCaixa['tipoEstabelecimento'] == 1) {
                    echo '<br>
                                <b>Número Pessoas Por Mesa:</b> ' . $rowSistemaCaixa['numeroPessoasPorMesa'] . '<br>
                                <b>Gorjeta do Garçom:</b> ' . $rowSistemaCaixa['percentual'] . '%
                            </div>';
                }
            }
            echo '</td>
                 <td style="text-align: center">'.$itens['quantity'].'</td>
                 <td style="text-align: center">R$ '.number_format($itens['value'], 2, ',','.').'</td>
                 <td style="text-align: center">R$ '.number_format($itens['value'] * $itens['quantity'], 2, ',','.').'</td>
            </tr>';
        }
        echo '
            </table>
            <h6><img src="'.URL.'img/endereco.png" width="30"> Dados do Endereço</h6>
            <b>Nome do Endereço:</b> '.($rowPedido['nomeEndereco']).'<br>
            <b>CEP do Endereço:</b> '.($rowPedido['cepEndereco']).'<br>
            <b>Endereço:</b> '.($rowPedido['endereco'].', '.$rowPedido['number']);
            if ($rowPedido['complement']){
                echo ', '.($rowPedido['complement']);
            }
            echo " - B. ".($rowPedido['neighborhood']." - ".$rowPedido['city']." - ".$rowPedido['state']);
        break;
    case "pegaPedidos":
        $sql = "SELECT a.*, b.name AS nomeClient, c.name AS nomeStatus, d.name AS nomeFormaPagamento 
                FROM requests a INNER JOIN clients b ON (a.client = b.id) 
                INNER JOIN requests_statuses c ON (a.status = c.id) 
                INNER JOIN payment_methods d ON (a.paymentMethod= d.id)
                WHERE a.client = '".$_REQUEST['idClient']."' ORDER BY a.created_at DESC";
        $query = mysqli_query($con, $sql);
        $html = "<a id='topoPedidos'></a>";
        if (!mysqli_num_rows($query)){
            $html .= '<div style="background-color: #FF0000; color: #FFFFFF; padding:15px; text-align: center"><h5>Nenhum pedido encontrado!</h5></div>';
        }
        else{
            while ($row = mysqli_fetch_array($query)) {
                if ($row['status'] == 1){
                    $backgroundColor = "#000000";
                    $color = "#FFFFFF";
                }
                elseif ($row['status'] == 2){
                    $backgroundColor = "#FFFF00";
                    $color = "#000000";
                }
                elseif ($row['status'] == 3){
                    $backgroundColor = "#006600";
                    $color = "#FFFFFF";
                }
                elseif ($row['status'] == 4){
                    $backgroundColor = "#000033";
                    $color = "#FFFFFF";
                }
                elseif ($row['status'] == 5){
                    $backgroundColor = "#FF0000";
                    $color = "#FFFFFF";
                }
                $html .= '<div onclick="detalhesPedido(\''.$row['id'].'\', \''.URL.'\'); location.href=\'#topoPedidos\'" style="float:left; width:33%; padding:15px; cursor:pointer; background-color: '.$backgroundColor.'; color: '.$color.'; text-align: center"><h5>Pedido '.sprintf("%06s\n", $row['id']).'</h5><p>Cliente: <b>'.($row['nomeClient']).'</b><br>Forma de Pagamento: <b>'.($row['nomeFormaPagamento']).'</b><br>Status do Pedido: <b>'.($row['nomeStatus']).'</b></p></div>';
            }
        }
        echo "1|-|".$html;
        break;
    case "pegaEnderecos":
        $html = '<button type="button" class="btn btn-primary" onclick="novoEndereco()">Cadastrar Novo</button>
        <div id="novoEndereco" style="display:none; position: absolute; background-color: #FFFFFF; width:97%">
            <h5>Cadastro de Endereço</h5>
            <button type="button" class="close" onClick=fecha("novoEndereco")>
                <span aria-hidden="true">&times;</span>
            </button>
            <form name="formCadastroEndereco" id="formCadastroEndereco" method="head">
                <input type="hidden" id="urlEndereco" nome="urlEndereco" value="'.URL.'">     
                <input type="hidden" id="idClienteEndereco" nome="idClienteEndereco" value="'.$_REQUEST['idCliente'].'">                          
                <label for="nome">Nome do Endereço:</label>
                <input type="text" placeholder="Nome do Endereço..." name="nome" id="nome" required class="form-control">
                <label for="cepEndereco">Cep:</label>
                <input type="text" placeholder="Cep..." name="cepEndereco" onkeyup="pesquisacep(this.value)" onkeypress="return mascara(this, \'00000-000\', event)" id="cepEndereco" required class="form-control">
                <sup>Somente Números</sup><br>
                <label for="logradouroEndereco">Logradouro:</label>
                <input type="text" placeholder="Logradouro..." name="logradouroEndereco" id="logradouroEndereco" required class="form-control">
                <label for="numeroEndereco">Número:</label>
                <input type="text" placeholder="Número..." name="numeroEndereco" id="numeroEndereco" required class="form-control">
                <label for="complementoEndereco">Complemento:</label>
                <input type="text" placeholder="Complemento..." name="complementoEndereco" id="complementoEndereco" class="form-control">
                <label for="bairroEndereco">Bairro:</label>
                <input type="text" placeholder="Bairro..." name="bairroEndereco" id="bairroEndereco" required class="form-control">
                <label for="cidadeEndereco">Cidade:</label>
                <input type="text" placeholder="Cidade..." name="cidadeEndereco" id="cidadeEndereco" required class="form-control">
                <label for="estadoEndereco">Estado:</label>
                <select name="estadoEndereco" id="estadoEndereco" required class="form-control">
                    <option value="">UF</option>
                    ';
        $sql = "SELECT * FROM states ORDER BY sigla ASC";
        $query2 = mysqli_query($con, $sql);
        while ($row2 = mysqli_fetch_array($query2)) {
            $html .= '<option value="'.$row2['sigla'].'">'.$row2['sigla'].'</option>';
        }
        $html .= '
                </select>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onClick=fecha("novoEndereco")>Fechar</button>
                    <button type="button" onclick=salvarEndereco("'.URL.'") class="btn btn-primary">Salvar Endereço</button>
                </div>       
            </form>
        </div>';
        $html .= '<div id="editaEndereco" style="display:none; position: absolute; background-color: #FFFFFF; width:97%">
            <h5>Atualização de Endereço</h5>
            <button type="button" class="close" onClick=fecha("editaEndereco")>
                <span aria-hidden="true">&times;</span>
            </button>
            <form name="formEditaEndereco" id="formEditaEndereco" method="head">
                <input type="hidden" id="urlEditaEndereco" nome="urlEditaEndereco" value="'.URL.'">     
                <input type="hidden" id="idClienteEditaEndereco" nome="idClienteEditaEndereco" value="'.$_REQUEST['idCliente'].'">  
                <input type="hidden" id="idEditaEndereco" nome="idEditaEndereco" value="">                          
                <label for="nomeEdita">Nome do Endereço:</label>
                <input type="text" placeholder="Nome do Endereço..." name="nome" id="nomeEdita" required class="form-control">
                <label for="cepEditaEndereco">Cep:</label>
                <input type="text" placeholder="Cep..." name="cepEditaEndereco" onkeyup="pesquisacepedit(this.value)" onkeypress="return mascara(this, \'00000-000\', event)" id="cepEditaEndereco" required class="form-control">
                <sup>Somente Números</sup><br>
                <label for="logradouroEditaEndereco">Logradouro:</label>
                <input type="text" placeholder="Logradouro..." name="logradouroEditaEndereco" id="logradouroEditaEndereco" required class="form-control">
                <label for="numeroEditaEndereco">Número:</label>
                <input type="text" placeholder="Número..." name="numeroEditaEndereco" id="numeroEditaEndereco" required class="form-control">
                <label for="complementoEditaEndereco">Complemento:</label>
                <input type="text" placeholder="Complemento..." name="complementoEditaEndereco" id="complementoEditaEndereco" class="form-control">
                <label for="bairroEditaEndereco">Bairro:</label>
                <input type="text" placeholder="Bairro..." name="bairroEditaEndereco" id="bairroEditaEndereco" required class="form-control">
                <label for="cidadeEditaEndereco">Cidade:</label>
                <input type="text" placeholder="Cidade..." name="cidadeEditaEndereco" id="cidadeEditaEndereco" required class="form-control">
                <label for="estadoEditaEndereco">Estado:</label>
                <select name="estadoEditaEndereco" id="estadoEditaEndereco" required class="form-control">
                    <option value="">UF</option>
                ';
        $sql = "SELECT * FROM states ORDER BY sigla ASC";
        $query2 = mysqli_query($con, $sql);
        while ($row2 = mysqli_fetch_array($query2)) {
            $html .= '<option value="'.$row2['sigla'].'">'.$row2['sigla'].'</option>';
        }
        $html .= '
                </select>
                <div class="modal-footer" id="botoesEditaEndereco">
                    <button type="button" class="btn btn-secondary" onClick=fecha("editaEndereco")>Fechar</button>
                    <button type="button" onclick=editarEndereco("'.URL.'") class="btn btn-primary">Atualizar Endereço</button>
                </div>       
            </form>
        </div>';
        $sql = "SELECT * FROM addresses WHERE idClient = '".$_REQUEST['idCliente']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            $html .= '<table border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <th>Nome do Endereço</th>
                    <th>CEP do Endereço</th>
                    <th>Endereço</th>
                    <th>Ações</th>
                </tr>';
            while ($row = mysqli_fetch_array($query)){
                $html .= '<tr';
                if ($i % 2 == 0){
                    $html .= ' style="background-color:#e7e7e7"';
                }
                $html .= '><td>'.($row['name'].'</td><td>'.$row['cep'].'</td><td>'.$row['address'].' - '.$row['number']);
                if ($row['complement']){
                    $html .= ' - '.($row['complement']);
                }
                $html .= ' - '.($row['neighborhood'].' - '.$row['city'].' - '.$row['state']).'</td><td><img src="'.URL.'img/editar.png" width="20" onclick=\'abre("editaEndereco");editaEndereco("'.$row['id'].'","'.URL.'","'.$row['idClient'].'")\' style="cursor:pointer"> <img src="'.URL.'img/excluir.png" width="20" style="cursor:pointer" onclick=excluirEndereco("'.$row['id'].'","'.URL.'","'.$row['idClient'].'")></td></tr>';
                $i++;
            }
            $html .= "</table>";
        }
        else{
            $html .= "<center>Sem nenhum endereço cadastrado!</center>";
        }
        echo "1|-|".$html;
        break;
    case "editarEndereco":
        $sql = "SELECT * FROM addresses WHERE id = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        echo ("1|-|".$row['id']."|-|".$row['name']."|-|".$row['cep']."|-|".$row['address']."|-|".$row['number']."|-|".$row['complement']."|-|".$row['neighborhood']."|-|".$row['city']."|-|".$row['state']);
        break;
    case "excluirEndereco":
        $sql = "SELECT * FROM addresses WHERE id = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        $sql = "INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_REQUEST['user']."', '".("Excluiu o endereço do cliente ").$row['idClient']." - ID: ".$_REQUEST['id']."', now(), now())";
        mysqli_query($con, $sql);
        $sql = "DELETE FROM addresses WHERE id = '".$_REQUEST['id']."'";
        mysqli_query($con, $sql);
        echo '1';
        break;
    case "cadastraEndereco":
        $sql = ("INSERT INTO addresses (idClient, name, cep, address, number, complement, neighborhood, city, state, created_at, updated_at) VALUES ('".$_REQUEST['idCliente']."', '".$_REQUEST['nome']."', '".$_REQUEST['cepEndereco']."', '".$_REQUEST['logradouroEndereco']."', '".$_REQUEST['numeroEndereco']."', '".$_REQUEST['complementoEndereco']."', '".$_REQUEST['bairroEndereco']."', '".$_REQUEST['cidadeEndereco']."', '".$_REQUEST['estadoEndereco']."', now(), now())");
        mysqli_query($con, $sql);
        echo "1";
        break;
    case "salvarEndereco":
        $sql = ("INSERT INTO addresses (idClient, name, cep, address, number, complement, neighborhood, city, state, created_at, updated_at) VALUES ('".$_REQUEST['idClienteEndereco']."', '".$_REQUEST['nome']."', '".$_REQUEST['cepEndereco']."', '".$_REQUEST['logradouroEndereco']."', '".$_REQUEST['numeroEndereco']."', '".$_REQUEST['complementoEndereco']."', '".$_REQUEST['bairroEndereco']."', '".$_REQUEST['cidadeEndereco']."', '".$_REQUEST['estadoEndereco']."', now(), now())");
        mysqli_query($con, $sql);
        echo "1";
        break;
    case "atualizarEndereco":
        $sql = "INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_REQUEST['user']."', '".("Atualizou o endereço do cliente ").$_REQUEST['idCliente']." - ID: ".$_REQUEST['idEndereco']."', now(), now())";
        mysqli_query($con, $sql);
        $sql = ("UPDATE addresses SET idClient = '".$_REQUEST['idCliente']."', name = '".$_REQUEST['nome']."', cep = '".$_REQUEST['cepEndereco']."', address = '".$_REQUEST['logradouroEndereco']."', number = '".$_REQUEST['numeroEndereco']."', complement = '".$_REQUEST['complementoEndereco']."', neighborhood = '".$_REQUEST['bairroEndereco']."', city = '".$_REQUEST['cidadeEndereco']."', state = '".$_REQUEST['estadoEndereco']."', updated_at = now() WHERE id = '".$_REQUEST['idEndereco']."'");
        mysqli_query($con, $sql);
        echo "1";
        break;
    case "visualizaEnderecos":
        echo '1|-|';
        $sql = "INSERT INTO logs (user, action, created_at, updated_at) VALUES ('".$_REQUEST['user']."', '".("Visualizou os endereços do cliente ").$_REQUEST['id']."', now(), now())";
        mysqli_query($con, $sql);
        echo '<button type="button" class="btn btn-primary" onclick=abre("modalCadastraEndereco")>Cadastrar novo</button>
                <div style="display:none; position:absolute; width: 100%" id="modalCadastraEndereco" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">'.("Cadastro de Endereço").'</h5>
                                <button type="button" class="close" onclick=fecha("modalCadastraEndereco")>
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="#" method="get" id="formAtualizaEndereco"> 
                                <div class="modal-body"> 
                                    <input type="hidden" id="idCliente" name="idCliente" value="'.$_REQUEST['id'].'"> 
                                    <input type="hidden" id="urlEndereco" nome="urlEndereco" value="'.URL.'">                          
                                    <label for="cepEndereco">Nome do Endereço:</label>
                                    <input type="text" placeholder="Nome do Endereço..." value="" name="nome" value="" id="nome" required class="form-control">
                                    <label for="cepEndereco">Cep:</label>
                                    <input type="text" placeholder="Cep..." name="cepEndereco" value="" onkeypress=mascara(this,"00000-000",event) id="cepEndereco" required class="form-control" onkeyup=verificacepcadastraendereco(this.value)>
                                    <sup>Somente Números</sup><br>
                                    <label for="logradouroEndereco">Logradouro:</label>
                                    <input type="text" placeholder="Logradouro..." value="" name="logradouroEndereco" id="logradouroEndereco" required class="form-control">
                                    <label for="numeroEndereco">Número:</label>
                                    <input type="text" placeholder="Número..." value="" name="numeroEndereco" id="numeroEndereco" required class="form-control">
                                    <label for="complementoEndereco">Complemento:</label>
                                    <input type="text" placeholder="Complemento..." value="" name="complementoEndereco" id="complementoEndereco" class="form-control">
                                    <label for="bairroEndereco">Bairro:</label>
                                    <input type="text" placeholder="Bairro..." value="" name="bairroEndereco" id="bairroEndereco" required class="form-control">
                                    <label for="cidadeEndereco">Cidade:</label>
                                    <input type="text" placeholder="Cidade..." value="" name="cidadeEndereco" id="cidadeEndereco" required class="form-control">
                                    <label for="estadoEndereco">Estado:</label>
                                    <select name="estadoEndereco" id="estadoEndereco" required class="form-control">
                                        <option value="">UF</option>
                                        ';
        $sql = "SELECT * FROM states ORDER BY sigla ASC";
        $query2 = mysqli_query($con, $sql);
        while ($row2 = mysqli_fetch_array($query2)) {
            echo '
                                        <option value="'.$row2['sigla'].'">'.$row2['sigla'].'</option>';
        }
        echo '
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" onclick=fecha("modalCadastraEndereco")>Fechar</button>
                                    <button type="button" class="btn btn-primary" onClick=cadastrarEndereco("","'.URL.'","'.$_REQUEST['id'].'","'.$_REQUEST['user'].'")>Cadastrar Endereço</button>
                                </div>
                                </form>
                            </div>
                            </div>
                            </div>';
        $sql = "SELECT * FROM addresses WHERE idClient = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        if (!mysqli_num_rows($query)){
            echo "<div style='width:100%; background-color:#990000; color:#FFFFFF; text-align: center' id='registros'>Nenhum endereço encontrado!</div>";
        }
        else{
            echo '<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr><th>Nome do Endereço</th><th>CEP do Endereço</th><th>Endereço</th><th>Ações</th></tr>';
            while($row = mysqli_fetch_array($query)){
                echo ('<tr');
                if ($i % 2 == 1){
                    echo ' style="background-color:#e7e7e7"';
                }
                echo ('><td>'.$row['name'].'</td><td>'.$row['cep'].'</td><td>'.$row['address'].' - '.$row['number']);
                if ($row['complement']){
                    echo (' - '.$row['complement']);
                }
                echo (' - B. '.$row['neighborhood'].' - '.$row['city'].' - '.$row['state'].'</td><td><a onclick=abre("modalAtualizaEndereco'.$row['id'].$_REQUEST['id'].'") style="cursor:pointer"><img src="'.URL.'img/editar.png" width="20"></a> <img src="'.URL.'img/excluir.png" style="cursor: pointer" onclick=excluirEndereco("'.$row['id'].'","'.URL.'","'.$_REQUEST['id'].'","'.$_REQUEST['user'].'") width="20"></td></tr>');
                echo '<script>  
function retornoCEPAtualizaEndereco'.$row['id'].$_REQUEST['id'].'(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById("logradouroEndereco'.$row['id'].$_REQUEST['id'].'").value=(conteudo.logradouro);
        document.getElementById(\'numeroEndereco'.$row['id'].$_REQUEST['id'].'\').value="";
        document.getElementById(\'complementoEndereco'.$row['id'].$_REQUEST['id'].'\').value="";
        document.getElementById(\'bairroEndereco'.$row['id'].$_REQUEST['id'].'\').value=(conteudo.bairro);
        document.getElementById(\'cidadeEndereco'.$row['id'].$_REQUEST['id'].'\').value=(conteudo.localidade);
        document.getElementById(\'estadoEndereco'.$row['id'].$_REQUEST['id'].'\').value=(conteudo.uf);
        document.getElementById(\'numeroEndereco'.$row['id'].$_REQUEST['id'].'\').focus();
    } //end if.
    else {
        //CEP não Encontrado.
        alert("CEP não encontrado. Digeite as informações manualmente!");
        document.getElementById(\'logradouroEndereco'.$row['id'].$_REQUEST['id'].'\').value="";
        document.getElementById(\'bairroEndereco'.$row['id'].$_REQUEST['id'].'\').value="";
        document.getElementById(\'numeroEndereco'.$row['id'].$_REQUEST['id'].'\').value="";
        document.getElementById(\'complementoEndereco'.$row['id'].$_REQUEST['id'].'\').value="";
        document.getElementById(\'cidadeEndereco'.$row['id'].$_REQUEST['id'].'\').value="";
        document.getElementById(\'estadoEndereco'.$row['id'].$_REQUEST['id'].'\').value="";
        document.getElementById(\'logradouroEndereco'.$row['id'].$_REQUEST['id'].'\').focus();
    }
}
                </script>
                <div style="display:none; position:absolute; width: 100%" id="modalAtualizaEndereco'.$row['id'].$_REQUEST['id'].'" tabindex="-1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">'.("Atualização de Endereço").'</h5>
                                <button type="button" class="close" onclick=fecha("modalAtualizaEndereco'.$row['id'].$_REQUEST['id'].'")>
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="#" method="get" id="formAtualizaEndereco"> 
                                <div class="modal-body"> 
                                    <input type="hidden" id="idCliente'.$row['id'].$_REQUEST['id'].'" name="idCliente'.$row['id'].$_REQUEST['id'].'" value="'.$_REQUEST['id'].'"> 
                                    <input type="hidden" id="idEndereco'.$row['id'].$_REQUEST['id'].'" name="idEndereco'.$row['id'].$_REQUEST['id'].'" value="'.$row['id'].'"> 
                                    <input type="hidden" id="urlEndereco" nome="urlEndereco" value="'.URL.'">                          
                                    <label for="cepEndereco">Nome do Endereço:</label>
                                    <input type="text" placeholder="Nome do Endereço..." value="'.($row['name']).'" name="nome'.$row['id'].$_REQUEST['id'].'" value="'.$row['name'].'" id="nome'.$row['id'].$_REQUEST['id'].'" required class="form-control">
                                    <label for="cepEndereco">Cep:</label>
                                    <input type="text" placeholder="Cep..." name="cepEndereco'.$row['id'].$_REQUEST['id'].'" value="'.$row['cep'].'" onkeypress="return mascara(this, \'00000-000\', event)" id="cepEndereco'.$row['id'].$_REQUEST['id'].'" required class="form-control" onkeyup=verificacepatualizaendereco(this.value,"'.$row['id'].'","'.$_REQUEST['id'].'")>
                                    <sup>Somente Números</sup><br>
                                    <label for="logradouroEndereco">Logradouro:</label>
                                    <input type="text" placeholder="Logradouro..." value="'.($row['address']).'" name="logradouroEndereco'.$row['id'].$_REQUEST['id'].'" id="logradouroEndereco'.$row['id'].$_REQUEST['id'].'" required class="form-control">
                                    <label for="numeroEndereco">Número:</label>
                                    <input type="text" placeholder="Número..." value="'.($row['number']).'" name="numeroEndereco'.$row['id'].$_REQUEST['id'].'" id="numeroEndereco'.$row['id'].$_REQUEST['id'].'" required class="form-control">
                                    <label for="complementoEndereco">Complemento:</label>
                                    <input type="text" placeholder="Complemento..." value="'.($row['complement']).'" name="complementoEndereco'.$row['id'].$_REQUEST['id'].'" id="complementoEndereco'.$row['id'].$_REQUEST['id'].'" class="form-control">
                                    <label for="bairroEndereco">Bairro:</label>
                                    <input type="text" placeholder="Bairro..." value="'.($row['neighborhood']).'" name="bairroEndereco'.$row['id'].$_REQUEST['id'].'" id="bairroEndereco'.$row['id'].$_REQUEST['id'].'" required class="form-control">
                                    <label for="cidadeEndereco">Cidade:</label>
                                    <input type="text" placeholder="Cidade..." value="'.($row['city']).'" name="cidadeEndereco'.$row['id'].$_REQUEST['id'].'" id="cidadeEndereco'.$row['id'].$_REQUEST['id'].'" required class="form-control">
                                    <label for="estadoEndereco">Estado:</label>
                                    <select name="estadoEndereco'.$row['id'].$_REQUEST['id'].'" id="estadoEndereco'.$row['id'].$_REQUEST['id'].'" required class="form-control">
                                        <option value="">UF</option>
                                        ';
        $sql = "SELECT * FROM states ORDER BY sigla ASC";
        $query2 = mysqli_query($con, $sql);
        while ($row2 = mysqli_fetch_array($query2)) {
            echo '
                                        <option value="'.$row2['sigla'].'" ';
            if ($row['state'] == $row2['sigla']){
                echo 'selected';
            }
            echo '>'.$row2['sigla'].'</option>';
        }
        echo '
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="button" class="btn btn-primary" onClick=atualizarEndereco("'.$row['id'].'","'.URL.'","'.$_REQUEST['id'].'","'.$_REQUEST['user'].'")>Atualizar Endereço</button>
                                </div>
                                </form>
                            </div>
                            </div>';
                $i++;
            }
            echo '</table>';
        }   echo '</div>';
        break;
    case "cadastro":
        if (!$_REQUEST['idCliente']) {
            $sql = "SELECT * FROM clients WHERE email = '" . $_REQUEST['emailCadastro'] . "'";
            $query = mysqli_query($con, $sql);
            if (!mysqli_num_rows($query)) {
                if ($_REQUEST['passwordCadastro'] != $_REQUEST['password2Cadastro']) {
                    echo "0|-|As senhas informadas não conferem! Confira!";
                } else {
                    $sql = ("INSERT INTO clients (name, email, cel, typeDocument, document, password, created_at, updated_at) VALUES ('" . $_REQUEST['nomeCadastro'] . "', '" . $_REQUEST['emailCadastro'] . "', '" . $_REQUEST['celularCadastro'] . "', '" . $_REQUEST['tipoDocumentoCadastro'] . "', '" . $_REQUEST['documentoCadastro'] . "', '" . md5($_REQUEST['passwordCadastro']) . "', now(), now())");
                    $query = mysqli_query($con, $sql);
                    $idCliente = mysqli_insert_id($con);
                    $_SESSION['cliente']['id'] = $idCliente;
                    $_SESSION['cliente']['nome'] = ($_REQUEST['nomeCadastro']);
                    $_SESSION['cliente']['email'] = $_REQUEST['emailCadastro'];
                    echo '1';
                }
            } else {
                echo "0|-|Esse email já está cadastrado em nosso site! Feche esta janela e clique em 'Esqueceu sua senha?'!";
            }
        }
        break;
    case "atualizarCadastro":
        $sql = "SELECT * FROM clients WHERE id = '".$_SESSION['cliente']['id']."'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($query);
        if ($row['email'] != $_REQUEST['emailCadastro']){
            $sql = "SELECT * FROM clients WHERE id != '".$_SESSION['cliente']['id']."' AND email = '".$_REQUEST['emailCadastro']."'";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query)){
                echo "0|-|Já existe outro cliente cadastrado com esse email. Utilize outro.";
            }
            else{
                $sql = ("UPDATE clients SET name = '".$_REQUEST['nomeCadastro']."', email = '".$_REQUEST['emailCadastro']."', cel = '".$_REQUEST['celularCadastro']."', typeDocument = '".$_REQUEST['tipoDocumentoCadastro']."', document = '".$_REQUEST['documentoCadastro']."', updated_at = now() WHERE id = '".$_REQUEST['idCliente']."'");
                mysqli_query($con, $sql);
                echo '1|-|'.$_REQUEST['nomeCadastro'];
            }
        }
        else {
            $sql = ("UPDATE clients SET name = '".$_REQUEST['nomeCadastro']."', email = '".$_REQUEST['emailCadastro']."', cel = '".$_REQUEST['celularCadastro']."', typeDocument = '".$_REQUEST['tipoDocumentoCadastro']."', document = '".$_REQUEST['documentoCadastro']."', updated_at = now() WHERE id = '".$_REQUEST['idCliente']."'");
            mysqli_query($con, $sql);
            echo ('1|-|'.$_REQUEST['nomeCadastro']);
        }
        break;
    case "atualizarSenha":
        $sql = "SELECT * FROM clients WHERE id = '".$_SESSION['cliente']['id']."' AND password = '".md5($_REQUEST['senhaAlterarSenha'])."'";
        $query = mysqli_query($con, $sql);
        if (!mysqli_num_rows($query)){
            echo "0|-|Senha informada incorretamente!|-|senhaAlterarSenha";
        }
        elseif($_REQUEST['novaSenhaAlterarSenha'] != $_REQUEST['redigitoSenhaAlterarSenha']){
            echo "0|-|Nova senha e redígito devem estar iguais!|-|novaSenhaAlterarSenha";
        }
        else{
            $sql = ("UPDATE clients SET password = '".md5($_REQUEST['novaSenhaAlterarSenha'])."', updated_at = now() WHERE id = '".$_REQUEST['idCliente']."'");
            mysqli_query($con, $sql);
            echo '1';
        }
        break;
    case "alterarSenha":
        if ($_REQUEST['password'] != $_REQUEST['password2']){
            echo "0|-|Senhas digitadas não coincidem!";
        }
        else{
            $sql = "UPDATE clients SET password = '".md5($_REQUEST['password'])."', updated_at = now(), remember_token = '' WHERE id = '".$_REQUEST['idCliente']."'";
            mysqli_query($con, $sql);
            $sql = "SELECT * FROM clients WHERE id = '".$_REQUEST['idCliente']."'";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($query);
            $_SESSION['cliente']['id'] = $row['id'];
            $_SESSION['cliente']['nome'] = $row['name'];
            $_SESSION['cliente']['email'] = $row['email'];
            echo "1|-|Senha alterada com sucesso!";
        }
        break;
    case "enviarEsqueceuSuaSenha":
        $sql = "SELECT * FROM clients WHERE email = '".$_REQUEST['emailEsqueceuSuaSenha']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)) {
            $row = mysqli_fetch_array($query);
            $remember_token = (rand(0, 9).rand(0,9).rand(0, 9).rand(0, 9).rand(0,9).rand(0,9));
            $sql = "UPDATE clients SET remember_token = '".$remember_token."', updated_at = now() WHERE id = '".$row['id']."'";
            mysqli_query($con, $sql);
            $htmlEmail = '<html><head><title>Email de recuperação de senha - BH Commerce</title></head><body><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="250" style="width: 250px; text-align: center;"><img src="'.URL.'img/logo.png" width="200"></td><td>Olá '.$row['name'].',<br><br>Para acessar o link para alterar a sua senha, <a href="'.URL.'alterar-senha?remember_token='.$remember_token.'">clique aqui</a>.<br><br>Atenciosamente,<br><br>Equipe BH Commerce</td></tr></table></body></html>';
            //echo $htmlEmail;
            $assuntoEmail = "Email de recuperação de senha - BH Commerce";
            $paraEmail = $row['nome']."<".$row['email'].">";
            $cabecalhoEmail = "Content-Type: text/html; charset=iso-8859-1\n";
            $cabecalhoEmail .= "From: Henrique Marcandier - BH Commerce<henrique@bhcommerce.com.br>\nReply-To: Henrique Marcandier - BH Commerce<henrique@bhcommerce.com.br>";
            mail($paraEmail, $assuntoEmail, $htmlEmail, $cabecalhoEmail);
            echo "1";
        }
        else{
            echo "0";
        }
        break;
    case "realizarLogin":
        $sql = "SELECT * FROM clients  WHERE email = '".$_REQUEST['emailLogin']."' AND password = '".md5($_REQUEST['passwordLogin'])."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            $row = mysqli_fetch_array($query);
            $_SESSION['cliente']['nome'] = $row['name'];
            $_SESSION['cliente']['email'] = $row['email'];
            $_SESSION['cliente']['id'] = $row['id'];
            echo "1";
        }
        else{
            echo "0|-|Não existe cliente com o email ou senha informados!";
        }
        break;
    case "salvarNews":
        $email['nome'] = "Henrique Marcandier - BH Commerce <henrique@bhcommerce.com.br>";
        $email['assunto'] = "Email cadastrado na newsletter com sucesso! - BH Commerce";
        $email['cabecalho'] = "Content-Type: text/html; charset=iso-8859-1\n";
        $email['cabecalho'] .= "From: Henrique Marcandier - BH Commerce<henrique@bhcommerce.com.br>\nReply-To: Henrique Marcandier - BH Commerce<henrique@bhcommerce.com.br>";
        $email['corpo'] = '<html><head><title>'.$email['assunto'].'</title></head><body><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="250" style="width: 250px; text-align: center;"><img src="'.URL.'img/logo.png" width="200"></td><td>Olá, o email <b>"'.$_REQUEST['emailNews'].'"</b>, foi cadastrado em nosso site em '.date('d/m/Y H:i').'h.<br><br>Atenciosamente,<br><br>Equipe BH Commerce</td></tr></table></body></html>';
        mail($email['nome'], $email['assunto'], $email['corpo'], $email['cabecalho']);
        $sql = "SELECT * FROM newsletters WHERE email = '".$_REQUEST['emailNews']."'";
        $query = mysqli_query($con, $sql);
        if (!mysqli_num_rows($query)) {
            $sql = "INSERT INTO newsletters (name, email, status, created_at, updated_at) VALUES ('" . ($_REQUEST['emailNews'] . "', '" . $_REQUEST['emailNews']) . "', '1', now(), now())";
        }
        else{
            $sql = "UPDATE newsletters SET updated_at = now() WHERE email = '".$_REQUEST['emailNews']."'";
        }
        mysqli_query($con, $sql);
        echo "1";
        break;
    case "salvarContato":
        $email['nome'] = "BH Commerce <henrique@bhcommerce.com.br>";
        $email['assunto'] = ("Email enviado pelo formulário de Fale Conosco do Site - BH Commerce - ".$_REQUEST['subject']);
        $email['cabecalho'] = "Content-Type: text/html; charset=iso-8859-1\n";
        $email['cabecalho'] .= "From: Henrique Marcandier - BH Commerce<henrique@bhcommerce.com.br>\nReply-To: Henrique Marcandier - BH Commerce<henrique@bhcommerce.com.br>";
        $email['corpo'] = ('<html><head><title>'.$email['assunto'].'</title></head><body><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="250" style="width: 250px; text-align: center;"><img src="'.URL.'img/logo.png" width="200"></td><td>Olá, foi enviado um novo email a partir do formulário de fale conosco do site. <br><b>Nome: </b> '.$_REQUEST['name'].'<br><b>Email: </b> '.$_REQUEST['email'].'<br><b>Assunto: </b> '.$_REQUEST['subject'].'<br><b>Telefone: </b> '.$_REQUEST['phone'].'<br><b>Mensagem: </b> '.nl2br($_REQUEST['text']).'<br><br>Atenciosamente,<br><br>Equipe <a href="https://www.bhcommerce.com.br">BH Commerce</a></td></tr></table></body></html>');
        mail($email['nome'], $email['assunto'], $email['corpo'], $email['cabecalho']);
        $sql = "INSERT INTO messages (name, email, subject, phone, text, status, created_at, updated_at) VALUES ('".($_REQUEST['name']."', '".$_REQUEST['email']."', '".$_REQUEST['subject']."', '".$_REQUEST['phone']."', '".$_REQUEST['text'])."', '1', now(), now())";
        mysqli_query($con, $sql);
        echo "1";
        break;
    case "salvarEstados":
        $sql = "SELECT * FROM  types_services WHERE id = '".$_REQUEST['typeService']."'";
        $query = mysqli_query($con, $sql);
        $rowTipoServico = mysqli_fetch_array($query);
        $sql = "SELECT * FROM  type_versions WHERE id = '".$_REQUEST['typeVersion']."'";
        $query = mysqli_query($con, $sql);
        $rowTipoVersao = mysqli_fetch_array($query);
        $sql = "SELECT * FROM  priorities WHERE id = '".$_REQUEST['priority']."'";
        $query = mysqli_query($con, $sql);
        $rowPrioridade = mysqli_fetch_array($query);
        $sql = "SELECT * FROM  categories WHERE id = '".$_REQUEST['category']."'";
        $query = mysqli_query($con, $sql);
        $rowCategoria = mysqli_fetch_array($query);
        $email['nome'] = "BH Commerce <henrique@bhcommerce.com.br>";
        $email['assunto'] = ("Email enviado pelo formulário de Bug Tracking do Site - BH Commerce - ".$_REQUEST['titleEstados']);
        $email['cabecalho'] = "Content-Type: text/html; charset=iso-8859-1\n";
        $email['cabecalho'] .= "From: Henrique Marcandier - BH Commerce<henrique@bhcommerce.com.br>\nReply-To: Henrique Marcandier - BH Commerce<henrique@bhcommerce.com.br>";
        $email['corpo'] = ('<html><head><title>'.$email['assunto'].'</title></head><body><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="250" style="width: 250px; text-align: center;" valign="top"><img src="'.URL.'img/logo.png" width="200"></td><td>Olá, foi enviado um novo email a partir do formulário de bug tracking do site. <br><b>Nome: </b> '.$_REQUEST['nameEstados'].'<br><b>Email: </b> '.$_REQUEST['emailEstados'].'<br><b>Título: </b> '.$_REQUEST['titleEstados'].'<br><b>Tipo de Serviço: </b> '.($rowTipoServico['name']).'<br><b>Versão: </b> '.($rowTipoVersao['name']).'<br><b>Prioridade: </b> '.($rowPrioridade['name']).'<br><b>Categoria: </b> '.($rowCategoria['name']).'<br><b>Mensagem: </b> '.nl2br($_REQUEST['message']).'<br><b>Status: </b>Enviado<br><br>Atenciosamente,<br><br>Equipe <a href="https://www.bhcommerce.com.br">BH Commerce</a></td></tr></table></body></html>');
        mail($email['nome'], $email['assunto'], $email['corpo'], $email['cabecalho']);
        $sql = "INSERT INTO bug_trackings (typeService, typeVersion, priority, category, name, email, title, message, created_at, updated_at) VALUES ('".($_REQUEST['typeService']."', '".$_REQUEST['typeVersion']."', '".$_REQUEST['priority']."', '".$_REQUEST['category']."', '".$_REQUEST['nameEstados']."', '".$_REQUEST['emailEstados']."', '".$_REQUEST['titleEstados']."', '".$_REQUEST['message'])."', now(), now())";
        mysqli_query($con, $sql) or die(mysqli_error($con)."<br>".$sql);
        echo "1";
        break;
    case 'selecionaTipoServiço':
        echo "1|-|<label class=\"form-label\">
                                Versão
                                <span class=\"text-danger\">*</span>
                            </label>

                            <select class=\"form-control\" name=\"typeVersion\" id=\"typeVersion\" required
                                    data-msg=\"Por Favor, informe a versão.\"
                                    data-error-class=\"u-has-error\"
                                    data-success-class=\"u-has-success\">
                                <option value=\"\">Selecione a versão corretamente</option>";
        $sql = "SELECT * FROM type_versions WHERE typeService = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            while ($row = mysqli_fetch_array($query)){
                echo "<option value=\"".$row['id']."\">".$row['name']."</option>";
            }
        }
        echo "</select>|-|<label class=\"form-label\">Prioridade
                                <span class=\"text-danger\">*</span>
                            </label><select class=\"form-control\" name=\"priority\" id=\"priority\" required
                                    data-msg=\"Por Favor, informe a prioridade. \"
                                    data-error-class=\"u-has-error\"
                                    data-success-class=\"u-has-success\">
                                <option value=\"\">Selecione a prioridade corretamente</option>";
        $sql = "SELECT * FROM priorities";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            while ($row = mysqli_fetch_array($query)){
                echo "<option value=\"".$row['id']."\" > ".($row['name'])."</option>";
            }
        }
        echo "</select>|-|<label class=\"form-label\">
                                Categoria
                                <span class=\"text-danger\">*</span>
                            </label>

                            <select class=\"form-control\" name=\"category\" id=\"category\" required
                                    data-msg=\"Por Favor, informe a categoria.\"
                                    data-error-class=\"u-has-error\"
                                    data-success-class=\"u-has-success\">
                                <option value=\"\">Selecione a categoria corretamente</option>";
        $sql = "SELECT * FROM categories WHERE typeService = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            while ($row = mysqli_fetch_array($query)){
                echo "<option value=\"".$row['id']."\"> ".($row['name'])."</option>";
            }
        }
        echo "</select>";
        break;
    case 'selecionaTipoServiçoAdmin':
        echo "1|-|<select name=\"typeVersion\" id=\"typeVersion\" required class='form-control'>
                                <option value=\"\">Selecione a versão corretamente</option>";
        $sql = "SELECT * FROM type_versions WHERE typeService = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            while ($row = mysqli_fetch_array($query)){
                echo "<option value=\"".$row['id']."\" ";
                if ($_REQUEST['version'] == $row['id']){
                    echo " selected";
                }
                echo ">".$row['name']."</option>";
            }
        }
        echo "</select>|-|<select name=\"priority\" id=\"priority\" required class='form-control'>
                       <option value=\"\">Selecione a prioridade corretamente</option>";
        $sql = "SELECT * FROM priorities";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            while ($row = mysqli_fetch_array($query)){
                echo "<option value=\"".$row['id']."\" ";
                if ($_REQUEST['priority'] == $row['id']){
                    echo " selected";
                }
                echo "> ".($row['name'])."</option>";
            }
        }
        echo "</select>|-|<select name=\"category\" id=\"category\" required class='form-control'>
                                <option value=\"\">Selecione a categoria corretamente</option>";
        $sql = "SELECT * FROM categories WHERE typeService = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            while ($row = mysqli_fetch_array($query)){
                echo "<option value=\"".$row['id']."\" ";
                if ($_REQUEST['category'] == $row['id']){
                    echo " selected";
                }
                echo "> ".($row['name'])."</option>";
            }
        }
        echo "</select>";
        break;
    case 'adicionaProdutoPedido':
        echo "1|-|<input type='hidden' id='pedidoAdd' name='pedidoAdd' value='".$_REQUEST['id']."'><input type='hidden' id='idUserAdd' name='idUserAdd' value='".$_REQUEST['idUser']."'><label for='produtoAdd'>Produto: </label>
                  <select name='produtoAdd' id='produtoAdd' class='form-control' onchange=selecionaProdutoPedido(this.value,'".URL."')><option value=''>Selecione o produto abaixo corretamente...</option>";
        $sql = "SELECT * FROM products";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query)){
            while ($row = mysqli_fetch_array($query)){
                echo "<option value='".$row['id']."'>".($row['name'])."</option>";
            }
        }
        echo "</select><div id='itensProdutoPedido'></div>";
        break;
    case "selecionaProdutoPedido":
        echo "1|-|<label for='itemVendaAdd'>Item de Venda: </label>
                  <select name='itemVendaAdd' id='itemVendaAdd' class='form-control' onchange=selecionaItemVendaPedido(this.value,'".$_REQUEST['id']."','".URL."')><option value=''>Selecione o item de venda abaixo corretamente...</option>";
        $sql = "SELECT * FROM products_items WHERE product = '".$_REQUEST['id']."'";
        $query = mysqli_query($con, $sql);
        if ($_REQUEST['id'] != 8) {
            if (mysqli_num_rows($query)) {
                while ($row = mysqli_fetch_array($query)) {
                    echo "<option value='" . $row['id'] . "'>" . ($row['name']) . " - ";
                    if ($row['promotion'] && $row['vlidity_promotion'] <= date('Y-m-d')) {
                        echo "R$" . number_format($row['promotion'], 2, ',', '.');
                    } else {
                        echo "R$" . number_format($row['value'], 2, ',', '.');
                    }
                    echo "</option>";
                }
            }
        }
        else{
            $row = mysqli_fetch_array($query);
            $sql = "SELECT * FROM subitems WHERE page = '5'";
            $query2 = mysqli_query($con, $sql);
            if (mysqli_num_rows($query2)){
                while ($row2 = mysqli_fetch_array($query2)){
                    echo "<option value='" . $row2['id'] . "'>" . ($row2['name'])." - ";
                    if ($row['promotion'] && $row['vlidity_promotion'] <= date('Y-m-d')) {
                        echo "R$" . number_format($row['promotion'], 2, ',', '.');
                    } else {
                        echo "R$" . number_format($row['value'], 2, ',', '.');
                    }
                    echo "</option>";
                }
            }
        }
        echo "</select><div id='itensVendaPedidoProduto'></div>";
        break;
    case "selecionaItemVendaPedido":
        if ($_REQUEST['idProduto'] != 3 && $_REQUEST['idProduto'] != 4){
            $html = "<label for='dominioAdd'>Domínio: </label><input type='text' name='dominioAdd' id='dominioAdd' class='form-control'>";
        }
        elseif($_REQUEST['idProduto'] == 3){
            $html = "<label for='razaoSocialAdd'>Razão Social: </label><input type='text' name='razaoSocialAdd' id='razaoSocialAdd' class='form-control'>
                    <label for='nomeFantasiaAdd'>Nome Fantasia: </label><input type='text' name='nomeFantasiaAdd' id='nomeFantasiaAdd' class='form-control'>
                    <label for='cnpjAdd'>CNPJ: </label><input type='text' name='cnpjAdd' id='cnpjAdd' class='form-control' maxlength='18' onkeyup=formataCampo(this,'XX.XXX.XXX/XXXX-XX',event)>
                    <label for='emailAdd'>Email: </label><input type='email' name='emailaAdd' id='emailAdd' class='form-control'>
                    <label for='cepAdd'>CEP: </label><input type='cepAdd' name='cepAdd' id='cepAdd' class='form-control' maxlength='9' onkeyup=formataCampo(this,'XXXXX-XXX',event);verificaCepCaixa(this.value)>
                    <label for='logradouroAdd'>Logradouro </label><input type='text' name='logradouroAdd' id='logradouroAdd' class='form-control'>
                    <label for='numeroAdd'>Número </label><input type='text' name='numeroAdd' id='numeroAdd' class='form-control'>
                    <label for='complementoAdd'>Complemento </label><input type='text' name='complementoAdd' id='complementoAdd' class='form-control'>
                    <label for='bairroAdd'>Bairro </label><input type='text' name='bairroAdd' id='bairroAdd' class='form-control'>
                    <label for='cidadeAdd'>Cidade </label><input type='text' name='cidadeAdd' id='cidadeAdd' class='form-control'>
                    <label for='estadoAdd'>Estado </label><select name='estadoAdd' id='estadoAdd' class='form-control'><option value=''>Selecione o estado abaixo...</option>";
            $sql = "SELECT * FROM states ORDER BY sigla ASC";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query)){
                while ($row = mysqli_fetch_array($query)){
                    $html .= "<option value='".$row['sigla']."'>".($row['nome'])."</option>";
                }
            }
            $html .= "</select>
                    <label forr='tipoEstabelecimentoAdd'>Tipo do Estabelecimento: </label>
                    <select name='tipoEstabelecimentoAdd' id='tipoEstabelecimentoAdd' class='form-control' onchange='selecionaTipoEstabelecimentoAdd(this.value)'>
                        <option value=''>Selecione o tipo do estabelecimento abaixo...</option>
                        <option value='1'>Mesas</option>
                        <option value='2'>Caixas</option>
                    </select>
                    <div id='outrosItensAdd'></div>";
        }
        elseif($_REQUEST['idProduto'] == 3){
            $html = "<label for='razaoSocialAdd'>Razão Social: </label><input type='text' name='razaoSocialAdd' id='razaoSocialAdd' class='form-control'>
                    <label for='nomeFantasiaAdd'>Nome Fantasia: </label><input type='text' name='nomeFantasiaAdd' id='nomeFantasiaAdd' class='form-control'>
                    <label for='cnpjAdd'>CNPJ: </label><input type='text' name='cnpjAdd' id='cnpjAdd' class='form-control' maxlength='18' onkeyup=formataCampo(this,'XX.XXX.XXX/XXXX-XX',event)>
                    <label for='emailAdd'>Email: </label><input type='email' name='emailaAdd' id='emailAdd' class='form-control'>
                    <label for='cepAdd'>CEP: </label><input type='cepAdd' name='cepAdd' id='cepAdd' class='form-control' maxlength='9' onkeyup=formataCampo(this,'XXXXX-XXX',event);verificaCepCaixa(this.value)>
                    <label for='logradouroAdd'>Logradouro </label><input type='text' name='logradouroAdd' id='logradouroAdd' class='form-control'>
                    <label for='numeroAdd'>Número </label><input type='text' name='numeroAdd' id='numeroAdd' class='form-control'>
                    <label for='complementoAdd'>Complemento </label><input type='text' name='complementoAdd' id='complementoAdd' class='form-control'>
                    <label for='bairroAdd'>Bairro </label><input type='text' name='bairroAdd' id='bairroAdd' class='form-control'>
                    <label for='cidadeAdd'>Cidade </label><input type='text' name='cidadeAdd' id='cidadeAdd' class='form-control'>
                    <label for='estadoAdd'>Estado </label><select name='estadoAdd' id='estadoAdd' class='form-control'><option value=''>Selecione o estado abaixo...</option>";
            $sql = "SELECT * FROM states ORDER BY sigla ASC";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query)){
                while ($row = mysqli_fetch_array($query)){
                    $html .= "<option value='".$row['sigla']."'>".($row['nome'])."</option>";
                }
            }
            $html .= "</select>
                    <label forr='tipoEstabelecimentoAdd'>Tipo do Estabelecimento: </label>
                    <select name='tipoEstabelecimentoAdd' id='tipoEstabelecimentoAdd' class='form-control' onchange='selecionaTipoEstabelecimentoAdd(this.value)'>
                        <option value=''>Selecione o tipo do estabelecimento abaixo...</option>
                        <option value='1'>Mesas</option>
                        <option value='2'>Caixas</option>
                    </select>
                    <div id='outrosItensAdd'></div>";
        }
        elseif($_REQUEST['idProduto'] == 3){
            $html = "<label for='razaoSocialAdd'>Razão Social: </label><input type='text' name='razaoSocialAdd' id='razaoSocialAdd' class='form-control'>
                    <label for='nomeFantasiaAdd'>Nome Fantasia: </label><input type='text' name='nomeFantasiaAdd' id='nomeFantasiaAdd' class='form-control'>
                    <label for='cnpjAdd'>CNPJ: </label><input type='text' name='cnpjAdd' id='cnpjAdd' class='form-control' maxlength='18' onkeyup=formataCampo(this,'XX.XXX.XXX/XXXX-XX',event)>
                    <label for='emailAdd'>Email: </label><input type='email' name='emailaAdd' id='emailAdd' class='form-control'>
                    <label for='cepAdd'>CEP: </label><input type='cepAdd' name='cepAdd' id='cepAdd' class='form-control' maxlength='9' onkeyup=formataCampo(this,'XXXXX-XXX',event);verificaCepCaixa(this.value)>
                    <label for='logradouroAdd'>Logradouro </label><input type='text' name='logradouroAdd' id='logradouroAdd' class='form-control'>
                    <label for='numeroAdd'>Número </label><input type='text' name='numeroAdd' id='numeroAdd' class='form-control'>
                    <label for='complementoAdd'>Complemento </label><input type='text' name='complementoAdd' id='complementoAdd' class='form-control'>
                    <label for='bairroAdd'>Bairro </label><input type='text' name='bairroAdd' id='bairroAdd' class='form-control'>
                    <label for='cidadeAdd'>Cidade </label><input type='text' name='cidadeAdd' id='cidadeAdd' class='form-control'>
                    <label for='estadoAdd'>Estado </label><select name='estadoAdd' id='estadoAdd' class='form-control'><option value=''>Selecione o estado abaixo...</option>";
            $sql = "SELECT * FROM states ORDER BY sigla ASC";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query)){
                while ($row = mysqli_fetch_array($query)){
                    $html .= "<option value='".$row['sigla']."'>".($row['nome'])."</option>";
                }
            }
            $html .= "</select>
                    <label forr='tipoEstabelecimentoAdd'>Tipo do Estabelecimento: </label>
                    <select name='tipoEstabelecimentoAdd' id='tipoEstabelecimentoAdd' class='form-control' onchange='selecionaTipoEstabelecimentoAdd(this.value)'>
                        <option value=''>Selecione o tipo do estabelecimento abaixo...</option>
                        <option value='1'>Mesas</option>
                        <option value='2'>Caixas</option>
                    </select>
                    <div id='outrosItensAdd'></div>";
        }
        elseif($_REQUEST['idProduto'] == 4){
            $html = "<label for='nomeEscolaAdd'>Nome da Escola: </label><input type='text' name='nomeEscolaAdd' id='nomeEscolaAdd' class='form-control'>
                    <label for='emailAdd'>Email da Escola: </label><input type='email' name='emailAdd' id='emailAdd' class='form-control'>
                    <label for='cepAdd'>CEP da Escola: </label><input type='cepAdd' name='cepAdd' id='cepAdd' class='form-control' maxlength='9' onkeyup=formataCampo(this,'XXXXX-XXX',event);verificaCepCaixa(this.value)>
                    <label for='logradouroAdd'>Logradouro da Escola: </label><input type='text' name='logradouroAdd' id='logradouroAdd' class='form-control'>
                    <label for='numeroAdd'>Número da Escola: </label><input type='text' name='numeroAdd' id='numeroAdd' class='form-control'>
                    <label for='complementoAdd'>Complemento da Escola: </label><input type='text' name='complementoAdd' id='complementoAdd' class='form-control'>
                    <label for='bairroAdd'>Bairro da Escola: </label><input type='text' name='bairroAdd' id='bairroAdd' class='form-control'>
                    <label for='cidadeAdd'>Cidade da Escola: </label><input type='text' name='cidadeAdd' id='cidadeAdd' class='form-control'>
                    <label for='estadoAdd'>Estado da Escola: </label><select name='estadoAdd' id='estadoAdd' class='form-control'><option value=''>Selecione o estado abaixo...</option>";
            $sql = "SELECT * FROM states ORDER BY sigla ASC";
            $query = mysqli_query($con, $sql);
            if (mysqli_num_rows($query)){
                while ($row = mysqli_fetch_array($query)){
                    $html .= "<option value='".$row['sigla']."'>".($row['nome'])."</option>";
                }
            }
            $html .= "</select>
                    <label forr='tipoNotaAdd'>Tipo de Nota: </label>
                    <select name='tipoNotaAdd' id='tipoNotaAdd' class='form-control'>
                        <option value=''>Selecione o tipo de nota abaixo...</option>
                        <option value='1'>Bimestral</option>
                        <option value='2'>Trimestral</option>
                        <option value='3'>Semestral</option>
                        <option value='4'>Anual</option>
                    </select>
                    <label forr='turnoAdd'>Turno da escola: </label>
                    <select name='turnoAdd' id='turnoAdd' class='form-control'>
                        <option value=''>Selecione o turno da escola abaixo...</option>
                        <option value='1'>Manhã</option>
                        <option value='2'>Tarde</option>
                        <option value='3'>Noite</option>
                        <option value='4'>Único</option>
                        <option value='5'>Todos</option>
                    </select>
                    <label forr='letraAdd'>Até que letra  as turmas da escola vão: </label>
                    <select name='letraAdd' id='letraAdd' class='form-control'>
                        <option value=''>Selecione a letra da escola abaixo...</option>
                        <option value='Un'>Única</option>
                        ";
           for ($i = 1; $i <= 26; $i++){
               if ($i == 1){
                   $letra = "a";
               }
               elseif ($i == 2){
                   $letra = "b";
               }
               elseif ($i == 3){
                   $letra = "c";
               }
               elseif ($i == 4){
                   $letra = "d";
               }
               elseif ($i == 5){
                   $letra = "e";
               }
               elseif ($i == 6){
                   $letra = "f";
               }
               elseif ($i == 7){
                   $letra = "g";
               }
               elseif ($i == 8){
                   $letra = "h";
               }
               elseif ($i == 9){
                   $letra = "i";
               }
               elseif ($i == 10){
                   $letra = "j";
               }
               elseif ($i == 11){
                   $letra = "k";
               }
               elseif ($i == 12){
                   $letra = "l";
               }
               elseif ($i == 13){
                   $letra = "m";
               }
               elseif ($i == 14){
                   $letra = "n";
               }
               elseif ($i == 15){
                   $letra = "o";
               }
               elseif ($i == 16){
                   $letra = "p";
               }
               elseif ($i == 17){
                   $letra = "q";
               }
               elseif ($i == 18){
                   $letra = "r";
               }
               elseif ($i == 19){
                   $letra = "s";
               }
               elseif ($i == 20){
                   $letra = "t";
               }
               elseif ($i == 21){
                   $letra = "u";
               }
               elseif ($i == 22){
                   $letra = "v";
               }
               elseif ($i == 23){
                   $letra = "w";
               }
               elseif ($i == 24){
                   $letra = "x";
               }
               elseif ($i == 25){
                   $letra = "y";
               }
               elseif ($i == 26){
                   $letra = "z";
               }
               $html .=  "<option value='".$letra."'>".$letra."</option>";
           }
           $html .= "
                    </select>";
        }
        $html .= "<input type='button' class='btn btn-primary' value='Cadastrar' onclick=adicionarProdutoPedido($('#produtoAdd').val(),$('#itemVendaAdd').val(),$('#dominioAdd').val(),'".URL."')>";
        echo "1|-|".$html;
        break;
    case 'adicionarProdutoPedido':
        if($_REQUEST['idProduto'] == 8){
            $sql = "SELECT * FROM products_items WHERE product = '" . $_REQUEST['idProduto'] . "'";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($query);
            $sql = "SELECT * FROM subitems WHERE id = '". $_REQUEST['idItVenda'] ."'";
            $query2 = mysqli_query($con, $sql);
            $row2 = mysqli_fetch_array($query2);
            $row['name'] .= " - ".$row2['name'];
        }
        else {
            $sql = "SELECT * FROM products_items WHERE id = '" . $_REQUEST['idItVenda'] . "'";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($query);
        }
        $valor = ($row['promotion'] && $row['validity_promotion'] >= date('Y-m-d')) ? $row['promotion'] : $row['value'];
        $sql = "INSERT INTO requests_items (request, product, product_item, name, domine, quantity, value, created_at, updated_at) VALUES ('".$_REQUEST['idPedido']."', '".$_REQUEST['idProduto']."', '".$_REQUEST['idItVenda']."', '".$row['name']."', '".$_REQUEST['dominio']."', '1', '".$valor."', now(), now())";
        //echo $sql;
        mysqli_query($con, $sql) or die(mysqli_error($con));
        $idRequestItem = mysqli_insert_id($con);
        if ($_REQUEST['idProduto'] == 3){
            $sql = "INSERT INTO cashier_system (razao_social, nome_fantasia, email, cnpj, cep, logradouro, numero, complemento, bairro, cidade, estado, tipoEstabelecimento, quantidade, numeroPessoasPorMesa, percentual, created_at, updated_at) VALUES ('".$_REQUEST['razaoSocial']."', '".$_REQUEST['nomeFantasia']."', '".$_REQUEST['email']."', '".$_REQUEST['cnpj']."', '".$_REQUEST['cep']."', '".$_REQUEST['logradouro']."', '".$_REQUEST['numero']."', '".$_REQUEST['complemento']."', '".$_REQUEST['bairro']."', '".$_REQUEST['cidade']."', '".$_REQUEST['estado']."', '".$_REQUEST['tipoEstabelecimento']."', '".$_REQUEST['quantidade']."', '".$_REQUEST['numPessoas']."', '".$_REQUEST['percentual']."', now(), now())";
            mysqli_query($con, $sql) or die(mysqli_error($con)." - ".$sql);
            $idCashierSystem = mysqli_insert_id($con);
            $sql = "UPDATE requests_items SET cashier_system = '".$idCashierSystem."' WHERE id = '".$idRequestItem."'";
            mysqli_query($con, $sql) or die(mysqli_error($con));
        }
        if ($_REQUEST['idProduto'] == 4){
            $sql = "INSERT INTO school_system (nome, email, cep, logradouro, numero, complemento, bairro, cidade, estado, tipoNota, turno, letra, created_at, updated_at) VALUES ('".$_REQUEST['nome']."', '".$_REQUEST['email']."', '".$_REQUEST['cep']."', '".$_REQUEST['logradouro']."', '".$_REQUEST['numero']."', '".$_REQUEST['complemento']."', '".$_REQUEST['bairro']."', '".$_REQUEST['cidade']."', '".$_REQUEST['estado']."', '".$_REQUEST['tipoNota']."', '".$_REQUEST['turno']."', '".$_REQUEST['letra']."', now(), now())";
            mysqli_query($con, $sql) or die(mysqli_error($con)." - ".$sql);
            $idSchoolSystem = mysqli_insert_id($con);
            $sql = "UPDATE requests_items SET school_system = '".$idSchoolSystem."' WHERE id = '".$idRequestItem."'";
            mysqli_query($con, $sql) or die(mysqli_error($con));
        }
        echo "1|-|".$idRequestItem."|-|".$idCashierSystem;
        break;
    case 'excluirProdutoPedido':
        $sql = "DELETE FROM requests_items WHERE id = '".$_REQUEST['id']."'";
        mysqli_query($con, $sql) or die(mysqli_error($con));
        echo "1";
        break;
    default:
        echo "0|-|Não foi encontrada a ação pesquisada!";
        break;
}
function retirarAcentos($name){
    $slug = (strtolower(str_replace(' ', '-', $name)));
    $slug = str_replace("+", "-", $slug);
    $slug = str_replace("/", "", $slug);
    $slug = str_replace("%", "", $slug);
    $slug = str_replace("&", "e", $slug);
    $slug = str_replace("?", "", $slug);
    $slug = str_replace("!", "", $slug);
    $slug = str_replace("á", "a", $slug);
    $slug = str_replace("à", "a", $slug);
    $slug = str_replace("ã", "a", $slug);
    $slug = str_replace("â", "a", $slug);
    $slug = str_replace("ª", "a", $slug);
    $slug = str_replace("é", "e", $slug);
    $slug = str_replace("è", "e", $slug);
    $slug = str_replace("ê", "e", $slug);
    $slug = str_replace("í", "i", $slug);
    $slug = str_replace("ì", "i", $slug);
    $slug = str_replace("ó", "o", $slug);
    $slug = str_replace("ò", "o", $slug);
    $slug = str_replace("ô", "o", $slug);
    $slug = str_replace("õ", "o", $slug);
    $slug = str_replace("º", "o", $slug);
    $slug = str_replace("ú", "u", $slug);
    $slug = str_replace("ù", "u", $slug);
    $slug = str_replace("û", "u", $slug);
    $slug = str_replace("ç", "c", $slug);
    return $slug;
}
?>