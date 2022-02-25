CREATE schema [dwh]
    CREATE VIEW [dwh].[VwTiers]
    AS
    SELECT [Code Tiers] = CT_Num
         ,[Nom Tiers] = CT_Intitule
         ,cbMarqComptetT = cbMarq
         ,[Type Tiers] = CASE WHEN CT_Type = 0 THEN 'Client'
                              WHEN CT_Type = 1 THEN 'Fournisseur'
        END
    FROM F_COMPTET
;
CREATE VIEW [dwh].[VwDepot]
AS
SELECT DE_No
     ,[Nom dépot] = DE_Intitule
     ,[Ville] = DE_Ville
     ,[Code] = DE_Code
     ,[Téléphone] = DE_Telephone
     ,[Region] = DE_Region
FROM F_DEPOT
;
CREATE VIEW [dwh].[VwDate] AS
WITH _Dates_ AS (
    SELECT  DateValue = DATEADD(DAY, nbr - 1, (SELECT MIN(DateId) FROM dwh.VwCaHtTtc))
    FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY c.object_id ) AS Nbr
              FROM      sys.columns c
            ) nbrs
    WHERE   nbr - 1 <= DATEDIFF(DAY, (SELECT MIN(DateId) FROM dwh.VwCaHtTtc), (SELECT MAX(DateId) FROM dwh.VwCaHtTtc))
)
SELECT DateId = CONVERT(NCHAR(8),DateValue,112)
     ,[Date] = CAST(DateValue AS date)
     ,[Mois] = MONTH(DateValue)
     ,[Année] = YEAR(DateValue)
     ,[Jour] = DAY(DateValue)
     ,[Nom Mois] = CASE WHEN MONTH(DateValue) = 1 THEN 'Janvier'
                        WHEN MONTH(DateValue) = 2 THEN 'Février'
                        WHEN MONTH(DateValue) = 3 THEN 'Mars'
                        WHEN MONTH(DateValue) = 4 THEN 'Avril'
                        WHEN MONTH(DateValue) = 5 THEN 'Mai'
                        WHEN MONTH(DateValue) = 6 THEN 'Juin'
                        WHEN MONTH(DateValue) = 7 THEN 'Juillet'
                        WHEN MONTH(DateValue) = 8 THEN 'Août'
                        WHEN MONTH(DateValue) = 9 THEN 'Septembre'
                        WHEN MONTH(DateValue) = 10 THEN 'Octobre'
                        WHEN MONTH(DateValue) = 11 THEN 'Novembre'
                        WHEN MONTH(DateValue) = 12 THEN 'Décembre'
    END
FROM _Dates_
;
CREATE VIEW [dwh].[VwCollaborateur]
AS
SELECT CO_No
     ,[Nom] = CO_Nom
     ,[Prénom] = CO_Prenom
     ,[Fonction] = CO_Fonction
     ,[Est vendeur ?] = CO_Vendeur
     ,[Est caissier ?] = CO_Caissier
     ,[Est acheteur ?] = CO_Acheteur
