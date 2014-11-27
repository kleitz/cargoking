select 
	bs.id,
	b.*, 
	bs.location_id, 
	bs.status_id,
	bs.status_date,
	bs.status_time,
	bs.created_by,
	bs.comments
from vw_booking_details b
left join booking_status bs on
	bs.hawb_id = b.id