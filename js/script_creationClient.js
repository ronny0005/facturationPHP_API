jQuery(function($){

        var protect=0;
        var type =0;
    if($_GET("action")==9) type=1;
    if($_GET("action")==17) type=2;

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

    $("#CT_Encours").inputmask({   'alias': 'numeric',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 0,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '',
        allowPlus: true,
        allowMinus: false
    })

    $('#ajouterClient').click(function(){
        if($("#ncompte").val()=="")
            alert("le numéro de compte doit être renseigné !");
        else{
            $.ajax({
                url: 'traitement/Creation.php?acte=clientByIntitule',
                method: 'POST',
                dataType: 'html',
                data: "CT_Intitule=" + $("#intitule").val(),
                success: function (data) {
                    if(data!="")
                        alert(data);
                    else
                        ajouterClient();
                },
                error: function (resultat, statut, erreur) {
                    alert(resultat.responseText);
                }
            });
        }
    });
        
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    if($_GET("action")=="9")
                        protect=this.PROT_FOURNISSEUR;
                    if($_GET("action")=="2")
                        protect=this.PROT_CLIENT;
                    if($_GET("action")=="17")
                        protect=this.PROT_CLIENT;

                    if(protect==1){
                        $("#form-creationClient :input").prop("disabled", true);
                    }
                });
            }
        });
    }
    protection();  
    function ajouterClient(){
        //if($(".comboclient").val().length!=0 && $("#designation option:selected").length!=0){
        if($_GET("CT_Num")==null){
            var num ='';
            $("#add_err").css('display', 'none', 'important');
            $.ajax({
                url: 'traitement/Creation.php?acte=ajout_client&PROT_No='+$("#PROT_No").val(),
                method: 'GET',
                dataType: 'json',
                data : $("#form-creationClient").serialize(),
                success: function(data) {
                    if(type==0)
                        window.location.replace("indexMVC.php?module=3&action=4&acte=ajoutOK&CT_Num="+data.CT_Num);

                    if(type==1)
                        window.location.replace("indexMVC.php?module=3&action=8&acte=ajoutOK&CT_Num="+data.CT_Num);
                    if(type==2)
                        window.location.replace("indexMVC.php?module=3&action=16&acte=ajoutOK&CT_Num="+data.CT_Num);
                },
                
                error : function(resultat, statut, erreur){
                    alert(resultat.responseText);
                }
                
            }); 
        }else {
            var num ='';
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_client&page=insertClientMin&PROT_No='+$("#PROT_No").val(),
                method: 'GET',
                dataType: 'json',
                data : $("#form-creationClient").serialize()+"&CT_Num="+$_GET("CT_Num"),
                success: function(data) {
                    if(type==0)
                        window.location.replace("indexMVC.php?module=3&action=4&acte=modifOK&CT_Num="+data.CT_Num);
                    if(type==1)
                        window.location.replace("indexMVC.php?module=3&action=8&acte=modifOK&CT_Num="+data.CT_Num);
                    if(type==2)
                        window.location.replace("indexMVC.php?module=3&action=16&acte=modifOK&CT_Num="+data.CT_Num);
                },

                error : function(resultat, statut, erreur){
                    alert(resultat.responseText);
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
    
    
    $.widget( "custom.comboDeno", {
      _create: function() {
          
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .css("width", "200px")
          .css("height", "30px")
          .addClass( "form-control combodeno" )
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
    
        $( "#CG_NumPrinc" ).comboCompteg();
        //if($_GET("CT_Num")==null) $(".combocompteg").val("");
        $( "#CG_NumPrinc" ).css({ float: "left" });
                //$( "#deno" ).comboDeno();
        
});