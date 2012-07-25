$(document).ready(function() {
	
	
	
	var tabs = $('#form-tab');
	var legends = $(tabs).find('fieldset').get();
		
	var titles = $('<ul></ul>');
	$.each(legends, function(index, value) { 
		var legend = $(value).find('legend');
		
		var id = $(value).attr('id');
		var a = $('<a></a>').attr('href', '#' + id).text($(legend).text());
		var li = $('<li></li>').append(a);
		
		$(legend).remove();

		$(titles).append(li);			
		var div = $('<div></div>').attr('id', id);
		$(div).html($(value).html());
		$(tabs).append(div);

		$(value).remove();
		});
	$(tabs).prepend(titles);
	$(tabs).tabs();
	
	$("tfoot").css("display", "none");
	$("#hide").css("display", "none");
	
	$('#show').click(function() {		
		$("tfoot").show();
		$("#hide").show();
		$("#show").hide();
	});
	
	$('#hide').click(function() {		
		$("tfoot").hide();
		$("#hide").hide();
		$("#show").show();
	});
	
	
	$('#date_1').focus(function(){
	    $(this).calendario({
	        target:'#date_1'
	    });
 	});
	$('#date_2').focus(function(){
	    $(this).calendario({
	        target:'#date_2'
	    });
 	});

	$('#Pessoa-cep_citado').setMask('99.999-999');
	$('#Pessoa-telefone_citado').setMask('(99)9999-9999');
	$('#datasituacao').setMask('date');
	$('#valordocumento').setMask('decimal');
	$('#emolumento').setMask('decimal');
	$('#valor_correio').setMask('decimal');
	$('#outrasdespesas').setMask('decimal');
	$('#taxajudiciaria').setMask('decimal');
	$('#funcivil').setMask('decimal');
	$('#total_custas').setMask('decimal');
	
	$('#Pessoa-documento_citado').setMask('cnpj');
	$('input[name="Pessoa[tipo_identificacao_citado]"]').change(function(){
		if($(this).val() == '2'){	
			$('#Pessoa-documento_citado').setMask('cpf');		
		}else{
			$('#Pessoa-documento_citado').setMask('cnpj');
		}
	})

	
	$('#Requerente-cep_requerente').setMask('99.999-999');
	$('#Requerente-telefone_requerente').setMask('(99)9999-9999');
	$('#data_pedido').setMask('date');
	$('#data_prevista').setMask('date');
	$('#data_entrega').setMask('date');
	$('#itempedido-datasituacao').setMask('date');
	$('#valor_pedido').setMask('decimal');
	$('#valor_deposito').setMask('decimal');
	$('#valor_receber').setMask('decimal');
	$('#itempedido-valordocumento').setMask('decimal');
	$('#itempedido-emolumento').setMask('decimal');
	$('#itempedido-valor_correio').setMask('decimal');
	$('#itempedido-outrasdespesas').setMask('decimal');
	$('#itempedido-taxajudiciaria').setMask('decimal');
	$('#itempedido-funcivil').setMask('decimal');
	$('#itempedido-total_custas').setMask('decimal');

	$('#itempedido-notificado-documento_notificado').setMask('cnpj');
	$('input[name="itempedido[notificado][tipo_identificacao_notificado]"]').change(function(){
		if($(this).val() == '2'){	
			$('#itempedido-notificado-documento_notificado').setMask('cpf');		
		}else{
			$('#itempedido-notificado-documento_notificado"]').setMask('cnpj');
		}
	})

		
	$('#itempedido-notificante-documento_notificante').setMask('cnpj');
	$('input[name="itempedido[notificante][tipo_identificacao_notificante]"]').change(function(){
		if($(this).val() == '2'){	
			$('#itempedido-notificante-documento_notificante').setMask('cpf');		
		}else{
			$('#itempedido-notificante-documento_notificante"]').setMask('cnpj');
		}
	})

	$('#Requerente-documento_requerente').setMask('cnpj');
	$('input[name="Requerente[tipo_identificacao_requerente]"]').change(function(){
		if($(this).val() == '2'){	
			$('#Requerente-documento_requerente').setMask('cpf');		
		}else{
			$('#Requerente-documento_requerente').setMask('cnpj');
		}
	})
	
	oTable = $('#tabela').dataTable({
		"oLanguage": {
			"oPaginate": {
	        "sFirst":    "Primeiro",
	        "sPrevious": "Anterior",
	        "sNext":     "Seguinte",
	        "sLast":     "Último"},
	        	
			"sProcessing":   "Processando...",
		    "sLengthMenu":   "Mostrar _MENU_ registros",
		    "sZeroRecords":  "Não foram encontrados resultados",
		    "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
		    "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
		    "sInfoFiltered": "(filtrado de _MAX_ registros no total)",	    
		    "sSearch":       "Buscar:"	    
		},
		
		"bPaginate": true,
		"bJQueryUI": false,
		"sPaginationType": "full_numbers"
			
	});
	
    
	
	$("tfoot input").keyup( function () {
        /* Filter on the column (the index) of this element */
        oTable.fnFilter( this.value, $("tfoot input").index(this) );
    } );
     
    /*
     * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
     * the footer
     */
    $("tfoot input").each( function (i) {
        asInitVals[i] = this.value;
    } );
     
    $("tfoot input").focus( function () {
        if ( this.className == "search_init" )
        {
            this.className = "";
            this.value = "";
        }
    } );
     
    $("tfoot input").blur( function (i) {
        if ( this.value == "" )
        {
            this.className = "search_init";
            this.value = asInitVals[$("tfoot input").index(this)];
        }
    } );
	
	$('#submitbutton').click(function() {	
		$('#dialog-modal').dialog({
			show: { effect: 'fade' , duration: 1000 },
			height: 66,
			modal: true,
			closeOnEscape: false,
			closeText: 'hide',
			resizable: false
		});
	});
});


function startProgress()
{
    var iFrame = document.createElement('iframe');
    document.getElementsByTagName('body')[0].appendChild(iFrame);
    iFrame.src = 'MyController.php';
}

function Zend_ProgressBar_Update(data)
{
    document.getElementById('pg-percent').style.width = data.percent + '%';
    document.getElementById('pg-text-1').innerHTML = data.text;
    document.getElementById('pg-text-2').innerHTML = data.text;
}

function Zend_ProgressBar_Finish()
{
    document.getElementById('pg-percent').style.width = '100%';
    document.getElementById('pg-text-1').innerHTML = 'done';
    document.getElementById('pg-text-2').innerHTML = 'done';
}

