alter table deliveryarea
add column branch_name varchar(25),
add column address1 text,
add column address2 text,
add column business_number varchar(15),
add column fax_number varchar(15),
add column mobile_number varchar(15),
add column contact_person varchar(25),
add column latitude decimal(11,5),
add column longitude decimal(11,5);

-- select * from deliveryarea
