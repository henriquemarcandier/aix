function abreFecha(id){
	if (document.getElementById(id).style.display == 'none'){
		$("#"+id).show('slow');
	}
	else{
		$("#"+id).hide('fast');
	}
}
function abre(id){
	$("#"+id).show('slow');
}
function fecha(id){
	$("#"+id).hide('fast');
}
function sair(pagina) {
	if(confirm('Tem certeza que deseja sair do sistema?')){
        $.ajax({
            url: 'ajax.php?acao=logout',
            success: function(data) {
                if (data == 1) {
                    $('#logoutEfetuadoComSucesso').show('slow');
                    $('#aguardeSaindoDoSistema').hide('fast');
                    location.href = pagina;
                }
            },
            beforeSend: function(){
                $('#aguardeSaindoDoSistema').css({display:"block"});
                $('#logoutEfetuadoComSucesso').hide('fast');
            }
        });
	}
}
function validateEmail(email) {
    var regex = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
    if (!regex.test(email)){
        return false;
    } else {
        return true;
    }
}
function size(obj,size){
    var stri = new String(obj.value);
    if ( stri.length < size ){
        return false;
    }
    return true;
}
function abreFechaVersoes(){
	if ($("#outrasVersoes").css("display") == 'none'){
		$('#outrasVersoes').show('slow');
        $("#imagemOutrasVersoes").html('<img src="img/versionClose.png" width="35">');
	}
	else{
		$("#outrasVersoes").hide('fast');
        $("#imagemOutrasVersoes").html('<img src="img/outrasVersoes.png" width="35">');
	}
}
$(function(){

$('[data-toggle="tooltip"]').tooltip();

$('.show-password').click(function(){
	var psswrd = $(this).prev();
	
	if( psswrd.attr("type") == "password" ) {
		psswrd.attr('type', 'text').focus().val(psswrd.val());
		$(this).css('opacity','1');
	} else {
		psswrd.attr('type', 'password').focus().val(psswrd.val());
		$(this).css('opacity','.4');
	}
});

$('.phoneMask').focusout(function(){
	var phone, element;
	element = jQuery(this);
	element.unmask();
	phone = element.val().replace(/\D/g, '');
	if(phone.length > 10) {
		element.mask("(99) 99999-999?9");
	} else {
		element.mask("(99) 9999-9999?9");
	}
}).trigger('focusout');


$('.triggerEnable').click(function(){
   $('.enableField').attr('disabled',!this.checked);
});

$('#dateRange').daterangepicker({
	"applyClass": "btn-default",
	"cancelClass": "btn-cancel",
	"locale": {
		"format": "DD/MM/YYYY",
		"separator": " - ",
		"applyLabel": "Aplicar",
		"cancelLabel": "Cancelar",
		"fromLabel": "De",
		"toLabel": "Para",
		"customRangeLabel": "Custom",
		"weekLabel": "S",
		"daysOfWeek": [
			"Dom",
			"Seg",
			"Ter",
			"Qua",
			"Qui",
			"Sex",
			"Sab"
		],
		"monthNames": [
			"Janeiro",
			"Fevereiro",
			"Março",
			"Abril",
			"Maio",
			"Junho",
			"Julho",
			"Agosto",
			"Setembro",
			"Outubro",
			"Novembro",
			"Dezembro"
		]
	}
});

$('.calendario').daterangepicker({
	singleDatePicker: true,
	"locale": {
		"format": "DD/MM/YYYY",
		"separator": " - ",
		"applyLabel": "Aplicar",
		"cancelLabel": "Cancelar",
		"fromLabel": "De",
		"toLabel": "Para",
		"customRangeLabel": "Custom",
		"weekLabel": "S",
		"daysOfWeek": [
			"Dom",
			"Seg",
			"Ter",
			"Qua",
			"Qui",
			"Sex",
			"Sab"
		],
		"monthNames": [
			"Janeiro",
			"Fevereiro",
			"Março",
			"Abril",
			"Maio",
			"Junho",
			"Julho",
			"Agosto",
			"Setembro",
			"Outubro",
			"Novembro",
			"Dezembro"
		]
	}
});

$(".slct").select2();

$(".slct-hide-search").select2({ minimumResultsForSearch: Infinity });

/* loading */
$(".load-more .btn").click(function(){
	$(this).hide();
	$(".loading").fadeIn();
	return false;
});

/* tags input */
$('.tags-input').tagsInput({ width:'auto', height:'40px', defaultText: 'adicionar tag' });

/* selecionar todos */
$('.select-all :checkbox').click(function() {
	if($(this).is(":checked")) {
		$('.conteudo :checkbox').prop('checked',true);
		$('.btn-group-conteudo').show();
	} else {
		$('.conteudo :checkbox').prop('checked',false);
		$('.btn-group-conteudo').hide();
	}
});

$('.conteudo :checkbox').click(function(){
	$('.select-all :checkbox').prop('checked',false);
	$('.btn-group-conteudo').show();
	
	var checkBox = $(".conteudo :checkbox");
	if(!checkBox.length == checkBox.filter(":checked").length){
		$('.btn-group-conteudo').hide();
	}
});

/* playlist */
$('.playlist-selectable :checkbox').click(function(){
	$(this).parents('.playlist').toggleClass('selected');
	$('#removerSelecionados').show();
	
	var checkBox = $(".playlist-selectable :checkbox");
	if(!checkBox.length == checkBox.filter(":checked").length){
		$('#removerSelecionados').hide();
	}
});

$('.playlist-selectable .playlist-thumbs').click(function(){
	var playlist = $(this).parents('.playlist-selectable');
	var playlistCheckBox = playlist.find("input[type='checkbox']");
	
	playlist.toggleClass('selected');
	
	if(!playlistCheckBox.is(":checked")) {
		playlistCheckBox.prop('checked',true);
	} else {
		playlistCheckBox.prop('checked',false);
	}
	
	$('#removerSelecionados').show();
	
	var checkBox = $(".playlist-selectable :checkbox");
	if(!checkBox.length == checkBox.filter(":checked").length){
		$('#removerSelecionados').hide();
	}
	
});

/* adicionar a playlist */
$('#criarPlaylist').change(function(){
	$('#selecionarPlaylist, #criarNovaPlaylist').toggle();
});

/* exemplos interacao - deletar */
$(".loading").click(function(){
	$(this).hide();
	$(".load-more .btn").fadeIn();
	return false;
});

$(".integracao .btn").click(function(){
	$('#conectar, #desconectar').toggle();
	return false;
});
/* FIM - exemplos interacao - deletar */


});