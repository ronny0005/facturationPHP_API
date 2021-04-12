<table style="font-size: 14px;border: 1px black solid;width: 100%;">
    <tr>
        <td style="width:150px"><?php echo $nomSociete; ?></td>
<td style="width:330px;text-align:center;text-transform:uppercase"><b><?php echo $nomEtat; ?> </b> <br/>
    <span style="text-transform:uppercase"><?php if(isset($val_nom)) echo $val_nom; ?></span></td>
<td style="width:250px">Période du date de début <?php if($datedeb!=0) echo " ".$objet->getDateDDMMYYYY($datedeb); ?><br/>
    Au date fin<?php if($datefin!=0) echo " ".$objet->getDateDDMMYYYY($datefin); ?>
    <?php
    if($articledebut!=0){
        ?>
        <br/>Article de <?php echo $articledebut; ?>
        <?php
    }
    if($articledebut!=0 && $articlefin!=0){
        ?>
        à <?php echo $articlefin; ?>
        <?php
    }
    ?></td>
</tr>
</table>
<table>
    <tr>
        <td style="width:200px">IT-Solution</td>
        <td style="width:400px">Date de tirage <?php echo date('d/m/Y'); ?> à <?php echo date('d/m/Y'); ?></td>
    </tr>
</table>