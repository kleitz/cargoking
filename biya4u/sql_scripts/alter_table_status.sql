alter table status
add column description text, 
add column remarks text, 
add column created_by integer(11) not null,
add column create_date datetime,
add column last_modified_by integer(11) not null,
add column last_modified_date datetime;