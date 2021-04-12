

<html >
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
	<meta charset="utf-8" />
	<title>Caisse</title>
	
	<script type="text/javascript" src="js/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/dataTables.bootstrap.min.js"></script>
	
	<link rel="stylesheet" href="bootstrap.css" type="text/css" media="all" />
	<link rel="stylesheet" href="dataTables.bootstrap.min.css" type="text/css" media="all" />
	
	<script type="text/javascript" language="javascript" class="init">
		$(document).ready(function() {
			var table = $('#example').dataTable( {
				"processing": true,
				"serverSide": true,
				"ajax": {"url":  "server_processing.php", "data": function ( d ) {d.extra_search = "borice";}}
		});
		
		$("#recherche").click(function () {
            table.api().ajax.reload();
        });
		
	});
	</script>
	
</head>
<body>
	
	<div id="page">
	
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
	<form  method="GET">
    <table style="margin-bottom: 20px">
    <thead>
        <tr>
            <td style="width:100px;vertical-align: middle">Date de d&eacute;but :</td>
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="3" name="action"/>
            <td><input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" /></td>
            <td style="padding-left: 10px;width:95px;vertical-align: middle">Date de fin :</td>
            <td><input type="text" class="form-control" name="datefin"  style="width : 100px" value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" /></td>
            <td style="padding-left: 10px;width:60px;vertical-align: middle"> D&eacute;pot :</td>
            <td style="padding-left: 10px;width:200px;">
                <select class="form-control" name="depot" id="depot">
                    <?php
                    $result=$objet->db->requete($objet->depot());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    $depot="";
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->DE_No."";
                            if($row->DE_No==$depot_no) echo " selected";
                            echo ">".$row->DE_Intitule."</option>";
                        }
                    }
                    ?>
                </select>
            </td>
            <td><input type="submit" id="valider" class="btn btn-success" value="Valider"/></td>
        </tr>
</table>
</form>
	
								<div class="col-md-12">
                                    <button type="button" class="btn btn-success" id="recherche">Rechercher</button>
                                </div>
	
		<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Designation</th>
                <th>Quantite</th>
                <th>Prix revient</th>
                <th>PR Global</th>
				<th>Suivi stock</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Reference</th>
                <th>Designation</th>
                <th>Quantite</th>
                <th>Prix revient</th>
                <th>PR Global</th>
		<th>Suivi stock</th>
                
            </tr>
        </tfoot>
        
        <tbody></tbody>
    </table>
  </div>
 </body>
</html>