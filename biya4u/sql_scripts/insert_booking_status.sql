delete from booking_status where hawb_code = 'CK-DVO-BUHANGIN-1039';

insert into booking_status(hawb_id, hawb_code, status_date, status_time, location_id, status_id, comments, created_by, create_date, last_modified_by, last_modified_date) values (1039, 'CK-DVO-BUHANGIN-1039', '2014-06-02', '06:23:12', 8, 1, 'In Transit', 21, '2014-06-03 12:57:12', 21, '2014-06-03 12:57:12');
insert into booking_status(hawb_id, hawb_code, status_date, status_time, location_id, status_id, comments, created_by, create_date, last_modified_by, last_modified_date) values (1039, 'CK-DVO-BUHANGIN-1039', '2014-06-03', '12:57:12', 7, 7, 'Cargo arrived in manila and for delivery', 25, '2014-06-03 12:57:12', 25, '2014-06-03 12:57:12');
insert into booking_status(hawb_id, hawb_code, status_date, status_time, location_id, status_id, comments, created_by, create_date, last_modified_by, last_modified_date) values (1039, 'CK-DVO-BUHANGIN-1039', '2014-06-03', '18:30:29', 7, 3, 'Delivered', 26, '2014-06-03 18:30:29', 26, '2014-06-03 18:30:29');

commit;