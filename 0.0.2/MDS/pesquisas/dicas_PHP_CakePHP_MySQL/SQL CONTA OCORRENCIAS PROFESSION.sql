SELECT
gp_employees.profession_id,
COUNT(gp_employees.profession_id) as vagasPreenchidas
FROM gp_employees
WHERE
gp_employees.isdeleted = 'N' 
AND
gp_employees.isactive = 'Y'
GROUP BY gp_employees.profession_id
