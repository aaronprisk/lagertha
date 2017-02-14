GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'lagertha'@'%' IDENTIFIED BY PASSWORD '*3C050DC10B57B04B683CD56DEE05C480CFB6C044';
GRANT UPDATE (status, pending) ON `lagertha`.`tasks` TO 'lagertha'@'%';
GRANT UPDATE (last_check) ON `lagertha`.`hosts` TO 'lagertha'@'%';
GRANT SELECT ON *.* TO 'register'@'%' IDENTIFIED BY PASSWORD '*3602DE65DB1B637F8C523EE0C96A2E11E1DA3531';
GRANT SELECT, INSERT ON `lagertha`.`hosts` TO 'register'@'%';

use login;
INSERT INTO users (user_name, user_password_hash, user_email) VALUES("lagertha", "$2y$10$t/ah4VLdqLHnPghrwhXO/.UVKme9jsg0nPrLY1Up6JOJgPorzF5Sy", "admin@localhost.local");
