GO
IF OBJECT_ID('[dbo].[Z_LiaisonEnvoiSMSUser]', 'U') IS NULL
CREATE TABLE [dbo].[Z_LiaisonEnvoiSMSUser](
                                              [TE_No] [int] NULL,
                                              [Prot_No] [int] NULL,
                                              [cbModification] [datetime] NULL,
                                              [cbUser] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TmpLib]    Script Date: 28/08/2018 20:12:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[TmpLib]', 'U') IS NULL
CREATE TABLE [dbo].[TmpLib](
    [lib] [varchar](500) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_CODECLIENT]    Script Date: 28/08/2018 20:12:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_CODECLIENT]', 'U') IS NULL
CREATE TABLE [dbo].[Z_CODECLIENT](
                                     [CodeClient] [varchar](13) NOT NULL,
                                     [Libelle_ville] [varchar](50) NULL,
                                     [CT_Type] [int] NULL,
                                     CONSTRAINT [PK_CODECLIENT] PRIMARY KEY CLUSTERED
                                         (
                                          [CodeClient] ASC
                                             )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 90) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_DEPOTCAISSE]    Script Date: 28/08/2018 20:12:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_DEPOTCAISSE]', 'U') IS NULL
CREATE TABLE [dbo].[Z_DEPOTCAISSE](
                                      [DE_No] [int] NOT NULL,
                                      [CA_No] [int] NOT NULL,
                                      CONSTRAINT [PK_DEPOTCAISSE] PRIMARY KEY CLUSTERED
                                          (
                                           [DE_No] ASC,
                                           [CA_No] ASC
                                              )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 90) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_DEPOTCLIENT]    Script Date: 28/08/2018 20:12:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_DEPOTCLIENT]', 'U') IS NULL
CREATE TABLE [dbo].[Z_DEPOTCLIENT](
                                      [DE_No] [int] NOT NULL,
                                      [CodeClient] [varchar](13) NOT NULL,
                                      CONSTRAINT [PK_DEPOTCLIENT] PRIMARY KEY CLUSTERED
                                          (
                                           [DE_No] ASC,
                                           [CodeClient] ASC
                                              )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 90) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_DEPOTSOUCHE]    Script Date: 28/08/2018 20:12:47 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_DEPOTSOUCHE]', 'U') IS NULL
CREATE TABLE [dbo].[Z_DEPOTSOUCHE](
                                      [DE_No] [int] NOT NULL,
                                      [CA_SoucheVente] [int] NULL,
                                      [CA_SoucheAchat] [int] NULL,
                                      [CA_SoucheStock] [int] NULL,
                                      [CA_Num] [varchar](13) NULL,
                                      CONSTRAINT [PK_DEPOTSOUCHE] PRIMARY KEY CLUSTERED
                                          (
                                           [DE_No] ASC
                                              )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 90) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_DEPOTUSER]    Script Date: 28/08/2018 20:12:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_DEPOTUSER]', 'U') IS NULL
CREATE TABLE [dbo].[Z_DEPOTUSER](
                                    [Prot_No] [int] NOT NULL,
                                    [DE_No] [int] NOT NULL,
                                    [IsPrincipal] [int] NULL,
                                    CONSTRAINT [PK_DEPOTUSER] PRIMARY KEY CLUSTERED
                                        (
                                         [Prot_No] ASC,
                                         [DE_No] ASC
                                            )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 90) ON [PRIMARY]
) ON [PRIMARY]
GO
IF OBJECT_ID('[dbo].[Z_DEPOTEMPLUSER]', 'U') IS NULL
CREATE TABLE [dbo].[Z_DEPOTEMPLUSER](
                                        [Prot_No] [int] NOT NULL,
                                        [DP_No] [int] NOT NULL,
                                        CONSTRAINT [PK_DEPOTEMPLUSER] PRIMARY KEY CLUSTERED
                                            (
                                             [Prot_No] ASC,
                                             [DP_No] ASC
                                                )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 90) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_ECRITURECPIECE]    Script Date: 28/08/2018 20:12:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_ECRITURECPIECE]', 'U') IS NULL
