select 
    u.id AS id,
    ut.type_code AS type_code,
    ut.type_name AS type_name,
    u.username AS username,
    u.name AS name,
    u.firstname AS firstname,
    u.lastname AS lastname,
    u.middlename AS middlename,
    concat(ifnull(u.firstname,''),' ',ifnull(u.lastname,'')) AS full_name,
    u.password AS password,
    ifnull(u.address,'N/A') AS address,
    u.email AS email,
    ifnull(u.phone,'N/A') AS contact_number,
    u.station_id AS station_id,
    u.satellite_office_id AS satellite_office_id,
    so.station_hawb_prefix AS hawb_booking_prefix 
  from 
    ((users u join user_types ut on((ut.id = u.user_type_id))) left join deliveryarea so on((so.id = u.satellite_office_id)))