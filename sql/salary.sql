## Вывести человека, который получает самую большую зарплату (ставку)

SELECT concat_ws(", ", e.`lastname`, e.`firstname`) `name`, pos.`name` `position`, pos.`rate_per_day`
FROM employee e 
JOIN position pos ON pos.position_id = e.position_id
where pos.`rate_per_day` = (
    SELECT MAX(pos.`rate_per_day`) FROM position pos
);

## Вывести человека которы получил самую большую зарплату за последние 3 месяца

SELECT e.`lastname`, pos.`name` `position`, sal.date_given, sal.`sum_to_pay`
FROM employee e
JOIN position pos ON pos.position_id = e.position_id
JOIN salary sal ON sal.employee_id = e.employee_id
WHERE sal.date_given  
BETWEEN '2016.05.01' AND '2016.07.10'
  AND sal.`sum_to_pay` = (SELECT max(sal.`sum_to_pay`) FROM salary sal);

## Ищем второго человека который получает самую большую зарплату

#####variant 1

SELECT e.`lastname`, pos.`name` `position`, sal.date_given, sal.`sum_to_pay`
FROM employee e
JOIN position pos on pos.position_id = e.position_id
JOIN salary sal on sal.employee_id = e.employee_id
WHERE sal.date_given  
BETWEEN '2016.05.01' AND '2016.07.10'
ORDER BY sal.`sum_to_pay` DESC
LIMIT 1 , 1 ;

#####variant 2

SELECT e.`lastname`, pos.`name` `position`, sal.date_given , sal.`sum_to_pay`
FROM employee e
JOIN position pos on pos.position_id = e.position_id
JOIN salary sal on sal.employee_id = e.employee_id
WHERE sal.date_given 
BETWEEN '2016.05.01' AND '2016.07.10' AND sal.sum_to_pay <
   (SELECT sal.`sum_to_pay`
   FROM employee e
   JOIN salary sal on sal.employee_id = e.employee_id
   BETWEEN '2016.05.01' AND '2016.07.10'
     AND sal.`sum_to_pay` = (SELECT max(sal.`sum_to_pay`) FROM salary sal))
ORDER BY sal.`sum_to_pay` DESC 
LIMIT 1;

##  Сохранить ставку каждого сотрудника и посчитать сколько фирме нужно денег для выплаты зарплат

SELECT
	(SELECT ((
		SELECT COUNT(e.employee_id)
		FROM employee e
		WHERE e.is_working_now = 1
		AND e.position_id = 1
	) * (
		SELECT pos.rate_per_day
		FROM position pos
		WHERE pos.position_id = 1) * 21)
+
	(SELECT ((
		SELECT COUNT(e.employee_id)
		FROM employee e
		WHERE e.is_working_now = 1
		AND e.position_id = 2
	) * (
		SELECT pos.rate_per_day
		FROM position pos
		WHERE pos.position_id = 2) * 21)
+
	(SELECT ((
		SELECT COUNT(e.employee_id)
		FROM employee e
		WHERE e.is_working_now = 1
		AND e.position_id = 3
	) * (
		SELECT pos.rate_per_day
		FROM position pos
		WHERE pos.position_id = 3) * 21 )))) total_monthly_sum;