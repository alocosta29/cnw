SELECT
gp_professions.cargo,
gp_employees.profession_id,
COUNT(gp_employees.profession_id) as vagasPreenchidas
FROM gp_employees
LEFT JOIN gp_professions
ON
gp_professions.id = gp_employees.profession_id
WHERE
gp_employees.isdeleted = 'N' 
AND
gp_employees.isactive = 'Y'
GROUP BY gp_employees.profession_id

