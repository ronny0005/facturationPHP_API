<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];  
    $protected = 0;
    $result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        if($rows[0]->PROT_FAMILLE==1 || $rows[0]->PROT_FAMILLE==3) $protected = $rows[0]->PROT_FAMILLE;
    }
?>
<script src="js/script_listeCatalogue.js?d=<?php echo time(); ?>"></script>
</head>

<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">    
    <div class="container">
    
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
<div class="corps">        
 
    <table class="table" id="tableNiv0" style="float: left;width:200px; margin-right:30px">
        <thead>
            <tr>
                <th>Famille niveau 1</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select class="form-control" id="selecthniv0" size="10" width="200px">
                    <?php
                            $objet = new ObjetCollector();   

                            $result=$objet->db->requete($objet->getCatalogue(0));     
                            $rows = $result->fetchAll(PDO::FETCH_OBJ);
                            if($rows==null){
                            }else{
                                foreach ($rows as $row){
                                echo "<option value='".$row->CL_No."'>".$row->CL_Intitule."</option>";
                                }
                            }
                          ?>
                    </select>
                </td></tr>
            <tr>
                <td>Nouveau :<input type="text" name="" maxlength="35" id="hniv0" class="form-control" <?php if($protected==1 && $protected==3) echo "disabled";   ?> /><input type="hidden" name="" id="valhniv0" class="form-control" /></td>
            </tr>
        </tbody>            
    </table>
    <table class="table" id="table" style="float: left;width:200px;">
        <thead>
            <tr>
                <th>Famille niveau 2</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select class="form-control" id="selecthniv1" size="10" width="200px" disabled>
                    <?php
                            $objet = new ObjetCollector();   

                            $result=$objet->db->requete($objet->getCatalogue(1));     
                            $rows = $result->fetchAll(PDO::FETCH_OBJ);
                            if($rows==null){
                            }else{
                                foreach ($rows as $row){
                                //echo "<option value='".$row->CL_No."'>".$row->CL_Intitule."</option>";
                                }
                            }
                          ?>
                    </select>
                </td></tr>
            <tr>
                <td>Nouveau :<input type="text" name="" maxlength="35" id="hniv1" class="form-control" disabled/><input type="hidden" name="" id="valhniv1" class="form-control" <?php if($protected==1 && $protected==3) echo "disabled";   ?> /></td>
            </tr>
        </tbody>            
    </table>
    <table class="table" id="table" style="float: left;width:200px;margin-left:40px">
        <thead>
            <tr>
                <th>Famille niveau 3</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select class="form-control" id="selecthniv2" size="10" width="200px" disabled>
                    <?php
                            $objet = new ObjetCollector();   

                            $result=$objet->db->requete($objet->getCatalogue(2));     
                            $rows = $result->fetchAll(PDO::FETCH_OBJ);
                            if($rows==null){
                            }else{
                                foreach ($rows as $row){
                                //echo "<option value='".$row->CL_No."'>".$row->CL_Intitule."</option>";
                                }
                            }
                          ?>
                    </select>
                </td></tr>
            <tr>
                <td>Nouveau :<input type="text" name="" maxlength="35" id="hniv2" class="form-control" disabled/><input type="hidden" name="" id="valhniv2" class="form-control" <?php if($protected==1 && $protected==3) echo "disabled";   ?> /></td>
            </tr>
        </tbody>            
    </table>
    <table class="table" id="table" style="float: left;width:200px;margin-left:40px">
        <thead>
            <tr>
                <th>Famille niveau 4</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select class="form-control" id="selecthniv3" size="10" width="200px" disabled>
                    <?php
                            $objet = new ObjetCollector();   

                            $result=$objet->db->requete($objet->getCatalogue(3));     
                            $rows = $result->fetchAll(PDO::FETCH_OBJ);
                            if($rows==null){
                            }else{
                                foreach ($rows as $row){
                                //echo "<option value='".$row->CL_No."'>".$row->CL_Intitule."</option>";
                                }
                            }
                          ?>
                    </select>
                </td></tr>
            <tr>
                <td>Nouveau :<input type="text" name="" maxlength="35" id="hniv3" class="form-control" disabled/><input type="hidden" name="" id="valhniv3" class="form-control" <?php if($protected==1 && $protected==3) echo "disabled";   ?> /></td>
            </tr>
        </tbody>            
    </table>
</div>
