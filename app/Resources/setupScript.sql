insert into role (name, friendly_name) values ('ROLE_ADMIN','admin');
insert into role (name, friendly_name) values ('ROLE_CLIENT','client');
insert into users (guid, username, password, firstname, surname, active, date_added, temp_password ) values ('fa952ca3e5947976bdb70d658866196c', 'nick@oscella.co.uk', '$2y$13$g6Iwa.Iu80qhcQbfQ6qBvugW3Vv8BKQOCE1DkG8h2qMrLbJlzxSpW', 'nick', 'hurn', 1, '2020-08-03 16:00:00', 0);
insert into users_roles (user_id, role_id) value (1,1);
ALTER TABLE client_invoices AUTO_INCREMENT=10001;
ALTER TABLE clients AUTO_INCREMENT=10001;