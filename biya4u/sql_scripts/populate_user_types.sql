delete from user_types;

commit;

insert into user_types(id, type_code, type_name, type_description, creation_date, last_modified_date) values (1, 'ADMIN', 'Admin', 'Super Admin', now(), now());
insert into user_types(id, type_code, type_name, type_description, creation_date, last_modified_date) values (2, 'STATION_ADMIN', 'Station Admin', 'Station Admin', now(), now());
insert into user_types(id, type_code, type_name, type_description, creation_date, last_modified_date) values (3, 'MANAGER', 'Branch Manager', 'Branch Manager', now(), now());
insert into user_types(id, type_code, type_name, type_description, creation_date, last_modified_date) values (4, 'EXCESS_BAGGAGE', 'Excess Baggage', 'Excess Baggage', now(), now());
insert into user_types(id, type_code, type_name, type_description, creation_date, last_modified_date) values (5, 'SORTER', 'Sorter', 'Sorter', now(), now());
insert into user_types(id, type_code, type_name, type_description, creation_date, last_modified_date) values (6, 'SO_AGENT', 'Satellite Office Agent', 'Satellite Office Agent or Staff', now(), now());
insert into user_types(id, type_code, type_name, type_description, creation_date, last_modified_date) values (7, 'DELIVERY_PERSONNEL', 'Delivery Personnel', 'Delivery Personnel', now(), now());

commit;

select * from user_types;

