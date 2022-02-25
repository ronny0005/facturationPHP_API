DECLARE @cbMarq INT 
DECLARE @protNo INT 
DECLARE @dlQte FLOAT
DECLARE @arRef NVARCHAR(100) 
DECLARE @cbMarqEntete INT 
DECLARE @typeFacture NVARCHAR(100)
DECLARE @catTarif INT 
DECLARE @dlPrix FLOAT
DECLARE @dlRemise NVARCHAR(100)
DECLARE @machineName NVARCHAR(100)
DECLARE @acte NVARCHAR(100)
DECLARE @entetePrev NVARCHAR(100)
DECLARE @depotLigne INT
DECLARE @vteNegative TINYINT = 0
DECLARE @clotureJournee TINYINT = 0
DECLARE @isVisu TINYINT = 0

DECLARE @date DATE = (SELECT DO_Date FROM F_DOCENTETE WHERE cbMarq = @cbMarqEntete)
       ,@caNo INT = (SELECT CA_No FROM F_DOCENTETE WHERE cbMarq = @cbMarqEntete)

SELECT  @clotureJournee = CASE WHEN count(*) <> 0 THEN 1 ELSE 0 END
FROM    F_DOCENTETE
WHERE   DO_Cloture=1
  AND     DO_Date=@date
  AND     CA_No = @caNo

    IF @clotureJournee = 0 OR @typeFacture IN ('Devis','AchatPreparationCommande')
BEGIN
	DECLARE @isSecurite TINYINT = 0
	IF @typeFacture <> 'Devis'
		SET @isVisu = 0

	IF @isVisu <> 0
BEGIN
		IF @cbMarq <> 0
			SET @arRef = (SELECT AR_Ref FROM F_DOCLIGNE WHERE cbMarq=@cbMarq)

		IF	EXISTS (SELECT	TOP 1 1
			FROM	F_DOCENTETE docE 
			INNER JOIN F_REGLECH regl 
				ON	docE.DO_Domaine = regl.DO_Domaine 
				AND docE.DO_Type = regl.DO_Type 
				AND docE.DO_Piece = regl.DO_Piece)
SELECT [message] = 'La facture est déjà réglé ! Vous ne pouvez plus la modifier !'

DECLARE @deNo INT = (SELECT DE_No FROM F_DOCENTETE WHERE cbMarq = @cbMarqEntete)
		IF @typeFacture IN ('Entree','Sortie')
			SET @deNo  = (SELECT DO_Tiers FROM F_DOCENTETE WHERE cbMarq = @cbMarqEntete)
			
		DECLARE @vteNegatif INT = (SELECT PR_StockNeg FROM P_PREFERENCES)
		DECLARE @qteGros INT = (SELECT QTE_GROS FROM F_ARTICLE WHERE AR_Ref= (SELECT AR_Ref FROM F_DOCLIGNE WHERE cbMarq = @cbMarq))
		DECLARE @prixMin FLOAT = (SELECT Prix_Min FROM F_ARTICLE WHERE AR_Ref= (SELECT AR_Ref FROM F_DOCLIGNE WHERE cbMarq = @cbMarq))
		
		IF @catTarif = 1
BEGIN
			IF @typeFacture <> 'Vente' 
				OR (@qteGros <> 0 AND (@qteGros <= @dlQte OR (@qteGros > @dlQte AND @prixMin < @dlPrix)))
				OR (@qteGros = 0)
BEGIN
					SET @typeFacture = @typeFacture
END
ELSE
BEGIN
SELECT [message] = CONCAT('La quantité saisie de ',@arRef,' (',@dlQte,') < quantité gros (',@qteGros,')')
END
END
ELSE
BEGIN
				IF @typeFacture <> 'VenteRetour'
BEGIN

END
END
END
END