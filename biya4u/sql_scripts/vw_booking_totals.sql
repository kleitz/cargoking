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