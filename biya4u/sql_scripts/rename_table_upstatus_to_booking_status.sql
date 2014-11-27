alter table upstatus rename booking_status;
alter table booking_status change hwid hawb_code varchar(50);
alter table booking_status change date status_date DATE;
alter table booking_status change time status_time TIME;
alter table booking_status change location location_id INTEGER(11);
alter table booking_status change status status_id INTEGER(11);
alter table booking_status add hawb_id integer(11);
alter table booking_status add created_by integer(11);
alter table booking_status add create_date DATETIME;
alter table booking_status add last_modified_by integer(11);
alter table booking_status add last_modified_date DATETIME;

select * from booking_status;