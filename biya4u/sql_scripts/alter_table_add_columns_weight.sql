alter table weight 
add column created_by integer(11) not null,
add column create_date datetime,
add column last_modified_by integer(11) not null,
add column last_modified_date datetime;