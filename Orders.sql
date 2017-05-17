/* Orders Table */

DROP TABLE IF EXISTS orders;


CREATE TABLE orders(
	id INT NOT NULL AUTO_INCREMENT,
    itemQuantity INT unsigned NOT NULL,
	customerName VARCHAR(100) NOT NULL,
    homeAddress VARCHAR(100) NOT NULL,
	itemsOrdered VARCHAR(250) NOT NULL,
	totalPrice DECIMAL(6,2) NOT NULL,
	orderStatus VARCHAR(100) NOT NULL,
	PRIMARY KEY(id)
    UNIQUE KEY(itemsOrdered)
    UNIQUE KEY(totalPrice)
    UNIQUE KEY(orderStatus)
);


INSERT INTO orders (customerName, itemsOrdered, totalPrice, orderStatus) VALUES ('John Doe', 'Sirloin Steak(4), Whole Milk(1), Corn(4)', 61.50, 'Delivered');
INSERT INTO orders (customerName, itemsOrdered, totalPrice, orderStatus) VALUES ('James Smith', 'Lamb Chop(5), 2 Liter Diet Coke(1), Onion(4)', 72.40, 'Waiting for Delivery');
INSERT INTO orders (customerName, itemsOrdered, totalPrice, orderStatus) VALUES ('Jane Doe', 'Lobster(2), Sparkling Water(2), Butter(1)', 43.75, 'Delivered');
INSERT INTO orders (customerName, itemsOrdered, totalPrice, orderStatus) VALUES ('Jacky Smith', 'Whole Wheat Spaghetti(1), 6-Pack BudLight(1), Italian Bread(1)', 32.63, 'Waiting for Delivery');