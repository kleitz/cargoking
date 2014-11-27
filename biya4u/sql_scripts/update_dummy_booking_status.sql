select * from booking
select * from booking_item_details
select * from status

update booking_status set
	status_date = '2014-06-02',
	status_time = '06:23:12',
	comments = 'In Transit',
	created_by = 21,
	create_date = '2014-06-03 12:57:12',
	last_modified_by = 21,
	last_modified_date = '2014-06-03 12:57:12'
where 
	id = 1221;

update booking_status set
	status_date = '2014-06-03',
	status_time = '12:57:12',
	comments = 'Cargo arrived in manila and for delivery',
	created_by = 25,
	create_date = '2014-06-03 12:57:12',
	last_modified_by = 25,
	last_modified_date = '2014-06-03 12:57:12'
where 
	id = 1222;

commit;

-- 2014-06-02 06:23:12