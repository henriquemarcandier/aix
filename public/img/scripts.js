$("#formCadastro").submit(function(evt){
    evt.preventDefault();
    var url = $('#urlCadastro').val();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: url+'ajax.php?acao=formCadastro',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                $(".messageBoxSuccess").addClass('d-none');
                $(".messageBox").removeClass('d-none').html(vet[1]);
            } else if (vet[0] == 1) {
                $(".messageBox").addClass('d-none');
                $(".messageBoxSuccess").removeClass('d-none').html('Cadastro efetuado com sucesso! Aguarde o nosso email informando que o cadastro está ok!!');
                $("#nome").val('');
                $("#email").val('');
                $("#password").val('');
                $("#password2").val('');
            }
        },
    });
    return false;
});
$("#formLogin").submit(function(evt){
    evt.preventDefault();
    var url = $('#urlLogin').val();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: url+'ajax.php?acao=formLogin',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                $(".messageBoxSuccess").addClass('d-none');
                $(".messageBox").removeClass('d-none').html(vet[1]);
            } else if (vet[0] == 1) {
                $(".messageBox").addClass('d-none');
                $(".messageBoxSuccess").removeClass('d-none').html('Login efetuado com sucesso! Aguarde o refresh da página!');
                if ($("#urlVolta").val() != undefined) {
                    location.href = url + "" + $("#urlVolta").val();
                }
                else{
                    location.href=url+"";
                }
            }
        },
    });
    return false;
});
$("#formAlterarSenha").submit(function(evt){
    evt.preventDefault();
    var url = $('#urlAlterarSenha').val();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: url+'ajax.php?acao=formAlterarSenha',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                alert('Senha alterada com sucesso! Você será redirecionado para a página de login.');
                location.href=url+"login";
            }
        },
    });
    return false;
});
$("#formEsqueceuSuaSenha").submit(function(evt){
    evt.preventDefault();
    var url = $('#urlEsqueceuSuaSenha').val();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: url+'ajax.php?acao=formEsqueceuSuaSenha',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                alert('Email enviado com sucesso! Confira seu email! Você será redirecionado para a página de login.');
                location.href=url+"login";
            }
        },
    });
    return false;
});
$("#importaAlunos").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: 'ajax.php?acao=importacaoAlunos',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                alert('Alunos importados com sucesso!');
                jQuery('#modalImporta').modal('hide');
                verificaNovamente('alunos', url, idUser);
            }
        },
    });
    return false;
});
$("#importaCursos").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=importar&table=cursos',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('cursos', $("#urlEdicao").val(), $("#idUserEdicao").val());
                jQuery('#modalImporta').modal('hide');
                $('#importacaoRealizadaComSucesso').show('slow');
                window.setInterval('$("#importacaoRealizadaComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
$("#edicaoTipoModulo").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=editar&table=tipoModulo',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('tipoModulo', $("#urlEdicao").val(), $("#idUserEdicao").val());
                jQuery('#modalEdicao').modal('hide');
                $('#registroAtualizadoComSucesso').show('slow');
                window.setInterval('$("#registroAtualizadoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
$("#edicaoModulo").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=editar&table=modulo',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('modulo', $("#urlEdicao").val(), $("#idUserEdicao").val());
                jQuery('#modalEdicao').modal('hide');
                $('#registroAtualizadoComSucesso').show('slow');
                window.setInterval('$("#registroAtualizadoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
$("#edicaoAlunos").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=editar&table=alunos',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('alunos', $("#urlEdicao").val(), $("#idUserEdicao").val());
                jQuery('#modalEdicao').modal('hide');
                $('#registroAtualizadoComSucesso').show('slow');
                window.setInterval('$("#registroAtualizadoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
$("#edicaoCursos").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=editar&table=cursos',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('cursos', $("#urlEdicao").val(), $("#idUserEdicao").val());
                jQuery('#modalEdicao').modal('hide');
                $('#registroAtualizadoComSucesso').show('slow');
                window.setInterval('$("#registroAtualizadoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
$("#edicaoVersao").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=editar&table=versao',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('versao', $("#urlEdicao").val(), $("#idUserEdicao").val());
                jQuery('#modalEdicao').modal('hide');
                $('#registroAtualizadoComSucesso').show('slow');
                window.setInterval('$("#registroAtualizadoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
$("#edicaoUsuario").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=editar&table=usuario',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
                jQuery('#modalEdicao').modal('hide');
            } else if (vet[0] == 1) {
                if (vet[1] == $("#idUserEdicao").val() && vet[2]){
                    $('#imgUser').html('<img src="'+vet[2]+'" onclick="abreFecha(\'saiUsuarios\')" style="cursor:pointer" class="img-circle elevation-2" alt="User Image">');
                }
                verificaNovamente('usuarios', $("#urlEdicao").val(), $("#idUserEdicao").val());
                jQuery('#modalEdicao').modal('hide');
                $('#registroAtualizadoComSucesso').show('slow');
                window.setInterval('$("#registroAtualizadoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
$("#edicaoUsuarioPre").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=editar&table=usuarioPre',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('usuarios-pre', $("#urlEdicao").val(), $("#idUserEdicao").val());
                jQuery('#modalEdicao').modal('hide');
                $('#registroAtualizadoComSucesso').show('slow');
                window.setInterval('$("#registroAtualizadoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});1
$("#cadastroVersao").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=cadastrar&table=versao',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('versao', $("#urlEdicao").val(), $("#idUserCadastro").val());
                $("#descricaoCadastro").val('');
                $("#nomeCadastro").val('');
                $("#dataCadastro").val('');
                $("#imagemCadastro").val('');
                jQuery('#modalCadastro').modal('hide');
                $('#registroInseridoComSucesso').show('slow');
                window.setInterval('$("#registroInseridoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
$("#cadastroUsuario").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=cadastrar&table=usuarios',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('usuarios', $("#urlEdicao").val(), $("#idUserCadastro").val());
                $("#nomeCadastro").val('');
                $("#emailCadastro").val('');
                $("#senhaCadastro").val('');
                $("#imagemCadastro").val('');
                jQuery('#modalCadastro').modal('hide');
                $('#registroInseridoComSucesso').show('slow');
                window.setInterval('$("#registroInseridoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
$("#cadastroTipoModulo").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=cadastrar&table=tipoModulo',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('tipoModulo', $("#urlEdicao").val(), $("#idUserEdicao").val());
                $("#nomeCadastro").val('');
                $("#statusCadastro").val('0');
                jQuery('#modalCadastro').modal('hide');
                $('#registroInseridoComSucesso').show('slow');
                window.setInterval('$("#registroInseridoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
$("#cadastroModulo").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=cadastrar&table=modulo',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('modulo', $("#urlEdicao").val(), $("#idUserEdicao").val());
                $("#tipoModuloCadastro").val('');
                $("#nomeCadastro").val('');
                $("#urlAmigavelCadastro").val('');
                $("#statusCadastro").val('0');
                jQuery('#modalCadastro').modal('hide');
                $('#registroInseridoComSucesso').show('slow');
                window.setInterval('$("#registroInseridoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
$("#cadastroAlunos").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=cadastrar&table=alunos',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('alunos', $("#urlEdicao").val(), $("#idUserEdicao").val());
                $("#emailCadastro").val('');
                $("#nomeCadastro").val('');
                jQuery('#modalCadastro').modal('hide');
                $('#registroInseridoComSucesso').show('slow');
                window.setInterval('$("#registroInseridoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
$("#cadastroCursos").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: $("#urlEdicao").val()+'ajax.php?acao=cadastrar&table=cursos',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                alert(vet[1]);
            } else if (vet[0] == 1) {
                verificaNovamente('cursos', $("#urlEdicao").val(), $("#idUserEdicao").val());
                $("#nomeCadastro").val('');
                jQuery('#modalCadastro').modal('hide');
                $('#registroInseridoComSucesso').show('slow');
                window.setInterval('$("#registroInseridoComSucesso").hide("fast")', 15000);
            }
        },
    });
    return false;
});
function exportarCursos(){
    location.href='exportarCursos.php?nomeFiltro='+$("#nomeFiltro").val();
}
function verificaCepCadastroAluno(valor) {
    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep.length == 8) {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;
        //Valida o formato do CEP.
        if(validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logradouroCadastro').value="Aguarde... Pesquisando...";
            document.getElementById('numeroCadastro').value="Aguarde... Pesquisando...";
            document.getElementById('complementoCadastro').value="Aguarde... Pesquisando...";
            document.getElementById('bairroCadastro').value="Aguarde... Pesquisando...";
            document.getElementById('cidadeCadastro').value="Aguarde... Pesquisando...";
            document.getElementById('estadoCadastro').value="";
            //Cria um elemento javascript.
            var script = document.createElement('script');
            //Sincroniza com o callback.
            script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=retornoCEPCadastroAluno';
            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);
        } //end if.
        else {
            //cep é inválido.
            alert("Formato de CEP inválido.");
            document.getElementById('logradouroCadastro').value="";
            document.getElementById('bairroCadastro').value="";
            document.getElementById('numeroCadastro').value="";
            document.getElementById('complementoCadastro').value="";
            document.getElementById('cidadeCadastro').value="";
            document.getElementById('estadoCadastro').value="";
            document.getElementById('logradouroCadastro').focus();
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
    }
};
function retornoCEPCadastroAluno(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('logradouroCadastro').value=(conteudo.logradouro);
        document.getElementById('bairroCadastro').value=(conteudo.bairro);
        document.getElementById('numeroCadastro').value="";
        document.getElementById('complementoCadastro').value="";
        document.getElementById('cidadeCadastro').value=(conteudo.localidade);
        document.getElementById('estadoCadastro').value=(conteudo.uf);
        document.getElementById('numeroCadastro').focus();
    } //end if.
    else {
        //CEP não Encontrado.
        alert("CEP não encontrado. Digeite as informações manualmente!");
        document.getElementById('logradouroCadastro').value="";
        document.getElementById('bairroCadastro').value="";
        document.getElementById('numeroCadastro').value="";
        document.getElementById('complementoCadastro').value="";
        document.getElementById('cidadeCadastro').value="";
        document.getElementById('estadoCadastro').value="";
        document.getElementById('logradouroCadastro').focus();
    }
}
function verificaCepEdicaoAluno(valor) {
    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep.length == 8) {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;
        //Valida o formato do CEP.
        if(validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logradouroEdicao').value="Aguarde... Pesquisando...";
            document.getElementById('numeroEdicao').value="Aguarde... Pesquisando...";
            document.getElementById('complementoEdicao').value="Aguarde... Pesquisando...";
            document.getElementById('bairroEdicao').value="Aguarde... Pesquisando...";
            document.getElementById('cidadeEdicao').value="Aguarde... Pesquisando...";
            document.getElementById('estadoEdicao').value="";
            //Cria um elemento javascript.
            var script = document.createElement('script');
            //Sincroniza com o callback.
            script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=retornoCEPEdicaoAluno';
            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);
        } //end if.
        else {
            //cep é inválido.
            alert("Formato de CEP inválido.");
            document.getElementById('logradouroEdicao').value="";
            document.getElementById('bairroEdicao').value="";
            document.getElementById('numeroEdicao').value="";
            document.getElementById('complementoEdicao').value="";
            document.getElementById('cidadeEdicao').value="";
            document.getElementById('estadoEdicao').value="";
            document.getElementById('logradouroEdicao').focus();
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
    }
};
function retornoCEPEdicaoAluno(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('logradouroEdicao').value=(conteudo.logradouro);
        document.getElementById('bairroEdicao').value=(conteudo.bairro);
        document.getElementById('numeroEdicao').value="";
        document.getElementById('complementoEdicao').value="";
        document.getElementById('cidadeEdicao').value=(conteudo.localidade);
        document.getElementById('estadoEdicao').value=(conteudo.uf);
        document.getElementById('numeroEdicao').focus();
    } //end if.
    else {
        //CEP não Encontrado.
        alert("CEP não encontrado. Digeite as informações manualmente!");
        document.getElementById('logradouroEdicao').value="";
        document.getElementById('bairroEdicao').value="";
        document.getElementById('numeroEdicao').value="";
        document.getElementById('complementoEdicao').value="";
        document.getElementById('cidadeEdicao').value="";
        document.getElementById('estadoEdicao').value="";
        document.getElementById('logradouroEdicao').focus();
    }
}
function selecionaTipoEstabelecimento(id){
    if (id == ''){
        $('#tiposEstabelecimentoRealizarPedido').html('Selecione o tipo do estabelecimento acima...');
    }
    else{
        var html = "";
        if (id == 1){
            html += '<label for="quantidadeRealizarPedido">Quantidade de Mesas do Estabelecimento</label>' +
                '<input type="number" id="quantidadeRealizarPedido" name="quantidadeRealizarPedido" class="form-control" required placeholder="Informe a quantidade de mesas do estabelecimento...">' +
                '<label for="numPessoasRealizarPedido">Número de Pessoas por Mesa do Estabelecimento</label>' +
                '<input type="number" id="numPessoasRealizarPedido" name="numPessoasRealizarPedido" class="form-control" required placeholder="Informe número de pessoas por mesa do estabelecimento...">' +
                '<label for="perGarcomRealizarPedido">Percentual do Garçom do Estabelecimento (em %)</label>' +
                '<input type="number" id="perGarcomRealizarPedido" name="perGarcomRealizarPedido" class="form-control" required placeholder="Percentual do garçom do estabelecimento (em %)...">';
        }
        else{
            html += '<label for="quantidade">Quantidade de Caixas do Estabelecimento</label>' +
                '<input type="number" id="quantidadeRealizarPedido" name="quantidadeRealizarPedido" class="form-control" required placeholder="Informe a quantidade de caixas do estabelecimento...">';
        }
        $('#tiposEstabelecimentoRealizarPedido').html(html);
    }
}
function pesquisacepedit(valor, id) {
    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep.length == 8) {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;
        //Valida o formato do CEP.
        if(validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logradouroEditaEndereco').value="Aguarde... Pesquisando...";
            document.getElementById('numeroEditaEndereco').value="Aguarde... Pesquisando...";
            document.getElementById('complementoEditaEndereco').value="Aguarde... Pesquisando...";
            document.getElementById('bairroEditaEndereco').value="Aguarde... Pesquisando...";
            document.getElementById('cidadeEditaEndereco').value="Aguarde... Pesquisando...";
            document.getElementById('estadoEditaEndereco').value="";
            //Cria um elemento javascript.
            var script = document.createElement('script');
            //Sincroniza com o callback.
            script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=retornoCEPEdit';
            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);
        } //end if.
        else {
            //cep é inválido.
            alert("Formato de CEP inválido.");
            document.getElementById('logradouroEditaEndereco').value="";
            document.getElementById('bairroEditaEndereco').value="";
            document.getElementById('numeroEditaEndereco').value="";
            document.getElementById('complementoEditaEndereco').value="";
            document.getElementById('cidadeEditaEndereco').value="";
            document.getElementById('estadoEditaEndereco').value="";
            document.getElementById('logradouroEditaEndereco').focus();
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
    }
};
function retornoCEPEdit(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('logradouroEditaEndereco').value=(conteudo.logradouro);
        document.getElementById('bairroEditaEndereco').value=(conteudo.bairro);
        document.getElementById('numeroEditaEndereco').value="";
        document.getElementById('complementoEditaEndereco').value="";
        document.getElementById('cidadeEditaEndereco').value=(conteudo.localidade);
        document.getElementById('estadoEditaEndereco').value=(conteudo.uf);
        document.getElementById('numeroEditaEndereco').focus();
    } //end if.
    else {
        //CEP não Encontrado.
        alert("CEP não encontrado. Digeite as informações manualmente!");
        document.getElementById('logradouroEditaEndereco').value="";
        document.getElementById('bairroEditaEndereco').value="";
        document.getElementById('numeroEditaEndereco').value="";
        document.getElementById('complementoEditaEndereco').value="";
        document.getElementById('cidadeEditaEndereco').value="";
        document.getElementById('estadoEditaEndereco').value="";
        document.getElementById('logradouroEditaEndereco').focus();
    }
}
function mascara(src, mask, evt){

    var i = src.value.length;

    var saida = mask.substring(i,i+1);

    var ascii = evt.keyCode;

    if(i < mask.length || ascii == 8 || ascii == 9){

        if(document.all){

            var evt = event.keyCode;

        }

        else{

            var evt = evt.which;

        }

        if (saida == "A")

        {

            if ((ascii >=97) && (ascii <= 122))

                evt.keyCode -= 32;

            else

                evt.keyCode = 0;

        }

        else if (saida == "0")

        {

            if ((ascii >= 48) && (ascii <= 57))

                return;

            else

                evt.keyCode = 0;

        }

        else if (saida == "#")

            return;

        else if(ascii != 8)

        {

            src.value += saida;

            i += 1;

            saida = mask.substring(i,i+1);

            if (saida == "A")

            {

                if ((ascii >=97) && (ascii <= 122))

                    evt.keyCode -= 32;

                else

                    evt.keyCode = 0;

            }

            else if (saida == "0")

            {

                if ((ascii >= 48) && (ascii <= 57))

                    return;

                else

                    evt.keyCode = 0;

            }

            else

                return;

        }

    }

    else

        return false;

}
function pegaLogsAcesso(idUser, url){
    $.ajax({
        url: url+'ajax.php?&acao=verificaNovamente&tela=logs&idUser=' + idUser+"&pagina="+$("#pagina").val()+"&usuarioFiltro="+$("#usuarioFiltro").val()+"&acaoFiltro="+$('#acaoFiltro').val(),
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#conteudo").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        }
    });
}
function paginacaoLogs(pagina, idUser, url){
    $('#pagina').val(pagina);
    $.ajax({
        url: url+'ajax.php?&acao=pegaLogsAcesso&user=' + idUser+"&pagina="+$("#pagina").val()+"&usuarioFiltro="+$("#usuarioFiltro").val()+"&acaoiltro="+$("#acaoFiltro").val(),
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#registros").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#registros").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function mostraPermissaoUsuario(id, url, user){
    $.ajax({
        url: url+'ajax.php?&acao=pegaPermissaoUsuario&id=' + id+"&user="+user,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#permissaoUsuario"+id).html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#permissaoUsuario"+id).show('slow');
            $("#permissaoUsuario"+id).html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function editaProdutoPedido(id, request, url){
    $('#atualizarItem').show('slow');
    $.ajax({
        url: url+'ajax.php?&acao=editaProdutoPedido&id=' + id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#productEdita").val(data[1]);
                selecionaProdutoEdita(data[2], request, data[1], data[3], url);

            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#selecionadoProdutoEdita").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function selecionaEnderecoPedido(id, url){
    if (id == "") {
        $("#enderecoCliente").html('Selecione o endereço corretamente!');
    }
    else{
        $.ajax({
            url: url+'ajax.php?&acao=selecionaEnderecoPedido&id=' + id,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    $("#enderecoCliente").html(data[1]);
                } else if (data[0] == 0) {
                    alert('Erro: '+data[1]);
                }
            },
            beforeSend: function () {
                $("#enderecoCliente").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
            }
        });
    }
}
function pegaEnderecosCliente(idCliente, idEndereco, url){
    if (idCliente == "") {
        $("#enderecosCliente").html('Selecione o cliente corretamente!');
        $("#enderecoCliente").html('');
    }
    else{
        $.ajax({
            url: url+'ajax.php?&acao=pegaEnderecosCliente&idCliente=' + idCliente+"&idEndereco="+idEndereco,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    $("#enderecosCliente").html(data[1]);
                    $("#enderecoCliente").html(data[2]);
                } else if (data[0] == 0) {
                    alert('Erro: '+data[1]);
                }
            },
            beforeSend: function () {
                $("#enderecosCliente").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
                $("#enderecoCliente").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
            }
        });
    }
}
function selecionaClientePedido(id, url){
    if (id == "") {
        $("#detalhesCliente").html('Selecione o cliente corretamente!');
    }
    else{
        $.ajax({
            url: url+'ajax.php?&acao=selecionaClientePedido&id=' + id,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    $("#detalhesCliente").html(data[1]);
                } else if (data[0] == 0) {
                    alert('Erro: '+data[1]);
                }
            },
            beforeSend: function () {
                $("#detalhesCliente").show('slow');
                $("#detalhesCliente").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
            }
        });
    }
}
function adicionaPermissao(user, module, field, url, userLog){
    $.ajax({
        url: url+'ajax.php?&acao=addPermissao&module=' + module+"&user="+user+"&field="+field+"&userLog="+userLog,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#"+field+module+user).html('<img src="'+url+'img/sucesso.png" width="20" style="cursor:pointer" onclick=removePermissao("'+user+'","'+module+'","'+field+'","'+url+'","'+userLog+'")>');
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#"+field+module+user).html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function removePermissao(user, module, field, url, userLog){
    $.ajax({
        url: url+'ajax.php?&acao=removePermissao&module=' + module+"&user="+user+"&field="+field+'&userLog='+userLog,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#"+field+module+user).html('<img src="'+url+'img/erro.ico" width="20" style="cursor:pointer" onclick=adicionaPermissao("'+user+'","'+module+'","'+field+'","'+url+'","'+userLog+'")>');
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#"+field+module+user).html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function editaEndereco(id, url){
    $.ajax({
        url: url+'ajax.php?&acao=editarEndereco&id=' + id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#idEditaEndereco").val(data[1]);
                $("#nomeEdita").val(data[2]);
                $("#cepEditaEndereco").val(data[3]);
                $("#logradouroEditaEndereco").val(data[4]);
                $("#numeroEditaEndereco").val(data[5]);
                $("#complementoEditaEndereco").val(data[6]);
                $("#bairroEditaEndereco").val(data[7]);
                $("#cidadeEditaEndereco").val(data[8]);
                $("#estadoEditaEndereco").val(data[9]);
                $("#botoesEditaEndereco").val(data[10]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#nomeEdita").val('Aguarde... Carregando...');
            $("#cepEditaEndereco").val('Aguarde... Carregando...');
            $("#logradouroEditaEndereco").val('Aguarde... Carregando...');
            $("#numeroEditaEndereco").val('Aguarde... Carregando...');
            $("#complementoEditaEndereco").val('Aguarde... Carregando...');
            $("#bairroEditaEndereco").val('Aguarde... Carregando...');
            $("#cidadeEditaEndereco").val('Aguarde... Carregando...');
            $("#estadoEditaEndereco").val('Aguarde... Carregando...');
            $("#botoesEditaEndereco").val('Aguarde... Carregando...');
        }
    });
}
function cadastrarEndereco(um, url, id, user){
    if ($("#nome"+id).val() == ''){
        alert('Informe o nome do endereço corretamente. Ex: Casa, Trabalho, etc.');
        $("#nome"+id).focus();
    }
    else if ($("#cepEndereco"+id).val() == ''){
        alert('Informe o cep do endereço corretamente.');
        $("#cepEndereco"+id).focus();
    }
    else if ($("#logradouroEndereco"+id).val() == ''){
        alert('Informe o logradouro do endereço corretamente.');
        $("#logradouroEndereco"+id).focus();
    }
    else if ($("#numeroEndereco"+id).val() == ''){
        alert('Informe o número do endereço corretamente.');
        $("#numeroEndereco"+id).focus();
    }
    else if ($("#bairroEndereco"+id).val() == ''){
        alert('Informe o bairro do endereço corretamente.');
        $("#bairroEndereco"+id).focus();
    }
    else if ($("#cidadeEndereco"+id).val() == ''){
        alert('Informe a cidade do endereço corretamente.');
        $("#cidadeEndereco"+id).focus();
    }
    else if ($("#estadoEndereco"+id).val() == ''){
        alert('Informe o estado do endereço corretamente.');
        $("#estadoEndereco"+id).focus();
    }
    else {
        $.ajax({
            url: url + 'ajax.php?&acao=cadastraEndereco&url=' + url + '&idCliente=' + $("#idCliente").val() + "&nome=" + $('#nome').val() + "&cepEndereco=" + $("#cepEndereco").val() + "&logradouroEndereco=" + $("#logradouroEndereco").val() + "&numeroEndereco=" + $("#numeroEndereco").val() + "&complementoEndereco=" + $("#complementoEndereco").val() + "&bairroEndereco=" + $("#bairroEndereco").val() + "&cidadeEndereco=" + $("#cidadeEndereco").val() + "&estadoEndereco=" + $("#estadoEndereco").val(),
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    alert('Endereço cadastrado com sucesso!');
                    visualizaEndereco(id, url, user);
                } else if (data[0] == 2) {
                    alert('Erro: ' + data[1]);
                }
            }
        });
    }
}
function salvarEndereco(url){
    if ($("#nome").val() == ''){
        alert('Informe o nome do endereço corretamente. Ex: Casa, Trabalho, etc.');
        $("#nome").focus();
    }
    else if ($("#cepEndereco").val() == ''){
        alert('Informe o cep do endereço corretamente.');
        $("#cepEndereco").focus();
    }
    else if ($("#logradouroEndereco").val() == ''){
        alert('Informe o logradouro do endereço corretamente.');
        $("#logradouroEndereco").focus();
    }
    else if ($("#numeroEndereco").val() == ''){
        alert('Informe o número do endereço corretamente.');
        $("#numeroEndereco").focus();
    }
    else if ($("#bairroEndereco").val() == ''){
        alert('Informe o bairro do endereço corretamente.');
        $("#bairroEndereco").focus();
    }
    else if ($("#cidadeEndereco").val() == ''){
        alert('Informe a cidade do endereço corretamente.');
        $("#cidadeEndereco").focus();
    }
    else if ($("#estadoEndereco").val() == ''){
        alert('Informe o estado do endereço corretamente.');
        $("#estadoEndereco").focus();
    }
    else {
        $.ajax({
            url: url + 'ajax.php?&acao=cadastraEndereco&url=' + url + '&idCliente=' + $("#idClienteEndereco").val() + "&nome=" + $('#nome').val() + "&cepEndereco=" + $("#cepEndereco").val() + "&logradouroEndereco=" + $("#logradouroEndereco").val() + "&numeroEndereco=" + $("#numeroEndereco").val() + "&complementoEndereco=" + $("#complementoEndereco").val() + "&bairroEndereco=" + $("#bairroEndereco").val() + "&cidadeEndereco=" + $("#cidadeEndereco").val() + "&estadoEndereco=" + $("#estadoEndereco").val(),
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    alert('Endereço cadastrado com sucesso!');
                    pegaEnderecos($("#idClienteEndereco").val(), url);
                    fecha('cadastrarEndereco');
                } else if (data[0] == 2) {
                    alert('Erro: ' + data[1]);
                }
            }
        });
    }
}
function atualizarEndereco(id, url, id2, user){
    if ($("#nome"+id+id2).val() == ''){
        alert('Informe o nome do endereço corretamente. Ex: Casa, Trabalho, etc.');
        $("#nome"+id+id2).focus();
    }
    else if ($("#cepEndereco"+id+id2).val() == ''){
        alert('Informe o cep do endereço corretamente.');
        $("#cepEndereco"+id+id2).focus();
    }
    else if ($("#logradouroEndereco"+id+id2).val() == ''){
        alert('Informe o logradouro do endereço corretamente.');
        $("#logradouroEndereco"+id+id2).focus();
    }
    else if ($("#numeroEndereco"+id+id2).val() == ''){
        alert('Informe o número do endereço corretamente.');
        $("#numeroEndereco"+id+id2).focus();
    }
    else if ($("#bairroEndereco"+id+id2).val() == ''){
        alert('Informe o bairro do endereço corretamente.');
        $("#bairroEndereco"+id+id2).focus();
    }
    else if ($("#cidadeEndereco"+id+id2).val() == ''){
        alert('Informe a cidade do endereço corretamente.');
        $("#cidadeEndereco"+id+id2).focus();
    }
    else if ($("#estadoEndereco"+id+id2).val() == ''){
        alert('Informe o estado do endereço corretamente.');
        $("#estadoEndereco"+id+id2).focus();
    }
    else {
        $.ajax({
            url: url + 'ajax.php?&acao=atualizarEndereco&url=' + url + '&user='+user+'&idCliente=' + $("#idCliente" + id+id2).val() + '&idEndereco=' + $("#idEndereco" + id+id2).val() + "&nome=" + $('#nome' + id+id2).val() + "&cepEndereco=" + $("#cepEndereco" + id+id2).val() + "&logradouroEndereco=" + $("#logradouroEndereco" + id+id2).val() + "&numeroEndereco=" + $("#numeroEndereco" + id+id2).val() + "&complementoEndereco=" + $("#complementoEndereco" + id+id2).val() + "&bairroEndereco=" + $("#bairroEndereco" + id+id2).val() + "&cidadeEndereco=" + $("#cidadeEndereco" + id+id2).val() + "&estadoEndereco=" + $("#estadoEndereco" + id+id2).val(),
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    alert('Endereço atualizado com sucesso!');
                    visualizaEndereco(id2, url);
                } else if (data[0] == 2) {
                    alert('Erro: ' + data[1]);
                }
            }
        });
    }
}
function abreFecha(id){
    if (document.getElementById(id).style.display == 'none'){
        $("#"+id).show('slow');
    }
    else{
        $("#"+id).hide('fast');
    }
}
function exportarNews(url, idUser){
    location.href=url+'exportarNews.php?nomeFiltro='+$('#nomeFiltro').val()+'&emailFiltro='+$('#emailFiltro').val()+'&dataFiltro='+$('#dataFiltro').val()+"&idUser="+idUser;
}
function exportarDominios(url, idUser){
    location.href=url+'exportarDominio.php?nomeFiltro='+$('#nomeFiltro').val()+'&emailFiltro='+$('#emailFiltro').val()+'&dataFiltro='+$('#dataFiltro').val()+"&idUser="+idUser;
}
function exportarLogs(url, idUser){
    location.href=url+'exportarLogs.php?usuarioFiltro='+$('#usuarioFiltro').val()+'&acaoFiltro='+$('#acaoFiltro').val()+"&idUser="+idUser;
}
function exportarClientes(url, idUser){
    location.href=url+'exportarClientes.php?nomeFiltro='+$('#nomeFiltro').val()+'&emailFiltro='+$('#emailFiltro').val()+"&idUser="+idUser;
}
function exportarPedidos(url, idUser){
    location.href=url+'exportarPedidos.php?idFiltro='+$('#idFiltro').val()+'&emailFiltro='+$('#emailFiltro').val()+"&idUser="+idUser;
}
function editarAlunos(id, url, idUser){
    $.ajax({
        url: url+'ajax.php?&acao=pegaDados&table=alunos&id=' + id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#idEdicao").val(data[1]);
                $("#nomeEdicao").val(data[2]);
                $("#matriculaEdicao").val(data[3]);
                $("#situacaoEdicao").val(data[4]);
                $("#cepEdicao").val(data[5]);
                $("#logradouroEdicao").val(data[6]);
                $("#numeroEdicao").val(data[7]);
                $("#complementoEdicao").val(data[8]);
                $("#bairroEdicao").val(data[9]);
                $("#cidadeEdicao").val(data[10]);
                $("#estadoEdicao").val(data[11]);
                $("#cursoEdicao").val(data[12]);
                $("#turmaEdicao").val(data[13]);
                $("#idUserEdicao").val(idUser);
                $("#botaoEditar").show('slow');
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#idEdicao").val('Aguarde... Carregando...');
            $("#nomeEdicao").val('Aguarde... Carregando...');
            $("#matriculaEdicao").val('Aguarde... Carregando...');
            $("#situacaoEdicao").val('0');
            $("#cepEdicao").val('Aguarde... Carregando...');
            $("#logradouroEdicao").val('Aguarde... Carregando...');
            $("#numeroEdicao").val('Aguarde... Carregando...');
            $("#bairroEdicao").val('Aguarde... Carregando...');
            $("#cidadeEdicao").val('Aguarde... Carregando...');
            $("estadoEdicao").val('Aguarde... Carregando...');
            $("cursoEdicao").val('');
            $("turmaEdicao").val('');
            $("#idUserEdicao").val(idUser);
            $("#botaoEditar").hide('fast');
        }
    });
}
function editarCursos(id, url, idUser){
    $.ajax({
        url: url+'ajax.php?&acao=pegaDados&table=cursos&id=' + id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#idEdicao").val(data[1]);
                $("#nomeEdicao").val(data[2]);
                $("#idUserEdicao").val(idUser);
                $("#botaoEditar").show('slow');
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#idEdicao").val('Aguarde... Carregando...');
            $("#nomeEdicao").val('Aguarde... Carregando...');
            $("#idUserEdicao").val(idUser);
            $("#botaoEditar").hide('fast');
        }
    });
}
function visualizarAlunos(id, url, idUser){
    $.ajax({
        url: url+'ajax.php?&acao=visualizar&table=alunos&id=' + id+"&idUser="+idUser,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#visualizacaoAlunos").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#visualizacaoAlunos").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function visualizarCursos(id, url, idUser){
    $.ajax({
        url: url+'ajax.php?&acao=visualizar&table=cursos&id=' + id+"&idUser="+idUser,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#visualizacaoCursos").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#visualizacaoCursos").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function editarUsuarios(id, url, idUser){
    $.ajax({
        url: url+'ajax.php?&acao=pegaDados&table=usuarios&id=' + id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#idEdicao").val(data[1]);
                $("#nomeEdicao").val(data[2]);
                $("#emailEdicao").val(data[3]);
                $("#senhaEdicao").val('');
                $("#imagemEdicao").val('');
                $("#idUserEdicao").val(idUser);
                $("#botaoEditar").show('slow');
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#idEdicao").val('Aguarde... Carregando...');
            $("#nomeEdicao").val('Aguarde... Carregando...');
            $("#emailEdicao").val('Aguarde... Carregando...');
            $("#senhaEdicao").val('Aguarde... Carregando...');
            $("#idUserEdicao").val(idUser);
            $("#botaoEditar").hide('fast');
        }
    });
}
function editarUsuariosPre(id, url, idUser){
    $.ajax({
        url: url+'ajax.php?&acao=pegaDados&table=usuariosPre&id=' + id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#idEdicao").val(data[1]);
                $("#nomeEdicao").val(data[2]);
                $("#emailEdicao").val(data[3]);
                $("#senhaEdicao").val('');
                $("#idUserEdicao").val(idUser);
                $("#botaoEditar").show('slow');
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#idEdicao").val('Aguarde... Carregando...');
            $("#nomeEdicao").val('Aguarde... Carregando...');
            $("#emailEdicao").val('Aguarde... Carregando...');
            $("#senhaEdicao").val('Aguarde... Carregando...');
            $("#idUserEdicao").val(idUser);
            $("#botaoEditar").hide('fast');
        }
    });
}
function editarTipoModulo(id, url, idUser){
    $.ajax({
        url: url+'ajax.php?&acao=pegaDados&table=tipoModulo&id=' + id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#idEdicao").val(data[1]);
                $("#statusEdicao").val(data[3]);
                $("#nomeEdicao").val(data[2]);
                $("#idUserEdicao").val(idUser);
                $("#botaoEditar").show('slow');
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#idEdicao").val('Aguarde... Carregando...');
            $("#nomeEdicao").val('Aguarde... Carregando...');
            $("#statusEdicao").val('0');
            $("#idUserEdicao").val(idUser);
            $("#botaoEditar").hide('fast');
        }
    });
}
function editarModulo(id, url, idUser){
    $.ajax({
        url: url+'ajax.php?&acao=pegaDados&table=modulo&id=' + id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#idEdicao").val(data[1]);
                $("#statusEdicao").val(data[3]);
                $("#nomeEdicao").val(data[2]);
                $("#tipoModuloEdicao").val(data[4]);
                $("#urlAmigavelEdicao").val(data[5]);
                $("#idUserEdicao").val(idUser);
                $("#botaoEditar").show('slow');
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#idEdicao").val('Aguarde... Carregando...');
            $("#nomeEdicao").val('Aguarde... Carregando...');
            $("#statusEdicao").val('0');
            $("#idUserEdicao").val(idUser);
            $("#botaoEditar").hide('fast');
        }
    });
}
function editarVersao(id, url, idUser){
    $.ajax({
        url: url+'ajax.php?&acao=pegaDados&table=versao&id=' + id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#idEdicao").val(data[1]);
                $("#descricaoEdicao").val(data[3]);
                $("#nomeEdicao").val(data[2]);
                $("#dataEdicao").val(data[4]);
                $("#idUserEdicao").val(idUser);
                $("#botaoEditar").show('slow');
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#idEdicao").val('Aguarde... Carregando...');
            $("#nomeEdicao").val('Aguarde... Carregando...');
            $("#valorEdicao").val('Aguarde... Carregando...');
            $("#idUserEdicao").val(idUser);
            $("#botaoEditar").hide('fast');
        }
    });
}
function visualizarTipoModulo(id, url, idUser){
    $.ajax({
        url: url+'ajax.php?&acao=visualizar&table=tipoModulo&id=' + id+"&idUser="+idUser,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#visualizacaoTipoModulo").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#visualizacaoTipoModulo").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function visualizarModulo(id, url, idUser){
    $.ajax({
        url: url+'ajax.php?&acao=visualizar&table=modulo&id=' + id+"&idUser="+idUser,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#visualizacaoModulo").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#visualizacaoModulo").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function visualizarVersao(id, url, idUser){
    $.ajax({
        url: url+'ajax.php?&acao=visualizar&table=versao&id=' + id+"&idUser="+idUser,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#visualizacaoVersao").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#visualizacaoVersao").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function visualizarUsuarios(id, url, idUser = ""){
    $.ajax({
        url: url+'ajax.php?&acao=visualizar&table=usuarios&id=' + id+"&idUser="+idUser,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#visualizacaoUsuarios").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#visualizacaoUsuarios").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function visualizarUsuariosPre(id, url, idUser = ""){
    $.ajax({
        url: url+'ajax.php?&acao=visualizar&table=usuariosPre&id=' + id+"&idUser="+idUser,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#visualizacaoUsuariosPre").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#visualizacaoUsuariosPre").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function addVersao(){
    $("#nomeCadastro").val('');
    $("#descricaoCadastro").val('');
    $("#dataCadastro").val('');
    $("#imagemCadastro").val('');
}
function addModulo(){
    $("#tipoModuloCadastro").val('');
    $("#nomeCadastro").val('');
    $("#urlAmigavelCadastro").val('');
    $("#statusCadastro").val(0);
}
function addUsuario(){
    $("#nomeCadastro").val('');
    $("#statusCadastro").val(0);
}
function addCursos(){
    $("#nomeCadastro").val('');
}
function addAlunos(){
    $("#nomeCadastro").val('');
    $("#matriculaCadastro").val('');
    $("#situacaoCadastro").val('0');
    $("#cepCadastro").val('');
    $("#logradouroCadastro").val('');
    $("#numeroCadastro").val('');
    $("#complementoCadastro").val('');
    $("#bairroCadastro").val('');
    $("#cidadeCadastro").val('');
    $("#estadoCadastro").val('');
    $("#cursosCadastro").val('');
    $("#turmaCadastro").val('');
    $("#imagemCadastro").val('');
}
function addCidades(){
    $("#nomeCadastro").val('');
    $("#estadoCadastro").val('');
    $("#capitalCadastro").val('0');
}
function importaCursos(){
    $("#arquivoImporta").val('');
}
function excluirUsuarios(id, url, idUser, artigo, table){
    if (confirm('Tem certeza que deseja excluir esse Usuário?')){
        $.ajax({
            url: url+'ajax.php?&acao=excluir&table=users&id=' + id+"&artigo="+artigo+"&idUser="+idUser+"&tabela="+table,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    verificaNovamente('usuarios', url, idUser);
                }
            }
        });
    }
}
function excluirUsuariosPre(id, url, idUser, artigo, table){
    if (confirm('Tem certeza que deseja excluir esse Usuário Pre?')){
        $.ajax({
            url: url+'ajax.php?&acao=excluir&table=user_pres&id=' + id+"&artigo="+artigo+"&idUser="+idUser+"&tabela="+table,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    verificaNovamente('usuariosPre', url, idUser);
                }
            }
        });
    }
}
function excluirVersao(id, url, idUser, artigo, table){
    if (confirm('Tem certeza que deseja excluir essa Versão?')){
        $.ajax({
            url: url+'ajax.php?&acao=excluir&table=versions&id=' + id+"&artigo="+artigo+"&idUser="+idUser+"&tabela="+table,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    verificaNovamente('versao', url, idUser);
                }
            }
        });
    }
}

function mascaraValor(valor, id) {
    valor = valor.toString().replace(/\D/g,"");
    valor = valor.toString().replace(/(\d)(\d{8})$/,"$1.$2");
    valor = valor.toString().replace(/(\d)(\d{5})$/,"$1.$2");
    valor = valor.toString().replace(/(\d)(\d{2})$/,"$1,$2");
    document.getElementById(id).value = valor;
}
function verificaNovamente(tela, url, idUser = "", pagina = "") {
    pagina = (pagina) ? pagina : $("#pagina").val();
    $("#pagina").val(pagina);
    $.ajax({
        url: url+'ajax.php?&acao=verificaNovamente&tela=' + tela+"&dataFiltro="+$("#dataFiltro").val()+'&paginaFiltro='+$("#paginaFiltro").val()+"&subitemFiltro="+$("#subitemFiltro").val()+"&bannerFiltro="+$("#bannerFiltro").val()+"&nomeFiltro="+$("#nomeFiltro").val()+"&emailFiltro="+$("#emailFiltro").val()+"&tipoServicoFiltro="+$("#tipoServicoFiltro").val()+"&idUser="+idUser+"&pagina="+$("#pagina").val()+"&usuarioFiltro="+$('#usuarioFiltro').val()+"&acaoFiltro="+$('#acaoFiltro').val()+"&tipoModuloFiltro="+$("#tipoModuloFiltro").val()+"&idFiltro="+$("#idFiltro").val()+"&formaPagamentoFiltro="+$("#formaPagamentoFiltro").val()+"&statusFiltro="+$("#statusFiltro").val()+"&nomeProdutoFiltro="+$("#nomeProdutoFiltro").val()+"&idProdutoFiltro="+$("#idProdutoFiltro").val()+"&dataFimFiltro="+$("#dataFimFiltro").val()+"&cursoFiltro="+$("#cursoFiltro").val()+"&turmaFiltro="+$("#turmaFiltro").val(),
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#conteudo").html(data[1]);
                $("#contadorSite").html(data[2]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            //$("#conteudo").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function limparCampos(){
    $("#id").val('');
    $("#product_type").val('');
    $("#code").val('');
    $("#name").val('');
    $("#value").val('');
    $("#promotion").val('');
    $("#validity_promotion").val('');
    $("#status").val('0');
}
function listarItensVenda(id, url){
    $.ajax({
        url: url+'ajax.php?&acao=listarItensVenda&id=' + id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#itensVendaProduto").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#itensVendaProduto").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
function excluirTipoModulo(id, url, idUser, artigo, table) {
    if (confirm('Tem certeza que deseja excluir esse Tipo de Módulo?')) {
        $.ajax({
            url: url+'ajax.php?&acao=excluir&table=type_modules&id=' + id+"&artigo="+artigo+"&idUser="+idUser+"&tabela="+table,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    verificaNovamente('tipoModulo', url);
                }
            }
        });
    }
}
function excluirModulo(id, url, idUser, artigo, table) {
    if (confirm('Tem certeza que deseja excluir esse Módulo?')) {
        $.ajax({
            url: url+'ajax.php?&acao=excluir&table=modules&id=' + id+"&artigo="+artigo+"&idUser="+idUser+"&tabela="+table,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    verificaNovamente('modulo', url, idUser);
                }
            }
        });
    }
}
function excluirAlunos(id, url, idUser, artigo, table) {
    if (confirm('Tem certeza que deseja excluir esse aluno?')) {
        $.ajax({
            url: url+'ajax.php?&acao=excluir&table=students&id=' + id+"&artigo="+artigo+"&idUser="+idUser+"&tabela="+table,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    verificaNovamente('alunos', url, idUser);
                    $('#registroExcluidoComSucesso').show('slow');
                    window.setInterval('$("#registroExcluidoComSucesso").hide("fast")', 15000);
                }
            }
        });
    }
}
function excluirCursos(id, url, idUser, artigo, table) {
    if (confirm('Tem certeza que deseja excluir esse curso?')) {
        $.ajax({
            url: url+'ajax.php?&acao=excluir&table=courses&id=' + id+"&artigo="+artigo+"&idUser="+idUser+"&tabela="+table,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    verificaNovamente('cursos', url, idUser);
                    $('#registroExcluidoComSucesso').show('slow');
                    window.setInterval('$("#registroExcluidoComSucesso").hide("fast")', 15000);
                }
            }
        });
    }
}
function excluirImg(table, id, url, idUser, artigo){
    if (confirm('Tem certeza que deseja excluir essa imagem?')) {
        $.ajax({
            url: url+'ajax.php?&acao=excluirImg&table='+table+'&id=' + id+"&idUser="+idUser+"&artigo="+artigo,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    if (table == 'usuarios') {
                        visualizarUsuarios(id, url, idUser);
                    }
                    else if (table == 'produto'){
                        visualizarProdutos(id, url, idUser);
                    }
                    else if (table == 'formaPagamento'){
                        visualizarFormaPagamento(id, url, idUser);
                    }
                    else if (table == 'banner'){
                        visualizarBanner(id, url, idUser);
                    }
                    else if (table == 'pagina'){
                        visualizarPagina(id, url, idUser);
                    }
                    else if (table == 'subitem'){
                        visualizarSubitem(id, url, idUser);
                    }
                    else if (table == 'versao'){
                        visualizarVersao(id, url, idUser);
                    }
                    else if (table == 'alunos'){
                        visualizarAlunos(id, url, idUser);
                    }
                    else if (table == 'usuario'){
                        visualizarUsuarios(id, url, idUser);
                        if (data[1] == id && data[2]){
                            $('#imgUser').html('<img src="'+data[2]+'" onclick="abreFecha(\'saiUsuarios\')" style="cursor:pointer" class="img-circle elevation-2" alt="User Image">');
                        }
                    }
                }
            }
        });
    }
}
function aprovaUsuario(id, url, idUser){
    if (confirm('Tem certeza que deseja aprovar esse usuário?')){
        $.ajax({
            url: url + 'ajax.php?&acao=aprovarUsuario&id=' + id+"&idUser="+idUser,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    alert('Usuário aprovado com sucesso!');
                    verificaNovamente('usuarios-pre', url, idUser);
                }
            },
            beforeSend: function () {
            }
        });
    }
}
function valida_cnpj(cnpj) {

    cnpj = cnpj.replace(/[^\d]+/g, '');

    if (cnpj == '') return false;

    if (cnpj.length != 14)
        return false;


    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999")
        return false;


    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0, tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0)) return false;
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false;

    return true;

}

function formataCampo(campo, Mascara, evento) {



    var boleanoMascara;







    var Digitato = evento.keyCode;



    exp = /\-|\.|\/|\(|\)| /g



    campoSoNumeros = campo.value.toString().replace( exp, "" );







    var posicaoCampo = 0;



    var NovoValorCampo="";



    var TamanhoMascara = campoSoNumeros.length;;







    if (Digitato != 8) { // backspace



        for(i=0; i<= TamanhoMascara; i++) {



            boleanoMascara  = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")



                || (Mascara.charAt(i) == "/"))



            boleanoMascara  = boleanoMascara || ((Mascara.charAt(i) == "(")



                || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " "))



            if (boleanoMascara) {



                NovoValorCampo += Mascara.charAt(i);



                TamanhoMascara++;



            }else {



                NovoValorCampo += campoSoNumeros.charAt(posicaoCampo);



                posicaoCampo++;



            }



        }



        campo.value = NovoValorCampo;



        return true;



    }else {



        return true;



    }



}