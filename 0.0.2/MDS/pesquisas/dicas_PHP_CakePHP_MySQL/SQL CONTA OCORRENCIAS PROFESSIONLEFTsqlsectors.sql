SELECT
gp_sectors.setor,
gp_sectors.id as sector_id,
gp_professions.cargo,
gp_employees.profession_id,
COUNT(gp_employees.profession_id) as vagasPreenchidas
FROM gp_employees
LEFT JOIN gp_professions
ON
gp_professions.id = gp_employees.profession_id
LEFT JOIN gp_sectors
ON
gp_sectors.id = gp_employees.sector_id
WHERE
gp_employees.isdeleted = 'N' 
AND
gp_employees.isactive = 'Y'
GROUP BY gp_employees.profession_id
ORDER BY gp_professions.cargo ASC

