jQuery(function($){

        var protect=0;
        var type =0;
        var exist = false;
    function $_GET(param) {
	var vars = {};
	window.location.href.replace( location.hash, '' ).replace( 
		/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
		function( m, key, value ) { // callback
			vars[key] = value !== undefined ? value : '';
		}
	);

	if ( param ) {
		return vars[param] ? vars[param] : null;	
	}
	return vars;
    }
    
    $('#Ajouter').click(function(){
        if($("#JO_Num").val()!="" && $("#JO_Intitule").val()!=""){
            existance();
            if(!exist || $_GET("#JO_Num")!=""){
                Ajouter();
                exist=false;
            } else {
                alert("Ce compte existe déjà !");
            }
        } else {
            alert("Veuillez saisir un numéro de compte et son intitulé !");
        }
    });
    
        function existance(){
        $.ajax({
           url: "indexServeur.php?page=getJournauxByJONum",
           method: 'GET',
           dataType: 'json',
           data : "JO_Num="+$("#JO_Num").val(),
           async: false,
           success: function(data) {
               if(data!="")
               exist =true;
           }
        });
    }

        
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    protect=this.PROT_DEPOT;
                    if(protect==1){
                        $('#intitule').prop('disabled', true);
                        $('#adresse').prop('disabled', true);
                        $('#complement').prop('disabled', true);
                        $('#cp').prop('disabled', true);
                        $('#region').prop('disabled', true);
                        $('#pays').prop('disabled', true);
                        $('#responsable').prop('disabled', true);
                        $('#cat_compta').prop('disabled', true);
                        $('#code_depot').prop('disabled', true);
                        $('#tel').prop('disabled', true);
                    }
                });
            }
        });
    }
    
    protection();  

    function bloqueForm(){
        if($("#JO_Type").val()!="2" && $("#JO_Type").val()!="3" && $("#JO_Type").val()!="4"){
            $("#CG_Num").prop("disabled",true);
            $("#CG_Num_select").prop("disabled",true);
            $("#JO_Contrepartie").prop("disabled",true);
            $("#JO_Rappro").prop("disabled",true);
            $("#JO_Reglement").prop("disabled",true);
        }else {
            if($("#JO_Type").val()=="3" || $("#JO_Type").val()=="4") {
                $("#JO_Contrepartie").prop("disabled",true);
                $("#JO_Rappro").prop("disabled",true);
                $("#JO_Reglement").prop("disabled",true);
            }else{
                $("#JO_Contrepartie").prop("disabled",false);
                $("#JO_Rappro").prop("disabled",false);
                $("#JO_Reglement").prop("disabled",false);
            }
            $("#CG_Num").prop("disabled",false);
            $("#JO_SuiviTreso").val("");
            if($_GET("JO_Num")==null){
                $('#JO_Contrepartie').attr('checked', false);
                $("#JO_Rappro").val(0);
            }
            $("#JO_Reglement").attr('checked', false);
            $("#CG_Num_select").prop("disabled",false);
        }
    }
    $("#JO_Type").change(function(){
        bloqueForm();
    });
    
    function Ajouter(){
        if($_GET("JO_Num")==null){
            var num ='';
            $.ajax({
                url: 'traitement/Structure/Comptabilite/Journal.php?acte=ajout&CG_Num='+$("#CG_Num").val(),
                method: 'GET',
                dataType: 'json',
                data : $("#formJournal").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=9&action=7&acte=ajoutOK&JO_Num="+data.JO_Num);
                } 
            }); 
        }else {
            var num ='';
            var jo_num=$_GET("JO_Num");
            $.ajax({
                url: 'traitement/Structure/Comptabilite/Journal.php?acte=modif&JO_Num='+jo_num+'&CG_Num='+$("#CG_Num").val(),
                method: 'GET',
                dataType: 'json',
                data : $("#formJournal").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=9&action=7&acte=modifOK&JO_Num="+data.JO_Num);
                } 
            });
        }
    }
    
    $.widget( "custom.comboCompteg", {
      _create: function() {
          
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .css("width", "100%")
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
        $("#cat_tarif").val("5");
        
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "form-control combocompteg" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
                        this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
    
    $( "#CG_Num" ).comboCompteg();
    var cmp = 0;
    $(".combocompteg").each(function(){
        if(cmp==0) $(this).attr("id", "CG_Num_select");
        cmp=cmp+1;
    });
    
    bloqueForm();
});