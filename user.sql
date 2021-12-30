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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE employee (
    emp_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    emp_name VARCHAR(50),
    emp_username VARCHAR(50),
    emp_password VARCHAR(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;