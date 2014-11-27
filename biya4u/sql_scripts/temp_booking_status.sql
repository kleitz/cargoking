select bs.*, loc.category as location, u.full_name
from booking_status bs
inner join bplace loc on
	loc.id = bs.location_id
inner join vw_loginusers u on
	u.id = bs.created_by