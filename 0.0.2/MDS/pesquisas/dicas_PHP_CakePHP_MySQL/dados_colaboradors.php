<?php

##DADOS DE FUNCIONARIOS

//POR PERSON_ID
_employeePersons($person_id)


//POR EMPLOYEE_ID
_employeeCompleteData($employee_id)

//POR EMPLOYEE_ID E DATA
_employeeCompleteDataDate($employee_id, $date)


//MENOS SQLS
$this->BaseDateEmployee->startBase($employee_id, $dateSelect = false); //return boolean
$this->BaseDateEmployee->getEmployee();