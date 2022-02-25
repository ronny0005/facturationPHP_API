DECLARE @query AS NVARCHAR(max);
SELECT  @query = STRING_AGG(CAST(CONCAT ('
SELECT	DatabaseName
		,LastLigneCbModification = MAX(LastLigneCbModification)
		,LastRgltCbModification = MAX(LastRgltCbModification)
		,LastEcrCbModification = MAX(LastEcrCbModification)
		,NbLigne = MAX(NbLigne)
		,NbReglt = MAX(NbReglt)
		,NbEcrit = MAX(NbEcrit)
FROM (SELECT	DatabaseName = ''',[name],'''
		,LastLigneCbModification = MAX(cbModification)
		,LastRgltCbModification = NULL
		,LastEcrCbModification = NULL
		,NbLigne = COUNT(1)
		,NbReglt = NULL
		,NbEcrit = NULL
FROM	',[name],'.dbo.F_DOCLIGNE
WHERE	CAST(cbModification AS DATE)= CAST((SELECT MAX(cbModification) FROM ',[name],'.dbo.F_DOCLIGNE) AS DATE)
UNION
SELECT	DatabaseName = ''',[name],'''
		,LastLigneCbModification = NULL
		,LastRgltCbModification = MAX(cbModification)
		,LastEcrCbModification = NULL
		,NbLigne = NULL
		,NbReglt = COUNT(1)
		,NbEcrit = NULL
FROM	',[name],'.dbo.F_CREGLEMENT
WHERE	CAST(cbModification AS DATE)= CAST((SELECT MAX(cbModification) FROM ',[name],'.dbo.F_CREGLEMENT) AS DATE)
UNION 
SELECT	DatabaseName = ''',[name],'''
		,LastLigneCbModification = NULL
		,LastRgltCbModification = NULL 
		,LastEcrCbModification = MAX(cbModification)
		,NbLigne = NULL
		,NbReglt = NULL
		,NbEcrit = COUNT(1)
FROM	',[name],'.dbo.F_ECRITUREC
WHERE	CAST(cbModification AS DATE)= CAST((SELECT MAX(cbModification) FROM ',[name],'.dbo.F_ECRITUREC) AS DATE)
) A
GROUP BY DatabaseName') AS NVARCHAR(max)),' UNION ALL ')
FROM sys.databases
WHERE name NOT IN ('BIJOU'
    ,'C_MODEL'
    ,'msdb'
    ,'model'
    ,'tempdb'
    ,'master'
    ,'ReportServer'
    ,'ReportServerTempDB'
    ,'SSISDB')
  AND state = 0;
EXEC (@query);