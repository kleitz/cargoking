select 
    `booking_status`.`hawb_id` AS `hawb_id`,
    max(concat(`booking_status`.`status_date`,' ',`booking_status`.`status_time`)) AS `status_datetime` 
  from 
    `booking_status` 
  group by 
    `booking_status`.`hawb_id`