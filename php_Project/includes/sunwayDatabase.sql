create database if not exists `24152365`;
use `24152365`;

Create table users (
    id INT auto_increment primary key,
    FULL_name varchar(255) not null,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'admin') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

INSERT INTO categories (name) VALUES
('Beverages'),
('Snacks'),
('Main Course'),
('Bakery Items'),
('Fast Food'),
('Desserts'),
('Specials'),
('Vegan'),
('Non-Vegetarian'),
('Breakfast');


CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id INT,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_price INT,
    status ENUM('Pending', 'Preparing', 'Ready') DEFAULT 'Pending',
    pay_method ENUM('Cash', 'esewa') Default 'Cash',
    payment VARCHAR(20) DEFAULT 'Not Paid',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    item_id INT,
    quantity INT,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (item_id) REFERENCES menu_items(id)
);


CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_id INT,
    message TEXT,
    rating INT CHECK(rating BETWEEN 1 AND 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);
CREATE TABLE food_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    price_per_quantity DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    purchase_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (item_id) REFERENCES menu_items(id)
);