FROM F_COLLABORATEUR
;
CREATE VIEW [dwh].[VwCaHtTtc]
AS
WITH _StatArticle_ AS (
    SELECT  d.DE_No
         ,totcum.CO_No
         ,DateId = CONVERT(NCHAR(8),totcum.DO_Date,112)
         ,cbMarqComptet = cpt.cbMarq
         ,cbMarqArticle = f.cbMarq
         ,TotCAHTNet
         ,TotCATTCNet
         ,PRECOMPTE = TotCATTCNet-TotCAHTNet
         ,TotQteVendues
         ,TotPrxRevientU
         ,TotPrxRevientCA
         ,PourcMargeHT = CASE WHEN TotCAHTNet=0 THEN 0 ELSE ROUND(TotPrxRevientU/TotCAHTNet*100,2) END
         ,PourcMargeTT = CASE WHEN TotCATTCNet=0 THEN 0 ELSE ROUND(TotPrxRevientCA/TotCATTCNet*100,2) END

    FROM
        (SELECT cbAR_Ref,
             TotCAHTNet = SUM(CAHTNet)
              ,TotCATTCNet = SUM(CATTCNet)
              ,TotQteVendues = SUM(QteVendues)
              ,TotPrxRevientU = SUM(CAHTNet) - SUM(PrxRevientU)
              ,TotPrxRevientCA = SUM(CATTCNet) - SUM(PrxRevientU)
              ,PRECOMPTE = SUM(CATTCNet*DL_Taxe1/100)
              ,DE_No
              ,DO_Tiers
              ,CO_No
              ,DO_Date
         FROM (SELECT fDoc.cbAR_Ref,DL_Taxe1,fdocE.DE_No,fDocE.DO_Tiers,fDocE.CO_No,fDocE.DO_Date
                    ,CAHTNet = ( CASE WHEN (fDoc.DO_Type>=4 AND fDoc.DO_Type<=5)
                                          THEN -DL_MontantHT
                                      ELSE DL_MontantHT
                 END)
                    ,CATTCNet = ( CASE WHEN (fDoc.DO_Type>=4 AND fDoc.DO_Type<=5)
                                           THEN -DL_MontantTTC
                                       ELSE DL_MontantTTC
                 END)
                    ,PrxRevientU = ROUND((CASE WHEN fDoc.cbAR_Ref =convert(varbinary(255),AR_RefCompose) THEN
                                                   (select SUM(toto)
                                                    from (SELECT
                                                              CASE WHEN fDoc2.DL_TRemPied = 0 AND fDoc2.DL_TRemExep = 0 THEN
                                                                       CASE WHEN (fDoc2.DL_FactPoids = 0 OR fArt2.AR_SuiviStock > 0) THEN
                                                                                CASE WHEN fDoc2.DO_Type <= 2 THEN
                                                                                             fDoc2.DL_Qte * fDoc2.DL_CMUP
                                                                                     ELSE
                                                                                         CASE WHEN (
                                                                                                 fDoc2.DO_Type = 4
                                                                                             )
                                                                                                  THEN
                                                                                                      fDoc2.DL_PrixRU * (-fDoc2.DL_Qte)
                                                                                              ELSE
                                                                                                      fDoc2.DL_PrixRU * fDoc2.DL_Qte
                                                                                             END
                                                                                    END
                                                                            ELSE CASE WHEN (fDoc2.DO_Type = 4
                                                                                ) THEN
                                                                                                  fDoc2.DL_PrixRU * (-fDoc2.DL_PoidsNet) / 1000
                                                                                      ELSE
                                                                                                  fDoc2.DL_PrixRU * fDoc2.DL_PoidsNet / 1000
                                                                                END
                                                                           END
                                                                   ELSE 0
                                                                  END
                                                                  toto
                                                          FROM F_DOCLIGNE fDoc2 INNER JOIN F_ARTICLE fArt2 ON (fDoc2.cbAR_Ref = fArt2.cbAR_Ref)

                                                          WHERE fDoc.cbAR_Ref =convert(varbinary(255),fDoc2.AR_RefCompose)
                                                            AND fDoc2.DL_Valorise<>fDoc.DL_Valorise
                                                            AND fDoc2.cbDO_Piece=fDoc.cbDO_Piece
                                                            AND fDoc2.DO_Type=fDoc.DO_Type
                                                            AND fDoc2.DL_Ligne>fDoc.DL_Ligne
                                                            AND (NOT EXISTS (SELECT TOP 1 DL_Ligne FROM F_DOCLIGNE fDoc3
                                                                             WHERE fDoc.AR_Ref = fDoc3.AR_Ref
                                                                               AND fDoc3.AR_Ref = fDoc3.AR_RefCompose
                                                                               AND fDoc3.cbDO_Piece=fDoc.cbDO_Piece
                                                                               AND fDoc3.DO_Type=fDoc.DO_Type
                                                                               AND fDoc3.DL_Ligne>fDoc.DL_Ligne
                                                              )
                                                              OR fDoc2.DL_Ligne < (SELECT TOP 1 DL_Ligne FROM F_DOCLIGNE fDoc3
                                                                                   WHERE fDoc.AR_Ref = fDoc3.AR_Ref
                                                                                     AND fDoc3.AR_Ref = fDoc3.AR_RefCompose
                                                                                     AND fDoc3.cbDO_Piece=fDoc.cbDO_Piece
                                                                                     AND fDoc3.DO_Type=fDoc.DO_Type
                                                                                     AND fDoc3.DL_Ligne>fDoc.DL_Ligne
                                                              )
                                                              )
                                                         )fcompo
                                                   )ELSE
                                                   CASE WHEN fDoc.DL_TRemPied = 0 AND fDoc.DL_TRemExep = 0 THEN
                                                            CASE WHEN (fDoc.DL_FactPoids = 0 OR fArt.AR_SuiviStock > 0) THEN
                                                                     CASE WHEN fDoc.DO_Type <= 2 THEN
                                                                                  fDoc.DL_Qte * fDoc.DL_CMUP
                                                                          ELSE
                                                                              CASE WHEN (
                                                                                      fDoc.DO_Type = 4
                                                                                  )
                                                                                       THEN
                                                                                           fDoc.DL_PrixRU * (-fDoc.DL_Qte)
                                                                                   ELSE
                                                                                           fDoc.DL_PrixRU * fDoc.DL_Qte
                                                                                  END
                                                                         END
                                                                 ELSE CASE WHEN (fDoc.DO_Type = 4
                                                                     ) THEN
                                                                                       fDoc.DL_PrixRU * (-fDoc.DL_PoidsNet) / 1000
                                                                           ELSE
                                                                                       fDoc.DL_PrixRU * fDoc.DL_PoidsNet / 1000
                                                                     END
                                                                END
                                                        ELSE 0
                                                       END
                 END),0)
                    ,QteVendues = (CASE WHEN (fDoc.DO_Type<5 OR fDoc.DO_Type>5)AND DL_TRemPied=0 AND DL_TRemExep =0
                 AND (DL_TypePL < 2 OR DL_TypePL >3)  AND AR_FactForfait=0 THEN
                                            CASE WHEN fDoc.DO_Domaine = 4 THEN
                                                     0
                                                 ELSE CASE WHEN (fDoc.DO_Type=4) THEN
                                                               -DL_Qte
                                                           ELSE
                                                               DL_Qte
                                                     END
                                                END
                                        ELSE 0
                 END)
               FROM F_ARTICLE fArt
                        INNER JOIN F_DOCLIGNE fDoc ON (fArt.cbAR_Ref = fDoc.cbAR_Ref)
                        INNER JOIN F_DOCENTETE fDocE ON (fDocE.DO_Domaine = fDoc.DO_Domaine
                   AND fDocE.cbDO_Piece = fDoc.cbDO_Piece
                   AND fDocE.DO_Type = fDoc.DO_Type )
               WHERE
                   (
                               fDoc.DO_Type IN (6,7,30,3)
                           AND fDoc.DL_Valorise=1
                           AND fDoc.DL_TRemExep <2
                           AND fDoc.DL_NonLivre=0
                           AND fArt.AR_HorsStat = 0
                           AND fArt.AR_SuiviStock>0
                       )) fr
         GROUP BY cbAR_Ref,DE_No,DO_Tiers,CO_No,DO_Date

        ) totcum
            INNER JOIN F_ARTICLE f ON (totcum.cbAR_Ref = f.cbAR_Ref)
            INNER JOIN F_COMPTET cpt ON (cpt.CT_Num = totcum.DO_Tiers)
            INNER JOIN F_DEPOT d ON (totcum.DE_No = d.DE_No)
)

