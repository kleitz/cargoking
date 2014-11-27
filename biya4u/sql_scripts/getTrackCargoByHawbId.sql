select
	b.id,
	b.booking_code,
	b.sender_name,
	b.receiver_name,
	b.receiver_address,
	b.receiver_phone,
	b.hawb_status
	b.remarks
from vw_booking_details b