CREATE TABLE [dbo].[Z_ECRITURECPIECE](
                                         [EC_No] [int] NOT NULL,
                                         [Lien_Fichier] [varchar](max) NULL,
                                         CONSTRAINT [PK_ECRITURECPIECE] PRIMARY KEY CLUSTERED
                                             (
                                              [EC_No] ASC
                                                 )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 90) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_FACT_REGL_SUPPR]    Script Date: 28/08/2018 20:12:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_FACT_REGL_SUPPR]', 'U') IS NULL
CREATE TABLE [dbo].[Z_FACT_REGL_SUPPR](
                                          [DO_Domaine] [int] NOT NULL,
                                          [DO_Type] [int] NOT NULL,
                                          [DO_Piece] [varchar](25) NOT NULL,
                                          [CbMarq_Entete] [int] NOT NULL,
                                          [RG_No] [int] NOT NULL,
                                          [CbMarq_RG] [int] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_LiaisonEnvoiMailUser]    Script Date: 28/08/2018 20:12:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_LiaisonEnvoiMailUser]', 'U') IS NULL
CREATE TABLE [dbo].[Z_LiaisonEnvoiMailUser](
                                               [TE_No] [int] NULL,
                                               [Prot_No] [int] NULL,
                                               [cbModification] [datetime] NULL,
                                               [cbUser] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_LIGNE_COMPTEA]    Script Date: 28/08/2018 20:12:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_LIGNE_COMPTEA]', 'U') IS NULL
CREATE TABLE [dbo].[Z_LIGNE_COMPTEA](
                                        [CbMarq_Ligne] [int] NULL,
                                        [N_Analytique] [smallint] NOT NULL,
                                        [CA_Num] [varchar](13) NOT NULL,
                                        [EA_Ligne] [int] NULL,
                                        [EA_Montant] [float] NULL,
                                        [EA_Quantite] [float] NULL,
                                        [cbMarq] [int] IDENTITY(1,1) NOT NULL,
                                        [cbModification] [smalldatetime] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_REGLEMENTPIECE]    Script Date: 28/08/2018 20:12:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_REGLEMENTPIECE]', 'U') IS NULL
CREATE TABLE [dbo].[Z_REGLEMENTPIECE](
                                         [RG_No] [int] NOT NULL,
                                         [Lien_Fichier] [varchar](max) NULL,
                                         CONSTRAINT [PK_REGLEMENTPIECE] PRIMARY KEY CLUSTERED
                                             (
                                              [RG_No] ASC
                                                 )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 90) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_RGLT_BONDECAISSE]    Script Date: 28/08/2018 20:12:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_RGLT_BONDECAISSE]', 'U') IS NULL
CREATE TABLE [dbo].[Z_RGLT_BONDECAISSE](
                                           [RG_No] [int] NOT NULL,
                                           [RG_No_RGLT] [int] NOT NULL,
                                           CONSTRAINT [PK_RGLT_BONDECAISSE] PRIMARY KEY CLUSTERED
                                               (
                                                [RG_No] ASC,
                                                [RG_No_RGLT] ASC
                                                   )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 90) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_SMS]    Script Date: 28/08/2018 20:12:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_SMS]', 'U') IS NULL
CREATE TABLE [dbo].[Z_SMS](
                              [ID] [int] NOT NULL,
                              [CA_No] [int] NULL,
                              [MSG] [varchar](250) NULL,
                              [NUMBER_R] [varchar](50) NULL,
                              [DATE_S] [smalldatetime] NULL,
                              [ETAT] [varchar](2) NULL,
                              CONSTRAINT [PK_Z_SMS] PRIMARY KEY CLUSTERED
                                  (
                                   [ID] ASC
                                      )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 90) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Z_TypeEnvoiMail]    Script Date: 28/08/2018 20:12:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF OBJECT_ID('[dbo].[Z_TypeEnvoiMail]', 'U') IS NULL
