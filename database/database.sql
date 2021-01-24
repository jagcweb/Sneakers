CREATE DATABASE IF NOT EXISTS Sneakers;

use Sneakers;


CREATE TABLE users (
id int(255) not null auto_increment,
role varchar (20) not null,
name varchar (50) not null,
surname varchar (50) not null,
email varchar(100) not null,
password varchar(255) not null,
image varchar(255),
created_at datetime,
updated_at datetime,
remember_token varchar(255),
CONSTRAINT pk_user PRIMARY KEY (id),
CONSTRAINT uq_email UNIQUE (email)
)ENGINE=InnoDb;


CREATE TABLE categories (
id int (255) not null auto_increment,
name varchar (50) not null,
created_at datetime,
updated_at datetime,
CONSTRAINT pk_category PRIMARY KEY (id)
)ENGINE=InnoDb;


CREATE TABLE products(
id int (255) not null auto_increment,
category_id int (255) not null,
name varchar (50) not null,
brand varchar (50) not null,
price decimal (10,2) not null,
created_at datetime,
updated_at datetime,
CONSTRAINT pk_product PRIMARY KEY (id),
CONSTRAINT fk_category_products FOREIGN KEY(category_id) REFERENCES categories(id)
)ENGINE=InnoDb;


CREATE TABLE stocks(
id int (255) not null auto_increment,
product_id int (255) not null,
stock int (50)not null,
CONSTRAINT pk_stock PRIMARY KEY (id),
CONSTRAINT fk_product_stock FOREIGN KEY(product_id) REFERENCES products(id)
)ENGINE=InnoDb;


CREATE TABLE product_images(
id int (255) not null auto_increment,
product_id int (255) not null,
image varchar(255) not null,
CONSTRAINT pk_products_image PRIMARY KEY (id),
CONSTRAINT fk_products_products_image FOREIGN KEY(product_id) REFERENCES products(id)
)ENGINE=InnoDb;


CREATE TABLE orders(
id int (255) not null auto_increment,
user_id int (255) not null,
status varchar(50) not null,
province varchar(50) not null,
city varchar(50) not null,
postal_code varchar(50) not null,
address varchar(100) not null,
total_price decimal (10,2) not null,
date_order date not null,
CONSTRAINT pk_orders PRIMARY KEY (id),
CONSTRAINT fk_users_orders FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;


CREATE TABLE order_items(
id int (255) not null auto_increment,
order_id int (255) not null,
product_id int (255) not null,
price decimal (10,2) not null,
quantity int(50) not null,
discount int (10) not null,
CONSTRAINT pk_orders_items PRIMARY KEY (id),
CONSTRAINT fk_orders_order_items FOREIGN KEY(order_id) REFERENCES orders(id),
CONSTRAINT fk_products_orders_items FOREIGN KEY(product_id) REFERENCES products(id)
)ENGINE=InnoDb;