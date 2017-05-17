/* Ordered Products Table */

DROP TABLE IF EXISTS orderedProducts;


CREATE TABLE orderedProducts(
	id INT NOT NULL AUTO_INCREMENT,
	quantity INT unsigned NOT NULL,
	PRIMARY KEY(id)
  
);