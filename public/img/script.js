$("#formRealizarPedido").submit(function(evt){
    evt.preventDefault();
    var url = $("#urlRealizarPedido").val();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: 'ajax.php?acao=salvarCarrinho',
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
                alert('Erro: '+vet[1]);
            }
            else if (vet[0] == 1) {
                alert('Produto inserido com sucesso! Fecha essa tela e clique sobre Carrinho de Compras para prosseguir com a sua compra!');
                $("#produtoRealizarPedido").val('');
                selecionaProduto('', url);
            }
        },
    });
    return false;
});
$("#formNews").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: 'ajax.php?acao=salvarNews',
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
            }
            else if (vet[0] == 1) {
                $("#emailNews").val('');
                alert('Email cadastrado com sucesso! Aguarde a nossa próxima news!');
            }
        },
    });
    return false;
});
$("#formBugTracking").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: 'ajax.php?acao=salvarBugTracking',
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
            }
            else if (vet[0] == 1) {
                $("#nameBugTracking").val('');
                $("#emailBugTracking").val('');
                $("#titleBugTracking").val('');
                $("#typeService").val('');
                $("#typeVersion").val('');
                $("#priority").val('');
                $("#category").val('');
                $("#message").val('');
                alert('Bug Tracking enviado com sucesso! Aguarde um retorno por email!');
            }
        },
    });
    return false;
});
$("#formContato").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: 'ajax.php?acao=salvarContato',
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
            }
            else if (vet[0] == 1) {
                $("#name").val('');
                $("#email").val('');
                $("#subject").val('');
                $("#phone").val('');
                $("#text").val('');
                alert('Email enviado com sucesso! Aguarde um retorno por telefone ou email!');
            }
        },
    });
    return false;
});
$("#formLogin").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    var url = $('#url').val();
    $.ajax({
        url: url+'ajax.php?acao=realizarLogin',
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
            }
            else if (vet[0] == 1) {
                alert('Você está logado em nosso site! Aguarde o refresh da página!');
                location.href = url;
            }
        },
    });
    return false;
});
$("#formAlterarSenha").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    var url = $('#url').val();
    $.ajax({
        url: 'ajax.php?acao=alterarSenha',
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
            }
            else if (vet[0] == 1) {
                alert('Senha alterada com sucesso! Aguarde o refresh da página!');
                location.href=url+"#area-do-cliente";
            }
        },
    });
    return false;
});
$("#formCadastro").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    var url = $('#url').val();
    $.ajax({
        url: 'ajax.php?acao=cadastro',
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
                alert('Cadastro efetuado com sucesso! Aguarde o refresh da página!');
                location.href = url;
            }
        },
    });
    return false;
});
$("#formCadastro2").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    var url = $('#url').val();
    $.ajax({
        url: 'ajax.php?acao=atualizarCadastro',
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
                $("#nomeCliente").html(vet[1]);
                alert('Cadastro atualizado com sucesso!');
            }
        },
    });
    return false;
});
$("#formAtualizarSenha").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    var url = $('#url').val();
    $.ajax({
        type: 'POST',
        url: 'ajax.php?acao=atualizarSenha',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (result) {
            var vet = result.split('|-|');
            if (vet[0] == 0) {
                $("#"+vet[2]).focus();
                alert(vet[1]);
            } else if (vet[0] == 1) {
                $("#senhaAlterarSenha").val('');
                $("#novaSenhaAlterarSenha").val('');
                $("#redigitoSenhaAlterarSenha").val('');
                alert('Senha atualizada com sucesso!');
            }
        },
    });
    return false;
});
$("#formEsqueceuSuaSenha").submit(function(evt){
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: 'ajax.php?acao=enviarEsqueceuSuaSenha',
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
                $('#emailEsqueceuSuaSenha').val('');
                alert('Não foi encontrado esse email em nossa base de dados.');
            }
            else if (vet[0] == 1) {
                $('#emailEsqueceuSuaSenha').val('');
                alert('Email enviado com sucesso. Procure pelo email e clique no link.');
            }
        },
    });
    return false;
});
$("#formItemVenda").submit(function(evt){
    if ($("#id").val() == "") {
        evt.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: 'ajax.php?acao=cadastrarItemVenda',
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
                    alert('Item Venda cadastrado com sucesso!');
                    listarItensVenda($('#product').val(), $("#url").val());
                    $("#id").val('');
                    $("#product_type").val('');
                    $("#code").val('');
                    $("#name").val('');
                    $("#value").val('');
                    $("#promotion").val('');
                    $("#validity_promotion").val('');
                    $("#status").val('0');
                }
            },
        });
        return false;
    }
    else{
        evt.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: 'ajax.php?acao=editarItemVenda',
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
                    alert('Item Venda atualizado com sucesso!');
                    listarItensVenda($('#product').val(), $("#url").val());
                    $("#id").val('');
                    $("#product_type").val('');
                    $("#code").val('');
                    $("#name").val('');
                    $("#value").val('');
                    $("#promotion").val('');
                    $("#validity_promotion").val('');
                    $("#status").val('0');
                }
            },
        });
        return false;
    }
});
function fechaTodos() {
    $("#modalloja-virtual").hide('fast');
    $("#modalsites").hide('fast');
    $("#modalsites-internacionais").hide('fast');
    $("#modalsistema-escolar").hide('fast');
    $("#modalsistema-de-caixa").hide('fast');
    $("#modalcatalogo-virtual").hide('fast');
    $("#modalhospedagem-de-sites").hide('fast');
    $("#modalregistro-de-dominios").hide('fast');
    $("#modalaplicativos-para-celular").hide('fast');
    $("#modalvideos").hide('fast');
}
function pesquisacep(valor, id) {
    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep.length == 8) {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;
        //Valida o formato do CEP.
        if(validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logradouroEndereco').value="Aguarde... Pesquisando...";
            document.getElementById('numeroEndereco').value="Aguarde... Pesquisando...";
            document.getElementById('complementoEndereco').value="Aguarde... Pesquisando...";
            document.getElementById('bairroEndereco').value="Aguarde... Pesquisando...";
            document.getElementById('cidadeEndereco').value="Aguarde... Pesquisando...";
            document.getElementById('estadoEndereco').value="";
            //Cria um elemento javascript.
            var script = document.createElement('script');
            //Sincroniza com o callback.
            script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=retornoCEP';
            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);
        } //end if.
        else {
            //cep é inválido.
            alert("Formato de CEP inválido.");
            document.getElementById('logradouroEndereco').value="";
            document.getElementById('bairroEndereco').value="";
            document.getElementById('numeroEndereco').value="";
            document.getElementById('complementoEndereco').value="";
            document.getElementById('cidadeEndereco').value="";
            document.getElementById('estadoEndereco').value="";
            document.getElementById('logradouroEndereco').focus();
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
    }
};
function retornoCEP(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('logradouroEndereco').value=(conteudo.logradouro);
        document.getElementById('bairroEndereco').value=(conteudo.bairro);
        document.getElementById('numeroEndereco').value="";
        document.getElementById('complementoEndereco').value="";
        document.getElementById('cidadeEndereco').value=(conteudo.localidade);
        document.getElementById('estadoEndereco').value=(conteudo.uf);
        document.getElementById('numeroEndereco').focus();
    } //end if.
    else {
        //CEP não Encontrado.
        alert("CEP não encontrado. Digeite as informações manualmente!");
        document.getElementById('logradouroEndereco').value="";
        document.getElementById('bairroEndereco').value="";
        document.getElementById('numeroEndereco').value="";
        document.getElementById('complementoEndereco').value="";
        document.getElementById('cidadeEndereco').value="";
        document.getElementById('estadoEndereco').value="";
        document.getElementById('logradouroEndereco').focus();
    }
}
function pesquisacepRealizarPedido(valor) {
    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep.length == 8) {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;
        //Valida o formato do CEP.
        if(validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logadouroRealizarPedido').value="Aguarde... Pesquisando...";
            document.getElementById('numeroRealizarPedido').value="Aguarde... Pesquisando...";
            document.getElementById('complementoRealizarPedido').value="Aguarde... Pesquisando...";
            document.getElementById('bairroRealizarPedido').value="Aguarde... Pesquisando...";
            document.getElementById('cidadeRealizarPedido').value="Aguarde... Pesquisando...";
            document.getElementById('estadoRealizarPedido').value="";
            //Cria um elemento javascript.
            var script = document.createElement('script');
            //Sincroniza com o callback.
            script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=retornoCEPRealizarPedido';
            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);
        } //end if.
        else {
            //cep é inválido.
            alert("Formato de CEP inválido.");
            document.getElementById('logadouroRealizarPedido').value="";
            document.getElementById('bairroRealizarPedido').value="";
            document.getElementById('numeroRealizarPedido').value="";
            document.getElementById('complementoRealizarPedido').value="";
            document.getElementById('cidadeRealizarPedido').value="";
            document.getElementById('estadoRealizarPedido').value="";
            document.getElementById('logradouroRealizarPedido').focus();
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
    }
};
function retornoCEPRealizarPedido(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('logadouroRealizarPedido').value=(conteudo.logradouro);
        document.getElementById('bairroRealizarPedido').value=(conteudo.bairro);
        document.getElementById('numeroRealizarPedido').value="";
        document.getElementById('complementoRealizarPedido').value="";
        document.getElementById('cidadeRealizarPedido').value=(conteudo.localidade);
        document.getElementById('estadoRealizarPedido').value=(conteudo.uf);
        document.getElementById('numeroRealizarPedido').focus();
    } //end if.
    else {
        //CEP não Encontrado.
        alert("CEP não encontrado. Digeite as informações manualmente!");
        document.getElementById('logadouroRealizarPedido').value="";
        document.getElementById('bairroRealizarPedido').value="";
        document.getElementById('numeroRealizarPedido').value="";
        document.getElementById('complementoRealizarPedido').value="";
        document.getElementById('cidadeRealizarPedido').value="";
        document.getElementById('estadoRealizarPedido').value="";
        document.getElementById('logradouroRealizarPedido').focus();
    }
}
function pesquisacepEscolaRealizarPedido(valor) {
    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep.length == 8) {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;
        //Valida o formato do CEP.
        if(validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logadouroEscolaRealizarPedido').value="Aguarde... Pesquisando...";
            document.getElementById('numeroEscolaRealizarPedido').value="Aguarde... Pesquisando...";
            document.getElementById('complementoEscolaRealizarPedido').value="Aguarde... Pesquisando...";
            document.getElementById('bairroEscolaRealizarPedido').value="Aguarde... Pesquisando...";
            document.getElementById('cidadeEscolaRealizarPedido').value="Aguarde... Pesquisando...";
            document.getElementById('estadoEscolaRealizarPedido').value="";
            //Cria um elemento javascript.
            var script = document.createElement('script');
            //Sincroniza com o callback.
            script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=retornoCEPEscolaRealizarPedido';
            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);
        } //end if.
        else {
            //cep é inválido.
            alert("Formato de CEP inválido.");
            document.getElementById('logadouroEscolaRealizarPedido').value="";
            document.getElementById('bairroEscolaRealizarPedido').value="";
            document.getElementById('numeroEscolaRealizarPedido').value="";
            document.getElementById('complementoEscolaRealizarPedido').value="";
            document.getElementById('cidadeEscolaRealizarPedido').value="";
            document.getElementById('estadoEscolaRealizarPedido').value="";
            document.getElementById('logradouroEscolaRealizarPedido').focus();
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
    }
};
function retornoCEPEscolaRealizarPedido(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('logadouroEscolaRealizarPedido').value=(conteudo.logradouro);
        document.getElementById('bairroEscolaRealizarPedido').value=(conteudo.bairro);
        document.getElementById('numeroEscolaRealizarPedido').value="";
        document.getElementById('complementoEscolaRealizarPedido').value="";
        document.getElementById('cidadeEscolaRealizarPedido').value=(conteudo.localidade);
        document.getElementById('estadoEscolaRealizarPedido').value=(conteudo.uf);
        document.getElementById('numeroEscolaRealizarPedido').focus();
    } //end if.
    else {
        //CEP não Encontrado.
        alert("CEP não encontrado. Digeite as informações manualmente!");
        document.getElementById('logadouroEscolaRealizarPedido').value="";
        document.getElementById('bairroEscolaRealizarPedido').value="";
        document.getElementById('numeroEscolaRealizarPedido').value="";
        document.getElementById('complementoEscolaRealizarPedido').value="";
        document.getElementById('cidadeEscolaRealizarPedido').value="";
        document.getElementById('estadoEscolaRealizarPedido').value="";
        document.getElementById('logradouroEscolaRealizarPedido').focus();
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
function cadastrarEndereco(id, url){
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
            url: url + 'ajax.php?&acao=cadastrarEndereco&url=' + url + '&idCliente=' + $("#idCliente" + id).val() + "&nome=" + $('#nome' + id).val() + "&cepEndereco=" + $("#cepEndereco" + id).val() + "&logradouroEndereco=" + $("#logradouroEndereco" + id).val() + "&numeroEndereco=" + $("#numeroEndereco" + id).val() + "&complementoEndereco=" + $("#complementoEndereco" + id).val() + "&bairroEndereco=" + $("#bairroEndereco" + id).val() + "&cidadeEndereco=" + $("#cidadeEndereco" + id).val() + "&estadoEndereco=" + $("#estadoEndereco" + id).val(),
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    alert('Endereço cadastrado com sucesso!');
                    visualizaEndereco(id, url);
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
function atualizarEndereco(id, url, id2){
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
            url: url + 'ajax.php?&acao=atualizarEndereco&url=' + url + '&idCliente=' + $("#idCliente" + id+id2).val() + '&idEndereco=' + $("#idEndereco" + id+id2).val() + "&nome=" + $('#nome' + id+id2).val() + "&cepEndereco=" + $("#cepEndereco" + id+id2).val() + "&logradouroEndereco=" + $("#logradouroEndereco" + id+id2).val() + "&numeroEndereco=" + $("#numeroEndereco" + id+id2).val() + "&complementoEndereco=" + $("#complementoEndereco" + id+id2).val() + "&bairroEndereco=" + $("#bairroEndereco" + id+id2).val() + "&cidadeEndereco=" + $("#cidadeEndereco" + id+id2).val() + "&estadoEndereco=" + $("#estadoEndereco" + id+id2).val(),
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
function editarEndereco(url){
    var id2 = $("#idClienteEditaEndereco").val();
    if ($("#nomeEdita").val() == ''){
        alert('Informe o nome do endereço corretamente. Ex: Casa, Trabalho, etc.');
        $("#nomeEdita").focus();
    }
    else if ($("#cepEditaEndereco").val() == ''){
        alert('Informe o cep do endereço corretamente.');
        $("#cepEditaEndereco").focus();
    }
    else if ($("#logradouroEditaEndereco").val() == ''){
        alert('Informe o logradouro do endereço corretamente.');
        $("#logradouroEditaEndereco").focus();
    }
    else if ($("#numeroEditaEndereco").val() == ''){
        alert('Informe o número do endereço corretamente.');
        $("#numeroEditaEndereco").focus();
    }
    else if ($("#bairroEditaEndereco").val() == ''){
        alert('Informe o bairro do endereço corretamente.');
        $("#bairroEditaEndereco").focus();
    }
    else if ($("#cidadeEditaEndereco").val() == ''){
        alert('Informe a cidade do endereço corretamente.');
        $("#cidadeEditaEndereco").focus();
    }
    else if ($("#estadoEditaEndereco").val() == ''){
        alert('Informe o estado do endereço corretamente.');
        $("#estadoEditaEndereco").focus();
    }
    else {
        $.ajax({
            url: url + 'ajax.php?&acao=atualizarEndereco&url=' + url + '&idCliente=' + $("#idClienteEditaEndereco").val() + '&idEndereco=' + $("#idEditaEndereco").val() + "&nome=" + $('#nomeEdita').val() + "&cepEndereco=" + $("#cepEditaEndereco").val() + "&logradouroEndereco=" + $("#logradouroEditaEndereco").val() + "&numeroEndereco=" + $("#numeroEditaEndereco").val() + "&complementoEndereco=" + $("#complementoEditaEndereco").val() + "&bairroEndereco=" + $("#bairroEditaEndereco").val() + "&cidadeEndereco=" + $("#cidadeEditaEndereco").val() + "&estadoEndereco=" + $("#estadoEditaEndereco").val(),
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    alert('Endereço atualizado com sucesso!');
                    fecha('editaEndereco');
                    pegaEnderecos(id2, url);
                } else if (data[0] == 2) {
                    alert('Erro: ' + data[1]);
                }
            }
        });
    }
}
function mostraCarrinhoDeCompras(idClient, url){
    $("#finalizarPedido").hide('fast');
    $.ajax({
        url: url+'ajax.php?&acao=mostraCarrinhoDeCompras&idClient=' + idClient,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#carrinhoDeCompras").html(data[1]);
                $("#numProdutosCarrinho").val(data[2]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#carrinhoDeCompras").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function excluirCarrinho(id, url){
    if (confirm('Tem certeza que deseja excluir esse produto do carrinho?')){
        $.ajax({
            url: url+'ajax.php?&acao=excluirCarrinho&id=' + id,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    mostraCarrinhoDeCompras('', url);
                } else if (data[0] == 0) {
                    alert('Erro: '+data[1]);
                }
            },
            beforeSend: function () {
                $("#carrinhoDeCompras").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
            }
        });
    }
}
function finalizarPedido(url) {
    if ($("#numProdutosCarrinho").val() == 0){
        alert('Nenhum produto no carrinho de compras!');
    }
    else {
        $("#finalizarPedido").show('slow');
        $.ajax({
            url: url + 'ajax.php?&acao=finalizarPedido',
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    $("#finalizarPedido").html(data[1]);
                } else if (data[0] == 0) {
                    alert('Erro: ' + data[1]);
                }
            },
            beforeSend: function () {
                $("#finalizarPedido").html('<button type="button" class="close" onClick=fecha("finalizarPedido")><span aria-hidden="true">&times;</span></button><img src="' + url + 'img/loader.gif" width="20"> Aguarde... Carregando...');
            }
        });
        location.href = "#finalizarPedido";
    }
}
function comprar(url){
    if ($('#formaPagamentoCompra').val() == ""){
        alert('Informe a forma de pagamento corretamente!');
        $("#formaPagamentoCompra").focus();
    }
    else if ($('#enderecoCompra').val() == ""){
        alert('Informe o endereço da compra corretamente!');
        $("#enderecoCompra").focus();
    }
    else{
        if(confirm('Tem certeza que deseja realizar o pedido?')) {
            $.ajax({
                url: url + 'ajax.php?&acao=comprar&payment_method=' + $('#formaPagamentoCompra').val() + '&address=' + $('#enderecoCompra').val(),
                success: function (data) {
                    var data = data.split('|-|');
                    if (data[0] == 1) {
                        $("#finalizarPedido").html(data[1]);
                        mostraComprovante(data[2], url);
                        //mostraCarrinhoDeCompras('', url);
                    } else if (data[0] == 0) {
                        alert('Erro: ' + data[1]);
                    }
                },
                beforeSend: function () {
                    $("#finalizarPedido").html('<img src="' + url + 'img/loader.gif" width="20"> Aguarde... Carregando Comprovante...');
                }
            });
        }
    }
}
function verInformacoesSistemaEscolar(id) {
    $("#informacoesSistemaEscolar" + id).show('slow');
}
function verInformacoesSistemaCaixa(id){
    $("#informacoesSistemaCaixa"+id).show('slow');
}
function mostraComprovante(request_id, url){
    $.ajax({
        url: url + 'ajax.php?&acao=mostra_comprovante&request_id=' + request_id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#finalizarPedido").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: ' + data[1]);
            }
        },
        beforeSend: function () {
            $("#finalizarPedido").html('<img src="' + url + 'img/loader.gif" width="20"> Aguarde... Carregando Comprovante...');
        }
    });
}
function selecionaFormaPagamento(id, url, t){
    $.ajax({
        url: url+'ajax.php?&acao=enderecosCompra&id='+id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#enderecosCompra").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#enderecosCompra").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function limparCarrinho(url){
    if (confirm('Tem certeza que deseja limpar esse carrinho?')){
        $.ajax({
            url: url+'ajax.php?&acao=limparCarrinho',
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    mostraCarrinhoDeCompras('', url);
                } else if (data[0] == 0) {
                    alert('Erro: '+data[1]);
                }
            },
            beforeSend: function () {
                $("#carrinhoDeCompras").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
            }
        });
    }
}
function pegaPedidos(idClient, url){
    $.ajax({
        url: url+'ajax.php?&acao=pegaPedidos&idClient=' + idClient,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#pedidosCliente").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#pedidosCliente").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function excluirEndereco(id, url, id2) {
    if(confirm("Tem certeza que deseja excluir o endereço "+id+"?")){
        $.ajax({
            url: url+'ajax.php?&acao=excluirEndereco&id=' + id,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    alert('Endereço excluído com sucesso! Aguarde o carregamento dos endereços!');
                    visualizaEndereco(id2, url);
                    pegaEnderecos(id2, url);
                } else if (data[0] == 2) {
                    alert('Erro: '+data[1]);
                }
            },
            beforeSend: function () {
                $("#htmlVisualizaEnderecos"+id).html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
            }
        });
    }
}
function visualizaEndereco(id, url){
    $.ajax({
        url: url+'ajax.php?&acao=visualizaEnderecos&id=' + id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#htmlVisualizaEnderecos"+id).html(data[1]);
            } else if (data[0] == 2) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#htmlVisualizaEnderecos"+id).html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function selecionaTipoServicoBugTracking(id){
    if (id == ""){
        $("#tipoVersaoHTML").html('<label class="form-label">\n' +
            '                                Versão\n' +
            '                                <span class="text-danger">*</span>\n' +
            '                            </label>\n' +
            '\n' +
            '                            <select class="form-control" name="typeVersion" id="typeVersion" required\n' +
            '                                    data-msg="Por Favor, informe o tipo de Serviço."\n' +
            '                                    data-error-class="u-has-error"\n' +
            '                                    data-success-class="u-has-success">\n' +
            '                                <option value="">Selecione o tipo de serviço corretamente</option>\n' +
            '                            </select>');
        $("#prioridadeHTML").html('<label class="form-label">\n' +
            '                                Prioridade\n' +
            '                                <span class="text-danger">*</span>\n' +
            '                            </label>\n' +
            '\n' +
            '                            <select class="form-control" name="priority" id="priority" required\n' +
            '                                    data-msg="Por Favor, informe a prioridade."\n' +
            '                                    data-error-class="u-has-error"\n' +
            '                                    data-success-class="u-has-success">\n' +
            '                                <option value="">Selecione o tipo de serviço corretamente</option>\n' +
            '                            </select>');
        $("#categoriaHTML").html('<label class="form-label">\n' +
            '                                Categoria\n' +
            '                                <span class="text-danger">*</span>\n' +
            '                            </label>\n' +
            '\n' +
            '                            <select class="form-control" name="category" id="category" required\n' +
            '                                    data-msg="Por Favor, informe a categoria."\n' +
            '                                    data-error-class="u-has-error"\n' +
            '                                    data-success-class="u-has-success">\n' +
            '                                <option value="">Selecione o tipo de serviço corretamente</option>\n' +
            '                            </select>');
    }
    else {
        $.ajax({
            url: 'ajax.php?&acao=selecionaTipoServiço&id=' + id,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    $("#tipoVersaoHTML").html(data[1]);
                    $("#prioridadeHTML").html(data[2]);
                    $("#categoriaHTML").html(data[3]);
                } else if (data[0] == 2) {
                    alert('Erro: '+data[1]);
                }
            },
            beforeSend: function () {
                $("#tipoVersaoHTML").html('<img src="img/loader.gif" width="20"> Aguarde... Carregando...');
                $("#prioridadeHTML").html('<img src="img/loader.gif" width="20"> Aguarde... Carregando...');
                $("#categoriaHTML").html('<img src="img/loader.gif" width="20"> Aguarde... Carregando...');
            }
        });
    }
}
function selecionaTipoServicoAdmin(id, url){
    if (id == ""){
        $("#versaoHTML").html('<select name="typeVersion" id="typeVersion" required>\n' +
            '                                <option value="">Selecione o tipo de serviço corretamente</option>\n' +
            '                            </select>');
        $("#prioridadeHTML").html('<select  name="priority" id="priority" required>\n' +
            '                                <option value="">Selecione o tipo de serviço corretamente</option>\n' +
            '                       </select>');
        $("#categoriaHTML").html('<select name="category" id="category" required>\n' +
            '                                <option value="">Selecione o tipo de serviço corretamente</option>\n' +
            '                            </select>');
    }
    else {
        $.ajax({
            url: url+'ajax.php?&acao=selecionaTipoServiçoAdmin&id=' + id,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    $("#versaoHTML").html(data[1]);
                    $("#prioridadeHTML").html(data[2]);
                    $("#categoriaHTML").html(data[3]);
                } else if (data[0] == 2) {
                    alert('Erro: '+data[1]);
                }
            },
            beforeSend: function () {
                $("#versaoHTML").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
                $("#prioridadeHTML").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
                $("#categoriaHTML").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
            }
        });
    }
}
function pegaEnderecos(idCliente, url){
    $.ajax({
        url: url+'ajax.php?&acao=pegaEnderecos&idCliente=' + idCliente,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
                $("#enderecosCliente").html(data[1]);
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
        beforeSend: function () {
            $("#enderecosCliente").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
        }
    });
}
function novoEndereco(){
    $("#novoEndereco").show('slow');
}
function abre(id){
    $("#loja-virtual").hide('fast');
    $("#sites").hide('fast');
    $("#sites-internacionais").hide('fast');
    $("#sistema-escolar").hide('fast');
    $("#sistema-de-caixa").hide('fast');
    $("#catalogo-virtual").hide('fast');
    $("#hospedagem-de-sites").hide('fast');
    $("#registro-de-dominios").hide('fast');
    $("#aplicativos-para-celular").hide('fast');
    $("#videos").hide('fast');
    $("#"+id).show('slow');
    location.href='#'+id;
}
function detalhesPedido(id, url){
    $("#detalhesPedido").show('slow');
    if (id == ""){
        $("#detalhesPedido").html('<button type="button" class="close" onClick=fecha("detalhesPedido")><span aria-hidden="true">&times;</span></button>Selecione o pedido corretamente...');
    }else{
        $.ajax({
            url: url+'ajax.php?&acao=detalhesPedido&id=' + id,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    $("#detalhesPedido").html(data[1]);
                } else if (data[0] == 0) {
                    alert('Erro: '+data[1]);
                }
            },
            beforeSend: function () {
                $("#detalhesPedido").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
            }
        });
    }
}
function selecionaProduto(id, url){
    $("#productItemsRealizarPedido").show('slow');
    if(id == ""){
        $("#productItemsRealizarPedido").hide('fast');
    }
    else{
        $.ajax({
            url: url+'ajax.php?&acao=selecionaProduto&product=' + id,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    $("#productItemsRealizarPedido").html(data[1]);
                } else if (data[0] == 0) {
                    alert('Erro: '+data[1]);
                }
            },
            beforeSend: function () {
                $("#productItemsRealizarPedido").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
            }
        });
    }
}
function selecionaProdutoItem(id, url, id2){
    $("#passo03").show('slow');
    if(id2 == ""){
        alert('Selecione o item do produto corretamente!');
        $("#passo03").hide('fast');
    }
    else{
        $.ajax({
            url: url+'ajax.php?&acao=selecionaPasso03&product=' + id,
            success: function (data) {
                var data = data.split('|-|');
                if (data[0] == 1) {
                    $("#passo03").html(data[1]);
                } else if (data[0] == 0) {
                    alert('Erro: '+data[1]);
                }
            },
            beforeSend: function () {
                $("#passo03").html('<img src="'+url+'img/loader.gif" width="20"> Aguarde... Carregando...');
            }
        });
    }
}
function mostraMenu(qual, qtosTem){
    for (i = 0; i < qtosTem; i++){
        document.getElementById('menu'+i).className = "nav-item";
    }
    document.getElementById('menu'+qual).className = "nav-item active";
}
function contaAcessoPagina(id){
    $.ajax({
        url: 'ajax.php?&acao=contaAcessoPagina&id='+id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
    });
}
function contaAcessoSubitem(id){
    $.ajax({
        url: 'ajax.php?&acao=contaAcessoSubitem&id='+id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
    });
}
function contaAcessoBanner(id){
    $.ajax({
        url: 'ajax.php?&acao=contaAcessoBanner&id='+id,
        success: function (data) {
            var data = data.split('|-|');
            if (data[0] == 1) {
            } else if (data[0] == 0) {
                alert('Erro: '+data[1]);
            }
        },
    });
}
var url = document.URL;
var vet = url.split('/');
if (vet[2] == 'localhost') {
    url = vet[5].replace('#', '');
}
else{
    url = vet[3].replace('#', '');
}
if (!url){
    url = 'home';
}
$.ajax({
    url: 'ajax.php?&acao=contaAcesso&url='+url,
    success: function (data) {
        var data = data.split('|-|');
        if (data[0] == 1) {
        } else if (data[0] == 0) {
            alert('Erro: '+data[1]);
        }
    },
});
