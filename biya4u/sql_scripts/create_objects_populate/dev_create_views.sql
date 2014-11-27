use ehi8so1c_cargoking;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_loginusers` AS 
  select 
    `u`.`id` AS `id`,
    `u`.`user_type_id` AS `user_type_id`,
    `ut`.`type_code` AS `type_code`,
    `ut`.`type_name` AS `type_name`,
    `u`.`username` AS `username`,
    `u`.`firstname` AS `firstname`,
    `u`.`lastname` AS `lastname`,
    `u`.`middlename` AS `middlename`,
    concat(ifnull(`u`.`firstname`,''),' ',ifnull(`u`.`lastname`,'')) AS `full_name`,
    `u`.`password` AS `password`,
    ifnull(`u`.`address`,'N/A') AS `address`,
    `u`.`email` AS `email`,
    ifnull(`u`.`phone`,'N/A') AS `contact_number`,
    `u`.`station_id` AS `station_id`,
    `u`.`satellite_office_id` AS `satellite_office_id`,
    `so`.`station_hawb_prefix` AS `hawb_booking_prefix` 
  from 
    ((`users` `u` join `user_types` `ut` on((`ut`.`id` = `u`.`user_type_id`))) left join `delivery_area` `so` on((`so`.`id` = `u`.`satellite_office_id`)));

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_details` AS 
  select 
    `b`.`id` AS `id`,
    `u`.`hawb_booking_prefix` AS `hawb_booking_prefix`,
    concat(ifnull(`u`.`hawb_booking_prefix`,''),convert(if((`u`.`hawb_booking_prefix` is not null),'-','') using latin1),`b`.`id`) AS `booking_code`,
    `b`.`hawb_date` AS `hawb_date`,
    date_format(`b`.`hawb_date`,'%m-%d-%Y') AS `formatted_date`,
    `b`.`hawb_status` AS `hawb_status_id`,
    `st`.`status_code` AS `hawb_status`,
    `b`.`customer_code` AS `customer_code`,
    `b`.`sender_name` AS `sender_name`,
    `b`.`sender_address` AS `sender_address`,
    `b`.`sender_city` AS `sender_city`,
    `b`.`sender_phone` AS `sender_phone`,
    `b`.`identification_number` AS `identification_number`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`origin` AS `origin_id`,
    `o`.`area_name` AS `origin`,
    `so`.`area` AS `so_branch`,
    `b`.`destination` AS `destination_id`,
    `s`.`area_name` AS `destination`,
    `b`.`receiver_name` AS `receiver_name`,
    `b`.`receiver_address` AS `receiver_address`,
    `b`.`receiver_phone` AS `receiver_phone`,
    `b`.`payment_mode_id` AS `payment_mode_id`,
    `mop`.`payment_mode` AS `payment_mode`,
    `b`.`movement_type_id` AS `movement_type_id`,
    `mov`.`movement_type` AS `movement_type`,
    `b`.`service_mode_id` AS `service_mode_id`,
    `srv`.`service_mode` AS `service_mode`,
    `b`.`no_of_items` AS `no_of_items`,
    `b`.`weight_ref_id` AS `weight_ref_id`,
    `w`.`rate` AS `rate`,
    if((`b`.`total_weight` < 50),`w`.`rate`,(`b`.`total_weight` * `w`.`rate`)) AS `computed_rate`,
    round(if((`b`.`total_weight` < 50),`w`.`commission`,((`b`.`total_weight` * `w`.`rate`) * 0.25)),2) AS `commission`,
    round(if((`b`.`total_weight` < 50),`w`.`duecar`,((`b`.`total_weight` * `w`.`rate`) - ((`b`.`total_weight` * `w`.`rate`) * 0.25))),2) AS `amount_due`,
    `b`.`total_weight` AS `total_weight`,
    `b`.`total_price` AS `total_price`,
    `b`.`discounted_price` AS `discounted_price`,
    `b`.`remarks` AS `remarks`,
    `b`.`created_by` AS `agent_id`,
    `u`.`full_name` AS `agent_name` 
  from 
    (((((((((`booking` `b` left join `vw_loginusers` `u` on((`u`.`id` = `b`.`created_by`))) left join `area_location` `o` on((`o`.`id` = `b`.`origin`))) left join `area_location` `s` on((`s`.`id` = `b`.`destination`))) left join `weight_category` `w` on((`w`.`id` = `b`.`weight_ref_id`))) left join `payment_mode` `mop` on((`mop`.`id` = `b`.`payment_mode_id`))) left join `movement_type` `mov` on((`mov`.`id` = `b`.`movement_type_id`))) left join `service_mode` `srv` on((`srv`.`id` = `b`.`service_mode_id`))) left join `status` `st` on((`st`.`id` = `b`.`hawb_status`))) left join `delivery_area` `so` on((`so`.`id` = `b`.`satellite_office_id`)));


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_previous_month` AS 
  select 
    `b`.`id` AS `id`,
    `b`.`hawb_booking_prefix` AS `hawb_booking_prefix`,
    `b`.`booking_code` AS `booking_code`,
    `b`.`hawb_date` AS `hawb_date`,
    `b`.`formatted_date` AS `formatted_date`,
    `b`.`hawb_status_id` AS `hawb_status_id`,
    `b`.`hawb_status` AS `hawb_status`,
    `b`.`customer_code` AS `customer_code`,
    `b`.`sender_name` AS `sender_name`,
    `b`.`sender_address` AS `sender_address`,
    `b`.`sender_city` AS `sender_city`,
    `b`.`sender_phone` AS `sender_phone`,
    `b`.`identification_number` AS `identification_number`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`destination_id` AS `destination_id`,
    `b`.`destination` AS `destination`,
    `b`.`receiver_name` AS `receiver_name`,
    `b`.`receiver_address` AS `receiver_address`,
    `b`.`receiver_phone` AS `receiver_phone`,
    `b`.`payment_mode_id` AS `payment_mode_id`,
    `b`.`payment_mode` AS `payment_mode`,
    `b`.`movement_type_id` AS `movement_type_id`,
    `b`.`service_mode_id` AS `service_mode_id`,
    `b`.`no_of_items` AS `no_of_items`,
    `b`.`weight_ref_id` AS `weight_ref_id`,
    `b`.`rate` AS `rate`,
    `b`.`computed_rate` AS `computed_rate`,
    `b`.`commission` AS `commission`,
    `b`.`amount_due` AS `amount_due`,
    `b`.`total_weight` AS `total_weight`,
    `b`.`total_price` AS `total_price`,
    `b`.`discounted_price` AS `discounted_price`,
    (`b`.`total_price` - `b`.`discounted_price`) AS `discount`,
    (`b`.`total_price` - `b`.`computed_rate`) AS `declared_value_insurance`,
    `b`.`remarks` AS `remarks`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name` 
  from 
    `vw_booking_details` `b` 
  where 
    (`b`.`hawb_date` between date_format(now(),'%Y-%m-01') and last_day(now()));


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_agent_chart_monthly_booking_counts` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    count(`b`.`id`) AS `tx_count` 
  from 
    `vw_booking_previous_month` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`,`b`.`agent_id`,`b`.`agent_name`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_daily` AS 
  select 
    `b`.`id` AS `id`,
    `b`.`hawb_booking_prefix` AS `hawb_booking_prefix`,
    `b`.`booking_code` AS `booking_code`,
    `b`.`hawb_date` AS `hawb_date`,
    `b`.`formatted_date` AS `formatted_date`,
    `b`.`hawb_status_id` AS `hawb_status_id`,
    `b`.`hawb_status` AS `hawb_status`,
    `b`.`customer_code` AS `customer_code`,
    `b`.`sender_name` AS `sender_name`,
    `b`.`sender_address` AS `sender_address`,
    `b`.`sender_city` AS `sender_city`,
    `b`.`sender_phone` AS `sender_phone`,
    `b`.`identification_number` AS `identification_number`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`destination_id` AS `destination_id`,
    `b`.`destination` AS `destination`,
    `b`.`receiver_name` AS `receiver_name`,
    `b`.`receiver_address` AS `receiver_address`,
    `b`.`receiver_phone` AS `receiver_phone`,
    `b`.`payment_mode_id` AS `payment_mode_id`,
    `b`.`payment_mode` AS `payment_mode`,
    `b`.`movement_type_id` AS `movement_type_id`,
    `b`.`service_mode_id` AS `service_mode_id`,
    `b`.`no_of_items` AS `no_of_items`,
    `b`.`weight_ref_id` AS `weight_ref_id`,
    `b`.`rate` AS `rate`,
    `b`.`computed_rate` AS `computed_rate`,
    `b`.`commission` AS `commission`,
    `b`.`amount_due` AS `amount_due`,
    `b`.`total_weight` AS `total_weight`,
    `b`.`total_price` AS `total_price`,
    `b`.`discounted_price` AS `discounted_price`,
    (`b`.`total_price` - `b`.`discounted_price`) AS `discount`,
    (`b`.`total_price` - `b`.`computed_rate`) AS `declared_value_insurance`,
    `b`.`remarks` AS `remarks`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name` 
  from 
    `vw_booking_details` `b` 
  where 
    (`b`.`formatted_date` = date_format(now(),'%m-%d-%Y'));


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_agent_chart_daily` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    sum((`b`.`commission` - `b`.`discount`)) AS `sales` 
  from 
    `vw_booking_daily` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`,`b`.`agent_id`,`b`.`agent_name`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_agent_chart_monthly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    sum((`b`.`commission` - `b`.`discount`)) AS `sales` 
  from 
    `vw_booking_previous_month` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`,`b`.`agent_id`,`b`.`agent_name`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_previous_week` AS 
  select 
    `b`.`id` AS `id`,
    `b`.`hawb_booking_prefix` AS `hawb_booking_prefix`,
    `b`.`booking_code` AS `booking_code`,
    `b`.`hawb_date` AS `hawb_date`,
    `b`.`formatted_date` AS `formatted_date`,
    `b`.`hawb_status_id` AS `hawb_status_id`,
    `b`.`hawb_status` AS `hawb_status`,
    `b`.`customer_code` AS `customer_code`,
    `b`.`sender_name` AS `sender_name`,
    `b`.`sender_address` AS `sender_address`,
    `b`.`sender_city` AS `sender_city`,
    `b`.`sender_phone` AS `sender_phone`,
    `b`.`identification_number` AS `identification_number`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`destination_id` AS `destination_id`,
    `b`.`destination` AS `destination`,
    `b`.`receiver_name` AS `receiver_name`,
    `b`.`receiver_address` AS `receiver_address`,
    `b`.`receiver_phone` AS `receiver_phone`,
    `b`.`payment_mode_id` AS `payment_mode_id`,
    `b`.`payment_mode` AS `payment_mode`,
    `b`.`movement_type_id` AS `movement_type_id`,
    `b`.`service_mode_id` AS `service_mode_id`,
    `b`.`no_of_items` AS `no_of_items`,
    `b`.`weight_ref_id` AS `weight_ref_id`,
    `b`.`rate` AS `rate`,
    `b`.`computed_rate` AS `computed_rate`,
    `b`.`commission` AS `commission`,
    `b`.`amount_due` AS `amount_due`,
    `b`.`total_weight` AS `total_weight`,
    `b`.`total_price` AS `total_price`,
    `b`.`discounted_price` AS `discounted_price`,
    (`b`.`total_price` - `b`.`discounted_price`) AS `discount`,
    (`b`.`total_price` - `b`.`computed_rate`) AS `declared_value_insurance`,
    `b`.`remarks` AS `remarks`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name` 
  from 
    `vw_booking_details` `b` 
  where 
    (`b`.`hawb_date` between date_format((now() - interval weekday(now()) day),'%Y-%m-%d') and cast((now() + interval (6 - weekday(now())) day) as date));


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_agent_chart_weekly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    sum((`b`.`commission` - `b`.`discount`)) AS `sales` 
  from 
    `vw_booking_previous_week` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`,`b`.`agent_id`,`b`.`agent_name`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_agent_totals_daily` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_daily` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`agent_id`,`b`.`agent_name`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_agent_totals_monthly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_previous_month` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`agent_id`,`b`.`agent_name`;



CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_agent_totals_weekly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_previous_week` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`agent_id`,`b`.`agent_name`;



CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_branch_totals_daily` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_daily` `b` 
  group by 
    `b`.`origin_id`,`b`.`origin`,`b`.`satellite_office_id`,`b`.`so_branch`;



CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_branch_totals_monthly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_previous_month` `b` 
  group by 
    `b`.`origin_id`,`b`.`origin`,`b`.`satellite_office_id`,`b`.`so_branch`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_branch_totals_weekly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_previous_week` `b` 
  group by 
    `b`.`origin_id`,`b`.`origin`,`b`.`satellite_office_id`,`b`.`so_branch`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_chart_daily` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    sum((`b`.`commission` - `b`.`discount`)) AS `sales` 
  from 
    `vw_booking_daily` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_chart_monthly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    sum((`b`.`commission` - `b`.`discount`)) AS `sales` 
  from 
    `vw_booking_previous_month` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_chart_weekly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    sum((`b`.`commission` - `b`.`discount`)) AS `sales` 
  from 
    `vw_booking_previous_week` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_station_totals_daily` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_daily` `b` 
  group by 
    `b`.`origin_id`,`b`.`origin`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_station_totals_monthly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_previous_month` `b` 
  group by 
    `b`.`origin_id`,`b`.`origin`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_station_totals_weekly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_previous_week` `b` 
  group by 
    `b`.`origin_id`,`b`.`origin`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_status` AS 
  select 
    `booking_status`.`hawb_id` AS `hawb_id`,
    max(concat(`booking_status`.`status_date`,' ',`booking_status`.`status_time`)) AS `status_datetime` 
  from 
    `booking_status` 
  group by 
    `booking_status`.`hawb_id`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_status_details` AS 
  select 
    `bs`.`id` AS `id`,
    `bs`.`hawb_id` AS `hawb_id`,
    `bs`.`hawb_code` AS `hawb_code`,
    `a`.`status_datetime` AS `status_datetime`,
    `bs`.`location_id` AS `location_id`,
    `bs`.`status_id` AS `status_id`,
    `bs`.`created_by` AS `updated_by` 
  from 
    (`booking_status` `bs` join `vw_booking_status` `a` on((`a`.`status_datetime` = concat(`bs`.`status_date`,' ',`bs`.`status_time`))));


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_totals` AS
select 
    `b`.`id` AS `id`,
    `b`.`booking_code` AS `book_no`,
    `b`.`hawb_date` AS `hawb_date`,
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`receiver_name` AS `receiver_name`,
    `b`.`destination_id` AS `destination_id`,
    `b`.`destination` AS `destination`,
    `b`.`total_price` AS `total_price` 
  from 
    `vw_booking_details` `b`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_customers` AS 
  select 
    `c`.`id` AS `id`,
    concat('C',`c`.`id`) AS `cust_id`,
    concat(ifnull(`c`.`first_name`,''),' ',ifnull(`c`.`last_name`,'')) AS `cust_name`,
    `c`.`address` AS `address`,
    `c`.`station_id` AS `station_id`,
    `st`.`area_name` AS `station_name`,
    `c`.`satellite_office_id` AS `satellite_office_id`,
    `so`.`area` AS `satellite_office_name`,
    `c`.`phone` AS `phone`,
    `c`.`email_address` AS `email_address`,
    `c`.`identification_type` AS `identification_type`,
    `c`.`identification_number` AS `identification_number`,
    `c`.`percentage_discount` AS `percentage_discount`,
    `c`.`created_by` AS `created_by` 
  from 
    ((`customer` `c` join `area_location` `st` on((`st`.`id` = `c`.`station_id`))) left join `delivery_area` `so` on((`so`.`id` = `c`.`satellite_office_id`)));


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_hawb_items` AS 
  select 
    `bd`.`id` AS `id`,
    `bd`.`booking_id` AS `booking_id`,
    `bd`.`booking_code` AS `booking_code`,
    `bd`.`shipment_type_id` AS `shipment_type_id`,
    ifnull(`st`.`type_of_shipment`,'N/A') AS `shipment_type`,
    `bd`.`quantity` AS `quantity`,
    `bd`.`container_length` AS `container_length`,
    `bd`.`container_width` AS `container_width`,
    `bd`.`container_height` AS `container_height`,
    `bd`.`dimension_total` AS `dimension_total`,
    `bd`.`dimension_weight` AS `dimension_weight`,
    `bd`.`actual_weight` AS `actual_weight`,
    `bd`.`preferred_weight` AS `preferred_weight`,
    `bd`.`declared_value` AS `declared_value` 
  from 
    (`booking_item_details` `bd` left join `shipment_type` `st` on((`st`.`id` = `bd`.`shipment_type_id`)));


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_satellite_office_agents` AS 
  select 
    `u`.`id` AS `id`,
    `u`.`user_type_id` AS `user_type_id`,
    `u`.`code` AS `code`,
    `u`.`identification_type` AS `identification_type`,
    `u`.`identification_no` AS `identification_no`,
    `u`.`username` AS `username`,
    concat(ifnull(`u`.`firstname`,''),' ',ifnull(`u`.`lastname`,'')) AS `agent_name`,
    `u`.`password` AS `password`,
    `u`.`address` AS `address`,
    `u`.`station_id` AS `station_id`,
    `u`.`satellite_office_id` AS `satellite_office_id`,
    `u`.`phone` AS `phone`,
    `u`.`email` AS `email`,
    `u`.`creation_date` AS `creation_date`,
    `u`.`last_modified_date` AS `last_modified_date`,
    `da`.`area` AS `satellite_office` 
  from 
    (`users` `u` left join `delivery_area` `da` on((`da`.`id` = `u`.`satellite_office_id`))) 
  where 
    (`u`.`user_type_id` = 6);


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_track_booking` AS 
  select 
    `b`.`id` AS `id`,
    `b`.`booking_code` AS `booking_code`,
    `b`.`sender_name` AS `sender_name`,
    `b`.`receiver_name` AS `receiver_name`,
    `b`.`receiver_address` AS `receiver_address`,
    `b`.`receiver_phone` AS `receiver_phone`,
    `s`.`location_id` AS `location_id`,
    `loc`.`area_name` AS `location`,
    `s`.`status_id` AS `status_id`,
    `st`.`status_code` AS `status`,
    `st`.`description` AS `status_description`,
    `s`.`updated_by` AS `updated_by`,
    `u`.`full_name` AS `full_name` 
  from 
    ((((`vw_booking_details` `b` join `vw_booking_status_details` `s` on((`s`.`hawb_id` = `b`.`id`))) join `area_location` `loc` on((`loc`.`id` = `s`.`location_id`))) join `status` `st` on((`st`.`id` = `s`.`status_id`))) join `vw_loginusers` `u` on((`u`.`id` = `s`.`updated_by`)));










