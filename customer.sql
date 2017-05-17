/* This table holds user accounts */

DROP TABLE IF EXISTS customers;

CREATE TABLE customers (
	id INT NOT NULL AUTO_INCREMENT,
	customerName VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL,
	hashedpass VARCHAR(255) NOT NULL,
    homeAddress VARCHAR(255) NOT NULL,
    billingAddress VARCHAR(255) NOT NULL,
    creditCard int(12) NOT NULL,
    cardExp VARCHAR(5) NOT NULL,
    cardCode int(3) NOT NULL,
	PRIMARY KEY (id)
    UNIQUE KEY(customerName)
    UNIQUE KEY(homeAddress)
);