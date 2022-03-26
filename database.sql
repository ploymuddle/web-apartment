
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

CREATE TABLE room_type (
    type_room VARCHAR(50),
    type_data VARCHAR(200),
    type_rental INT(20),
    type_picture VARCHAR(100),
    PRIMARY KEY (type_room)
);

CREATE TABLE room (
    room_id VARCHAR(10),
    room_status CHAR(1),
    type_room VARCHAR(50),
    PRIMARY KEY (room_id),
    FOREIGN KEY (type_room) REFERENCES room_type(type_room)
);

CREATE TABLE contract (
    con_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    con_checkin DATE,
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
    inv_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cust_id INT(10),
    room_id VARCHAR(10),
    inv_fire_meter  INT(10),
    inv_fire_unit INT(10),
    inv_water_meter INT(10),
    inv_water_unit INT(10),
    inv_rental INT(10),
    inv_penalty INT(10),
    inv_total INT(10),
    inv_date DATE,
    inv_deadtime DATE,
    FOREIGN KEY (cust_id) REFERENCES customer(cust_id),
    FOREIGN KEY (room_id) REFERENCES room(room_id)
);

CREATE TABLE payment (
    pay_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pay_date DATE,
    pay_amount INT(10),
    inv_id  INT(10),
    cust_id INT(10),
    pay_slip VARCHAR(100),
    pay_status VARCHAR(100),
    FOREIGN KEY (inv_id) REFERENCES invoice(inv_id),
    FOREIGN KEY (cust_id) REFERENCES customer(cust_id)
);

INSERT INTO room_type VALUES ('A', 'ห้องไม่มีระเบียง', 1200, 'images/bgroom1.jpeg');
INSERT INTO room_type VALUES ('B', 'ห้องมีระเบียง', 2400, 'images/bgroom2.jpeg');
INSERT INTO room_type VALUES ('C', 'ห้องตรงกลางติดริมบันได', 3600, 'images/bgroom3.jpeg');
INSERT INTO room_type VALUES ('D', 'ห้องริมตึก', 4800, 'images/bgroom4.jpeg');

CREATE TABLE messages (
    id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    from_user DATE,
    to_user INT(10),
    messages  INT(10),
    date INT(10)
);