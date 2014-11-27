delete from status;

insert into status (id, category, description, remarks, created_by, create_date, last_modified_by, last_modified_date) values (1, 'IN_TRANSIT', 'In-Transit: From Port of Origin to Port of Destination', 'In-Transit: From Port of Origin to Port of Destination', 1, now(), 1, now());
insert into status (id, category, description, remarks, created_by, create_date, last_modified_by, last_modified_date) values (2, 'SCHEDULED', 'Scheduled', 'Scheduled', 1, now(), 1, now());
insert into status (id, category, description, remarks, created_by, create_date, last_modified_by, last_modified_date) values (3, 'DELIVERED', 'Item received (Picked-up / Delivered)', 'Item Delivered, either picked-up or delivered to recipient.', 1, now(), 1, now());
insert into status (id, category, description, remarks, created_by, create_date, last_modified_by, last_modified_date) values (4, 'CONNECTING_ROUTE', 'Connecting Route', 'Connecting Route', 1, now(), 1, now());
insert into status (id, category, description, remarks, created_by, create_date, last_modified_by, last_modified_date) values (5, 'FOR_PICKUP', 'For Pick-Up', 'For Pick-Up', 1, now(), 1, now());
insert into status (id, category, description, remarks, created_by, create_date, last_modified_by, last_modified_date) values (6, 'FOR_DELIVERY', 'For Delivery', 'For Delivery', 1, now(), 1, now());
insert into status (id, category, description, remarks, created_by, create_date, last_modified_by, last_modified_date) values (7, 'ARRIVED_AT_DESTINATION', 'Arrived at Destination & Offloaded', 'Arrived at Destination & Offloaded', 1, now(), 1, now());
insert into status (id, category, description, remarks, created_by, create_date, last_modified_by, last_modified_date) values (8, 'OFFLOADED', 'Offloaded', 'Offloaded', 1, now(), 1, now());
insert into status (id, category, description, remarks, created_by, create_date, last_modified_by, last_modified_date) values (9, 'CROUTE_VIA_MANILA', 'Connecting Route Via Manila', 'Connecting Route Via Manila', 1, now(), 1, now());
insert into status (id, category, description, remarks, created_by, create_date, last_modified_by, last_modified_date) values (10, 'SAT_OFC_TO_ORIGIN_PORT', 'Satellite Office to Port (Origin)', 'Satellite Office to Port (Origin)', 1, now(), 1, now());

commit;

select * from status

-- In-Transit, Offload (Origin), Arrived at Destination, Delivered

-- Satellite Offices to Port (Origin)
-- In-Transit: From Port of Origin to Port of Destination
-- Arrived at Destination & Offloaded
-- 