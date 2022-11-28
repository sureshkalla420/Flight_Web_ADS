CREATE DATABASE flight;
USE flight;

CREATE TABLE users( 
  name VARCHAR(20) NOT NULL, 
  email VARCHAR(100) PRIMARY KEY,
  password CHAR(128) NOT NULL
);

CREATE TABLE places( 
  place VARCHAR(100) NOT NULL
);

INSERT INTO `places`(`place`) VALUES ('Kansas');
INSERT INTO `places`(`place`) VALUES ('Chicago');
INSERT INTO `places`(`place`) VALUES ('Dallas');
INSERT INTO `places`(`place`) VALUES ('Neywork');


CREATE TABLE flights(
  flight VARCHAR(100) NOT NULL,
  date_time VARCHAR(100) NOT NULL,
  source VARCHAR(100) NOT NULL,
  destination VARCHAR(100) NOT NULL,
  flight_id VARCHAR(100) PRIMARY KEY
);

INSERT INTO `flights`(`flight`,`date_time`,`source`,`destination`,`flight_id`) VALUES ('KS1245','2022-12-07','Kansas','Chicago','F001');
INSERT INTO `flights`(`flight`,`date_time`,`source`,`destination`,`flight_id`) VALUES ('CH1246','2022-11-19','Chicago','Dallas','F002');
INSERT INTO `flights`(`flight`,`date_time`,`source`,`destination`,`flight_id`) VALUES ('DA1247','2022-11-20','Dallas','Chicago','F003');
INSERT INTO `flights`(`flight`,`date_time`,`source`,`destination`,`flight_id`) VALUES ('NW1248','2022-11-21','Neywork','Chicago','F004');



CREATE TABLE flight_seats(
  track_id VARCHAR(100) NOT NULL UNIQUE,
  flight_id VARCHAR(100) NOT NULL,
  seat_no VARCHAR(100) NOT NULL,
  hold boolean DEFAULT 0,
  booking_user_id VARCHAR(100) NOT NULL,
  background_verification boolean DEFAULT 0,
  payment_status boolean DEFAULT 0,
  data_created VARCHAR(100) NOT NULL,
  date_updated VARCHAR(100),
  confirmed boolean  DEFAULT 0
);

INSERT INTO `flight_seats`(`track_id`,`flight_id`,`seat_no`,`hold`,`booking_user_id`,`background_verification`,`payment_status`,`data_created`,`date_updated`,`confirmed`) VALUES ('ABCDEFGHIJKLMNOP12345678','F001','0',0,'j@gmail.com',0,0,'2022-11-18','',0);
INSERT INTO `flight_seats`(`track_id`,`flight_id`,`seat_no`,`hold`,`booking_user_id`,`background_verification`,`payment_status`,`data_created`,`date_updated`,`confirmed`) VALUES ('ABCDEFGHIJKLMNOP12345679','F002','1',0,'j@gmail.com',0,0,'2022-11-19','',0);
INSERT INTO `flight_seats`(`track_id`,`flight_id`,`seat_no`,`hold`,`booking_user_id`,`background_verification`,`payment_status`,`data_created`,`date_updated`,`confirmed`) VALUES ('ABCDEFGHIJKLMNOP12345680','F003','2',0,'j@gmail.com',0,0,'2022-11-20','',0);

INSERT INTO `flight_seats`(`track_id`,`flight_id`,`seat_no`,`hold`,`booking_user_id`,`background_verification`,`payment_status`,`data_created`,`date_updated`,`confirmed`) VALUES ('ABCDEFGHIJKLMNOP12345681','F001','1',0,'j@gmail.com',0,0,'2022-11-18','',0);
INSERT INTO `flight_seats`(`track_id`,`flight_id`,`seat_no`,`hold`,`booking_user_id`,`background_verification`,`payment_status`,`data_created`,`date_updated`,`confirmed`) VALUES ('ABCDEFGHIJKLMNOP12345682','F002','2',0,'j@gmail.com',0,0,'2022-11-19','',0);
INSERT INTO `flight_seats`(`track_id`,`flight_id`,`seat_no`,`hold`,`booking_user_id`,`background_verification`,`payment_status`,`data_created`,`date_updated`,`confirmed`) VALUES ('ABCDEFGHIJKLMNOP12345683','F003','3',0,'j@gmail.com',0,0,'2022-11-20','',0);