CREATE TABLE [dbo].[Z_TypeEnvoiMail](
                                        [TE_No] [int] IDENTITY(1,1) NOT NULL,
                                        [TE_Intitule] [varchar](150) NULL,
                                        PRIMARY KEY CLUSTERED
                                            (
                                             [TE_No] ASC
                                                )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

insert into Z_TypeEnvoiMail values('Suppression règlement');
insert into Z_TypeEnvoiMail values('Versement distant');
insert into Z_TypeEnvoiMail values('Mouvement de sortie');
insert into Z_TypeEnvoiMail values('Versement bancaire');
insert into Z_TypeEnvoiMail values('Modification de la facture');
insert into Z_TypeEnvoiMail values('Prix modifié');
insert into Z_TypeEnvoiMail values('Stock épuisé');
insert into Z_TypeEnvoiMail values('Stock cumulé');

IF COL_LENGTH('Z_LogInfo','USERGESCOM') IS NULL
ALTER TABLE F_DOCLIGNE ADD [USERGESCOM] [varchar](40) NULL;
IF COL_LENGTH('Z_LogInfo','NOMCLIENT') IS NULL
ALTER TABLE F_DOCLIGNE ADD 	[NOMCLIENT] [varchar](60) NULL;
IF COL_LENGTH('Z_LogInfo','DATEMODIF') IS NULL
ALTER TABLE F_DOCLIGNE ADD [DATEMODIF] [smalldatetime] NULL;
IF COL_LENGTH('Z_LogInfo','ORDONATEUR_REMISE') IS NULL
ALTER TABLE F_DOCLIGNE ADD [ORDONATEUR_REMISE] [varchar](69) NULL;
IF COL_LENGTH('Z_LogInfo','MACHINEPC') IS NULL
ALTER TABLE F_DOCLIGNE ADD 	[MACHINEPC] [varchar](69) NULL;
IF COL_LENGTH('Z_LogInfo','GROUPEUSER') IS NULL
ALTER TABLE F_DOCLIGNE ADD	[GROUPEUSER] [varchar](10) NULL;

IF COL_LENGTH('Z_LogInfo','longitude') IS NULL
ALTER TABLE F_DOCENTETE ADD [longitude] [float] NULL;
IF COL_LENGTH('Z_LogInfo','latitude') IS NULL
ALTER TABLE F_DOCENTETE ADD 	[latitude] [float] NULL;
IF COL_LENGTH('Z_LogInfo','VEHICULE') IS NULL
ALTER TABLE F_DOCENTETE ADD 	[VEHICULE] [varchar](10) NULL;
IF COL_LENGTH('Z_LogInfo','CHAUFFEUR') IS NULL
ALTER TABLE F_DOCENTETE ADD [CHAUFFEUR] [varchar](10) NULL;
GO

IF OBJECT_ID('[dbo].[Z_LIGNE_CONFIRMATION]', 'U') IS NULL
CREATE TABLE Z_LIGNE_CONFIRMATION (
                                      cbMarq INT IDENTITY(1, 1) PRIMARY KEY,
                                      AR_Ref VARCHAR(19),
                                      Prix FLOAT,
                                      DL_Qte FLOAT,
                                      cbMarqEntete INT,
                                      cbMarqLigneFirst INT
)

IF OBJECT_ID('[dbo].[Z_DEPOT_DETAIL]', 'U') IS NULL
CREATE TABLE Z_DEPOT_DETAIL (	DE_No INT NOT NULL,
                                 CA_CatTarif INT,
                                 cbMarq INT NOT NULL IDENTITY(1, 1) PRIMARY KEY,
                                 CONSTRAINT FK_DEPOT_DETAIL_DENo FOREIGN KEY (DE_No)
                                     REFERENCES F_DEPOT (DE_No) )

IF OBJECT_ID('[dbo].[Z_CALENDAR_USER]', 'U') IS NULL
CREATE TABLE Z_CALENDAR_USER (
                                 PROT_No INT,
                                 ID_JourDebut INT,
                                 ID_JourFin INT,
                                 ID_HeureDebut INT,
                                 ID_MinDebut INT,
                                 ID_HeureFin INT,
                                 ID_MinFin INT)



IF OBJECT_ID('[dbo].[Z_LogInfo]', 'U') IS NULL

CREATE TABLE [dbo].[Z_LogInfo](
                                  [Action] [varchar](250) NULL
    ,[Type] [varchar](250) NULL
    ,[DoType] [int] NULL
    ,[DoEntete] [varchar](250) NULL
    ,[DE_No] [int] NULL
    ,[DoDomaine] [int] NULL
    ,[AR_Ref] [varchar](250) NULL
    ,[Qte] [float] NULL
    ,[Prix] [float] NULL
    ,[Remise] [varchar](250) NULL
    ,[Montant] [float] NULL
    ,[Date] [varchar](250) NULL
    ,[UserName] [varchar](250) NULL
    ,[cbMarq] int
    ,[tables] [varchar](30) NULL
    ,[cbCreateur] varchar(30) NULL
)

IF OBJECT_ID('[dbo].[Z_RGLT_COMPTEA]', 'U') IS NULL
CREATE TABLE [dbo].[Z_RGLT_COMPTEA](
                                       [RG_No] [int] NULL,
                                       [CA_Num] [varchar](20) NULL,
                                       cbMarq INT NOT NULL IDENTITY(1, 1) PRIMARY KEY
)

IF OBJECT_ID('[dbo].[Z_RGLT_VRSTBANCAIRE]', 'U') IS NULL
CREATE TABLE [dbo].[Z_RGLT_VRSTBANCAIRE](
                                            [RG_No] [int] NULL,
                                            [RG_NoCache] [int] NULL,
                                            cbMarq INT NOT NULL IDENTITY(1, 1) PRIMARY KEY
)

IF OBJECT_ID('[dbo].[Z_ProtUser]', 'U') IS NULL
CREATE TABLE dbo.Z_ProtUser (
                                PROT_No INT,
                                ProtectAdmin TINYINT
)

IF OBJECT_ID('[dbo].[Z_DocligneLivree]', 'U') IS NULL
CREATE TABLE [dbo].[Z_DocligneLivree](
                                         [cbMarqLigne] [int] NOT NULL,
                                         [AR_Ref] [varchar](70) NOT NULL,
                                         [DL_QteBL] [numeric](24, 6) NOT NULL,
                                         [DL_QteBLRestant] [numeric](24, 6) NOT NULL,
                                         [USER_GESCOM] [varchar](70) NOT NULL,
                                         [cbModification] [smalldatetime] NOT NULL,
                                         [cbMarq] [int] IDENTITY(1,1) NOT NULL
)

INSERT INTO dbo.LIB_CMD VALUES(34095,'Clôture de caisse',1,1113,0)


IF COL_LENGTH('Z_LogInfo','DateDocument') IS NULL
ALTER TABLE Z_LogInfo ADD DateDocument DATE



IF COL_LENGTH('F_DOCLIGNE','ORDONATEUR_REMISE') IS NULL
ALTER TABLE F_DOCLIGNE ADD ORDONATEUR_REMISE VARCHAR(69)

IF COL_LENGTH('F_DOCLIGNE','DL_SUPER_PRIX') IS NULL
ALTER TABLE F_DOCLIGNE ADD DL_SUPER_PRIX NUMERIC(24,6) NULL

IF COL_LENGTH('F_DOCLIGNE','DL_QTE_SUPER_PRIX') IS NULL
ALTER TABLE F_DOCLIGNE ADD DL_QTE_SUPER_PRIX NUMERIC(24,6) NULL

IF COL_LENGTH('F_DOCLIGNE','DL_COMM') IS NULL
ALTER TABLE F_DOCLIGNE ADD DL_COMM VARCHAR(69)

IF COL_LENGTH('F_DOCLIGNE','GROUPEUSER') IS NULL
ALTER TABLE F_DOCLIGNE ADD GROUPEUSER VARCHAR(10)


IF COL_LENGTH('F_DOCLIGNE','Qte_LivreeBL') IS NULL
ALTER TABLE F_DOCLIGNE ADD Qte_LivreeBL NUMERIC(24,6) NULL
IF COL_LENGTH('F_DOCLIGNE','Qte_RestantBL') IS NULL
ALTER TABLE F_DOCLIGNE ADD Qte_RestantBL NUMERIC(24,6) NULL

IF NOT EXISTS(SELECT R_CODE
              FROM P_REGLEMENT WHERE R_CODE = '06' AND 	R_Intitule ='ORANGE_MONEY')
    UPDATE	P_REGLEMENT
    SET	R_Intitule ='ORANGE_MONEY'
      ,R_CODE = '06'
    WHERE	cbIndice=5

IF NOT EXISTS(SELECT R_CODE
              FROM P_REGLEMENT WHERE R_CODE = '07' AND 	R_Intitule ='MTN_MONEY')
    UPDATE	P_REGLEMENT
    SET	R_Intitule ='MTN_MONEY'
      ,R_CODE = '07'
    WHERE	cbIndice=6