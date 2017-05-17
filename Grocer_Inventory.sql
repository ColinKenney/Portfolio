DROP TABLE IF EXISTS inventory;

CREATE TABLE inventory(
	id INT NOT NULL AUTO_INCREMENT,
    image VARCHAR(200) NOT NULL,
	category VARCHAR(100) NOT NULL,
	product VARCHAR(100) NOT NULL,
	unit INT unsigned NOT NULL,
	price DECIMAL(6,2) NOT NULL,
	stock INT unsigned NOT NULL,
	PRIMARY KEY(id)
    
);


--data for inventory
INSERT INTO inventory(image, category, product, unit, price, stock) VALUES ('http://www.aedairy.com/images/products/Whole-Milk-AE-gallon.jpg', 'Dairy', 'Whole Milk', '1', 7.50, 100);
INSERT INTO inventory(image, category, product, unit, price, stock) VALUES ('http://lancastria.net/blog/wp-content/uploads/2014/07/corn.jpg', 'Produce', 'Corn', '1', 0.25, 250);
INSERT INTO inventory(image, category, product, unit, price, stock) VALUES ('https://saltmarshrunning.com/wp-content/uploads/2014/09/bananasf.jpg', 'Fruit', 'Banana', '5', 3.99, 150);
