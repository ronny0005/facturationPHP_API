<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ReglEchClass Extends Objet{
    //put your code here
    public $db, $RG_No    ,$DR_No    ,$DO_Domaine    ,$DO_Type    ,$DO_Piece    ,$RC_Montant    ,$RG_TypeReg
    ,$cbProt    ,$cbMarq    ,$cbCreateur    ,$cbModification    ,$cbReplication    ,$cbFlag;
    public $table = 'F_DOCREGL';

    function __construct($id,$db=null)
    {
        parent::__construct($this->table, $id, 'cbMarq',$db);
        $this->setValue();
        if (sizeof($this->data) > 0) {
            $this->RG_No = $this->data[0]->RG_No;
            $this->DR_No = $this->data[0]->DR_No;
            $this->DO_Type = $this->data[0]->DO_Type;
            $this->DO_Piece = $this->data[0]->DO_Piece;
            $this->DO_Domaine = $this->data[0]->DO_Domaine;
            $this->RC_Montant = $this->data[0]->RC_Montant;
            $this->RG_TypeReg = $this->data[0]->RG_TypeReg;
            $this->cbProt = $this->data[0]->cbProt;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $this->cbReplication = $this->data[0]->cbReplication;
            $this->cbFlag = $this->data[0]->cbFlag;
        }
    }

    function setValue(){
        $this->RG_TypeReg = 0;
        $this->cbProt = 0;
        $this->cbReplication = 0;
        $this->cbFlag = 0;
    }


    public function addReglEch($rg_no, $dr_no, $do_domaine, $do_type, $do_piece, $rc_montant) {
        $this->RG_No=$rg_no;
        $this->DR_No=$dr_no;
        $this->DO_Domaine = $do_domaine;
        $this->DO_Type = $do_type;
        $this->DO_Piece = $do_piece;
        $this->RC_Montant = $rc_montant;
        $this->setuserName("","");
        return $this->insertReglEch();
    }

    public function insertReglEch() {
        $requete = "
                BEGIN
                    SET NOCOUNT ON;
                    DECLARE @RG_No INT = {$this->RG_No}
                            ,@DR_No INT = {$this->DR_No}
                            ,@RC_Montant FLOAT = ROUND({$this->RC_Montant},0)
                            ,@RC_MontantInsert FLOAT = {$this->RC_Montant}
                            ,@RG_TypeReg INT = {$this->RG_TypeReg}
                            ,@cbProt INT = {$this->cbProt}
                            ,@cbCreateur NVARCHAR(10) = {$this->userName}
                            ,@cbReplication INT = {$this->cbReplication}
                            ,@cbFlag INT = {$this->cbFlag}
                            ,@DO_Domaine INT = {$this->DO_Domaine}    
                            ,@DO_Type INT = {$this->DO_Type}
                            ,@DO_Piece NVARCHAR(20) = '{$this->DO_Piece}'
                            ,@count INT = 0
                            ,@rcMontant FLOAT
                            ,@dlMontantTTC FLOAT
                            ,@RG_Montant FLOAT 
				            ,@doProvenance INT;
                            
                            
                            SELECT @doProvenance = DO_Provenance
                            FROM F_DOCENTETE			 
                            WHERE DO_Type=@DO_Type 
                            AND DO_Domaine = @DO_Domaine 
                            AND DO_Piece = @DO_Piece
                            
							SELECT @RG_Montant = ROUND(ISNULL(RG_Montant,0)-ISNULL(RC_Montant,0),0)
							FROM F_CREGLEMENT cre
							LEFT JOIN F_REGLECH reg
								ON cre.RG_No = reg.RG_No
							WHERE cre.RG_No=@RG_No
							
                            SELECT @dlMontantTTC = ROUND(SUM(DL_MontantTTC) ,0)
                            FROM F_DOCLIGNE 
                            WHERE DO_Type=@DO_Type 
                            AND DO_Domaine = @DO_Domaine 
                            AND DO_Piece = @DO_Piece
                            
                            SELECT @rcMontant = ROUND(SUM(RC_Montant),0) 
                            FROM F_REGLECH 
                            WHERE DO_Type=@DO_Type 
                            AND DO_Domaine = @DO_Domaine 
                            AND DO_Piece = @DO_Piece
                            
                            SELECT  @count = ISNULL(SUM(CASE WHEN RG_No = @RG_No THEN 1 ELSE 0 END),0)
									,@rcMontant = ROUND(SUM(RC_Montant),0)
                            FROM    F_REGLECH 
                            WHERE   DO_Type=@DO_Type 
                            AND     DO_Domaine = @DO_Domaine 
                            AND     DO_Piece = @DO_Piece
                            
                IF  (@doProvenance<>1 AND @RG_Montant>0 AND @RG_Montant >=@RC_Montant AND @RC_Montant <= @dlMontantTTC)
				OR (@doProvenance = 1 AND ABS(@RG_Montant)>0 AND ABS(@RG_Montant) >=ABS(@RC_Montant) AND ABS(@RC_Montant) <= ABS(@dlMontantTTC))
                                IF @count=0
                                    INSERT INTO [dbo].[F_REGLECH] 
                                        ([RG_No],[DR_No],[DO_Domaine],[DO_Type],[DO_Piece],[RC_Montant],[RG_TypeReg],[cbProt] 
                                        ,[cbCreateur],[cbModification],[cbReplication],[cbFlag]) 
                                        VALUES 
                                           (/*RG_No*/@RG_No,/*DR_No*/@DR_No,/*DO_Domaine*/@DO_Domaine,/*DO_Type*/@DO_Type
                                           ,/*DO_Piece*/@DO_Piece,/*RC_Montant*/@RC_MontantInsert,/*RG_TypeReg*/@RG_TypeReg,/*cbProt*/@cbProt 
                                          ,/*cbCreateur*/@cbCreateur,/*cbModification*/GETDATE(),/*cbReplication*/@cbReplication,/*cbFlag*/@cbFlag);
                                ELSE
                                    UPDATE	F_REGLECH 
                                        SET RC_Montant = @RC_MontantInsert
                                    WHERE	DO_Type=@DO_Type 
                                    AND		DO_Domaine = @DO_Domaine 
                                    AND		DO_Piece = @DO_Piece
                                    
                    select @@IDENTITY as cbMarq;
                END;
                ";
        $result = $this->db->query($requete);
        return $result->fetchAll(PDO::FETCH_OBJ)[0]->cbMarq;
    }
}