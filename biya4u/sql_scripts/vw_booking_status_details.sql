select 
	bs.id,
	bs.hawb_id,
	bs.hawb_code,
	a.status_datetime,
	bs.location_id,
	bs.status_id,
	bs.created_by updated_by
from booking_status bs
inner join vw_booking_status a on
	a.status_datetime = concat(bs.status_date, ' ', bs.status_time)