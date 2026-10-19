DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS admins;



CREATE TABLE admins (
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(50) UNIQUE NOT NULL,
 password_hash CHAR(64) NOT NULL,
 full_name VARCHAR(100) NOT NULL
);

CREATE TABLE categories (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 slug VARCHAR(100) NOT NULL
);

CREATE TABLE customers (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 phone VARCHAR(30),
 email VARCHAR(150),
 address VARCHAR(255),
 created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
 id INT AUTO_INCREMENT PRIMARY KEY,
 category_id INT NOT NULL,
 name VARCHAR(150) NOT NULL,
 price DECIMAL(12,2) NOT NULL,
 stock INT NOT NULL DEFAULT 0,
 description TEXT,
 is_featured TINYINT(1) DEFAULT 0,
 created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(category_id) REFERENCES categories(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    address VARCHAR(255) NOT NULL,
    note TEXT,
    total DECIMAL(12,2) NOT NULL,
    status VARCHAR(30) DEFAULT 'Moi',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
 id INT AUTO_INCREMENT PRIMARY KEY,
 order_id INT NOT NULL,
 product_id INT NOT NULL,
 quantity INT NOT NULL,
 price DECIMAL(12,2) NOT NULL,
 FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE,
 FOREIGN KEY(product_id) REFERENCES products(id)
);

INSERT INTO admins(username,password_hash,full_name) VALUES
('admin',SHA2('admin123',256),'Quản trị viên Hưng Yến');

INSERT INTO categories(name,slug) VALUES
('Áo','ao'),('Quần','quan'),('Váy','vay'),('Phụ kiện','phu-kien');

INSERT INTO products(category_id,name,price,stock,description,is_featured) VALUES
(1,'Áo thun Hưng Yến Basic',189000,40,'Áo thun cotton form rộng, mềm và dễ phối đồ. Phù hợp đi học, đi chơi và mặc hằng ngày.',1),
(1,'Sơ mi Oversize Daily',299000,25,'Sơ mi oversize trẻ trung, chất liệu nhẹ, phong cách tối giản.',1),
(1,'Hoodie HY Street',399000,20,'Hoodie form rộng với logo HY, phù hợp phong cách streetwear.',1),
(1,'Baby Tee Pink Mood',219000,35,'Baby tee ôm vừa, màu sắc nổi bật dành cho outfit năng động.',1),
(2,'Quần Jeans Wide Leg',449000,18,'Quần jeans ống rộng, cạp vừa, dễ phối với áo thun và sơ mi.',1),
(2,'Cargo Pants Everyday',429000,22,'Quần cargo nhiều túi, form thoải mái, phong cách street.',0),
(2,'Shorts Denim Blue',269000,30,'Quần short denim basic cho ngày hè.',0),
(3,'Chân váy chữ A',329000,20,'Chân váy chữ A trẻ trung, dễ kết hợp nhiều kiểu áo.',1),
(3,'Váy Baby Doll',379000,15,'Váy baby doll nhẹ nhàng, thiết kế trẻ trung.',0),
(4,'Túi Shoulder HY',259000,28,'Túi đeo vai nhỏ gọn, phù hợp outfit hằng ngày.',1),
(4,'Mũ lưỡi trai Logo HY',159000,45,'Mũ lưỡi trai basic với logo Hưng Yến.',0),
(4,'Tất cổ cao HY',79000,60,'Tất cotton mềm, co giãn tốt.',0);
