select 
	bs.hawb_id, 
	bs.hawb_code, 
	loc.category as location, 
	bs.status_id, 
	bs.comments,
	a.status_datetime, 
	u.full_name, 
	b.sender_name, 
	b.receiver_name, 
	b.receiver_address, 
	b.receiver_phone
from booking_status bs
inner join vw_booking_details b on
	b.id = bs.hawb_id
inner join bplace loc on
	loc.id = bs.location_id
inner join vw_loginusers u on
	u.id = bs.created_by
inner join (
	select hawb_id, max(concat(status_date, ' ', status_time))  as status_datetime
	from booking_status
	group by hawb_id
) a on
	concat(bs.status_date, ' ', bs.status_time) = a.status_datetime