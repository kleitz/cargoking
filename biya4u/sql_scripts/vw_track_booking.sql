select 
    b.id AS id,
    b.booking_code AS booking_code,
    b.sender_name AS sender_name,
    b.receiver_name AS receiver_name,
    b.receiver_address AS receiver_address,
    b.receiver_phone AS receiver_phone,
    s.location_id AS location_id,
    loc.category AS location,
    s.status_id AS status_id,
    st.category AS status,
    st.description AS status_description,
    s.updated_by AS updated_by,
    u.full_name AS full_name 
  from 
    ((((vw_booking_details b join vw_booking_status_details s on((s.hawb_id = b.id))) join bplace loc on((loc.id = s.location_id))) join status st on((st.id = s.status_id))) join vw_loginusers u on((u.id = s.updated_by)))