SELECT  Stat.DE_No
     ,Stat.CO_No
     ,Stat.cbMarqArticle
     ,Stat.cbMarqComptet
     ,Stat.DateId
     ,Stat.TotCAHTNet
     ,Stat.TotCATTCNet
     ,Stat.PRECOMPTE
     ,Stat.TotQteVendues
     ,Stat.TotPrxRevientU
     ,Stat.TotPrxRevientCA
--,CASE WHEN TotCAHTNet=0 THEN 0 ELSE ROUND(TotPrxRevientU/TotCAHTNet*100,2) END PourcMargeHT
--,CASE WHEN TotCATTCNet=0 THEN 0 ELSE ROUND(TotPrxRevientCA/TotCATTCNet*100,2) END PourcMargeTT
FROM    _StatArticle_ Stat
WHERE YEAR(Stat.DateId) >= YEAR(GETDATE())-3
;
CREATE VIEW [dwh].[VwArticle]
AS
SELECT [Code Article] = art.AR_Ref
     ,[Désignation] = art.AR_Design
     ,[Prix d'achat] = art.AR_PrixAch
     ,[Prix de vente] = art.AR_PrixVen
     ,[Gamme] = art.AR_Langue1
     ,cbMarqArticle = art.cbMarq
     ,cbMarqFamille = fam.cbMarq
FROM F_ARTICLE Art
         LEFT JOIN F_FAMILLE Fam
                   ON Art.cbFA_CodeFamille = Fam.cbFA_CodeFamille
