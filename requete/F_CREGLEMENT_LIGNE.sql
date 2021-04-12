create table [F_CREGLEMENT_LIGNE]
(
RG_No INT NOT NULL IDENTITY(1, 1) PRIMARY KEY,
CT_NumPayeur varchar(17),
RG_Date smalldatetime,
RG_Libelle varchar(35),
RG_Montant numeric(24,6))

CREATE TABLE Z_REGLEMENT_ANALYTIQUE(
  CA_Num varchar(50),
  RG_No int,
  cbModification datetime,
  cbCeateur VARCHAR (50),
  cbMarq INT NOT NULL IDENTITY(1, 1) PRIMARY KEY
)

CREATE FUNCTION fnIntegerToWords(@Number as BIGINT)
  RETURNS VARCHAR(1024)
AS

  BEGIN
    DECLARE @Below20 TABLE (ID int identity(0,1), Word varchar(32))
    DECLARE @Below100 TABLE (ID int identity(2,1), Word varchar(32))
    INSERT @Below20 (Word) VALUES
      ( 'zéro'), ('un'),( 'deux' ), ( 'trois'),
      ( 'quatre' ), ( 'cinq' ), ( 'six' ), ( 'sept' ),
      ( 'huit'), ( 'neuf'), ( 'dix'), ( 'onze' ),
      ( 'douze' ), ( 'treize' ), ( 'quatorze'),
      ( 'quinze' ), ('seize' ), ( 'dix-sept'),
      ('dix-huit' ), ( 'dix-neuf' )

    INSERT @Below100 VALUES ('vingt'), ('trente'),('quarante'), ('cinquante'),
      ('soixante'), ('soixante-dix'), ('quantre-vingt'), ('quatre vingt-dix')

    declare @belowHundred as varchar(126)

    if @Number > 99 begin
      select @belowHundred = dbo.fnIntegerToWords( @Number % 100)
    end

    DECLARE @English varchar(1024) =

    (

      SELECT Case
             WHEN @Number = 0 THEN  ''

             WHEN @Number BETWEEN 1 AND 19
               THEN (SELECT Word FROM @Below20 WHERE ID=@Number)

             WHEN @Number BETWEEN 20 AND 99
               THEN  (SELECT Word FROM @Below100 WHERE ID=@Number/10)+ '-' +
                     dbo.fnIntegerToWords( @Number % 10)

             WHEN @Number BETWEEN 100 AND 999
               THEN  CASE WHEN @Number / 100 <>1 THEN (dbo.fnIntegerToWords( @Number / 100)) ELSE ''END +' cent '+
                     Case WHEN @belowHundred <> '' THEN '' + @belowHundred else @belowHundred end

             WHEN @Number BETWEEN 1000 AND 999999
               THEN  CASE WHEN @Number / 1000 <>1 THEN (dbo.fnIntegerToWords( @Number / 1000)) ELSE ''END+' mille '+
                     dbo.fnIntegerToWords( @Number % 1000)

             WHEN @Number BETWEEN 1000000 AND 999999999
               THEN  CASE WHEN @Number / 1000000 <>1 THEN (dbo.fnIntegerToWords( @Number / 1000000)) ELSE ''END +' million '+
                     dbo.fnIntegerToWords( @Number % 1000000)

             WHEN @Number BETWEEN 1000000000 AND 999999999999
               THEN  CASE WHEN @Number / 1000000000 <>1 THEN (dbo.fnIntegerToWords( @Number / 1000000000)) ELSE ''END +' milliard '+
                     dbo.fnIntegerToWords( @Number % 1000000000)

             ELSE ' INVALID INPUT' END
    )

    SELECT @English = RTRIM(@English)

    SELECT @English = RTRIM(LEFT(@English,len(@English)-1))
    WHERE RIGHT(@English,1)='-'

    RETURN (@English)

  END