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
        if($("#CG_Num").val()!="" && $("#CG_Intitule").val()!=""){
            existance();
            if(!exist && $_GET("CG_Num")==""){
                alert("Ce compte existe déjà !");
            } else {
                Ajouter();
                exist=false;
            }
        } else {
            alert("Veuillez saisir un numéro de compte et son intitulé !");
        }
    });
        
    function existance(){
        $.ajax({
           url: "indexServeur.php?page=getPlanComptableByCGNum",
           method: 'GET',
           dataType: 'json',
           data : "CG_Num="+$("#CG_Num").val(),
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

    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                }
        });
    }
    function setType(){
        var val = false;
        if($("#CG_Type").val()==1){ 
            val = true;
            $("#N_Nature").val();
            $("#N_Nature").val();
            $("#N_Nature").val();
            $("#N_Nature").val();
            $("#N_Nature").val();
        }
        $('#N_Nature').prop('disabled', val);
        $('#CG_Report').prop('disabled', val);
        $('#TA_Code').prop('disabled', val);
        $('#CG_Regroup').prop('disabled', val);
        $('#CG_Analytique').prop('disabled', val);
        $('#CG_Echeance').prop('disabled', val);
        $('#CG_Quantite').prop('disabled', val);
        $('#CG_Tiers').prop('disabled', val);
        $('#CG_Lettrage').prop('disabled', val);
        $('#CG_Sommeil').prop('disabled', val);
    }
    setType();
    
    function valClassement(){
        $("#CG_Classement").val($("#CG_Intitule").val().substring(0,16));
    }
    
    $("#CG_Intitule").focusout(function(){
        valClassement();
    });
    
    $("#CG_Type").change(function(){
        setType();
    });
    
    function Ajouter(){
        if($_GET("CG_Num")==null){
            var num ='';
            $.ajax({
                url: 'traitement/Structure/Comptabilite/PlanComtable.php?acte=ajout',
                method: 'GET',
                dataType: 'json',
                data : $("#formPlanComptable").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=9&action=1&acte=ajoutOK&CG_Num="+data.CG_Num);
                } 
            }); 
        }else {
            var num ='';
            var cg_num=$_GET("CG_Num");
            $.ajax({
                url: 'traitement/Structure/Comptabilite/PlanComtable.php?acte=modif&CG_Num='+cg_num+"&CG_Type="+$("#CG_Type").val(),
                method: 'GET',
                dataType: 'json',
                data : $("#formPlanComptable").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=9&action=1&acte=modifOK&CG_Num="+data.CG_Num);
                } 
            });
        }
    }
    
    $.widget( "custom.comboCompteg", {
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
        $("#cat_tarif").val("5");
        
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "form-control combocompteg" )
          .css("width", "200px")
          .css("height", "30px")
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
    
        $( "#compteg" ).comboCompteg();
        $( "#compteg" ).css({ float: "left" });
                //$( "#deno" ).comboDeno();
        
});