CREATE TABLE user (
    id INT(5) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(200) NOT NULL,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    userlevel CHAR(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE customer (
    cust_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cust_name VARCHAR(50),
    cust_surname VARCHAR(50),
    cust_idcard VARCHAR(20),
    cust_tel VARCHAR(20),
    cust_email VARCHAR(50),
    cust_username VARCHAR(50),
    cust_password VARCHAR(20),
    cust_status VARCHAR(20)
);


CREATE TABLE employee (
    emp_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    emp_name VARCHAR(50),
    emp_username VARCHAR(50),
    emp_password VARCHAR(20)
);


CREATE TABLE room_type (
    type_room VARCHAR(50),
    type_rental INT(20),
    type_picture VARCHAR(100),
    PRIMARY KEY (type_room)
);

CREATE TABLE room (
    room_id VARCHAR(10),
    room_status CHAR(1),
    room_data VARCHAR(100),
    type_room VARCHAR(50),
    PRIMARY KEY (room_id),
    FOREIGN KEY (type_room) REFERENCES room_type(type_room)
);

CREATE TABLE contract (
    con_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    con_checkin DATETIME,
    cust_id INT(10),
    room_id  VARCHAR(50),
    con_rental INT(10),
    con_deposit INT(10),
    img_document VARCHAR(100),
    img_contract VARCHAR(100),
    con_status CHAR(1),
    FOREIGN KEY (cust_id) REFERENCES customer(cust_id),
    FOREIGN KEY (room_id) REFERENCES room(room_id)
);

CREATE TABLE invoice (
    invoice_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    invoice_date DATETIME,
    invoice_month VARCHAR(10),
    invoice_year VARCHAR(10)
);

CREATE TABLE invoice_detail (
    invoiced_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    invoice_id INT(10),
    cust_id INT(10),
    room_id VARCHAR(10),
    invoiced_fire_meter  INT(10),
    invoiced_fire_unit INT(10),
    invoiced_water_meter INT(10),
    invoiced_water_unit INT(10),
    invoiced_rental INT(10),
    invoiced_penalty INT(10),
    invoiced_deadtime DATETIME,
    invoiced_total INT(10),
    FOREIGN KEY (invoice_id) REFERENCES invoice(invoice_id),
    FOREIGN KEY (cust_id) REFERENCES customer(cust_id),
    FOREIGN KEY (room_id) REFERENCES room(room_id)
);

CREATE TABLE payment (
    pay_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pay_date DATETIME,
    pay_amount INT(10),
    invoice_year VARCHAR(50),
    invoiced_id  INT(10),
    cust_id INT(10),
    pay_slip VARCHAR(100),
    pay_status VARCHAR(100),
    FOREIGN KEY (invoiced_id) REFERENCES invoice_detail(invoiced_id),
    FOREIGN KEY (cust_id) REFERENCES customer(cust_id)
);