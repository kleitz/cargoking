select 
    c.id AS id,
    concat('C',c.id) AS cust_id,
    concat(ifnull(c.first_name,''),' ',ifnull(c.last_name,'')) AS cust_name,
    c.address AS address,
    c.station_id AS station_id,
    c.satellite_office_id AS satellite_office_id,
    c.phone AS phone,
    c.email_address AS email_address,
    c.identification_type AS identification_type,
    c.identification_number AS identification_number,
    c.percentage_discount AS percentage_discount 
  from 
    customer c