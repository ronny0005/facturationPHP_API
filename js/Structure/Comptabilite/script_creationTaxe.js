jQuery(function($){

        var protect=0;
        var type =0;
            
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
        Ajouter();
    });
        
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

    function Ajouter(){
        
        var value = [];
        $("#CompteRattache option").each(function()
        {
            value.push($(this).val());
        }); 
        if($_GET("TA_Code")==null){
    
            var num ='';
            $.ajax({
                url: 'traitement/Structure/Comptabilite/Taxe.php?acte=ajout&ComteRattache='+value,
                method: 'GET',
                dataType: 'json',
                data : $("#formTaxe").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=9&action=5&acte=ajoutOK&TA_Code="+data.TA_Code);
                } 
            }); 
        }else {
            var num ='';
            var ta_code=$_GET("TA_Code");
            $.ajax({
                url: 'traitement/Structure/Comptabilite/Taxe.php?acte=modif&TA_Code='+ta_code+'&ComteRattache='+value,
                method: 'GET',
                dataType: 'json',
                data : $("#formTaxe").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=9&action=5&acte=modifOK&TA_Code="+data.TA_Code);
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
    
    $( "#CG_Num" ).combobox();
    $( "#compteRat" ).combobox();
    var cmp = 0;
    $(".custom-combobox").each(function(){
        if(cmp==0) $(this).attr("id", "CG_Num_select");
        if(cmp==1) $(this).attr("id", "compteRat_select");
        cmp=cmp+1;
    });
    
    $("#compteRat_select").keyup(
        function (event) {
        if(event.keyCode == 13){
            $("#CompteRattache").append("<option value='"+$("#compteRat").val()+"'>"+$(this).val()+"</option>");
            $(this).val("");
        } 
    });
    
    $("#CompteRattache").dblclick(function() {
        $("#CompteRattache option[value='"+$(this).find(":selected").val()+"']").remove();
    });
    
    
});