SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS Admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,             
    admin_name VARCHAR(80) UNIQUE NOT NULL,                
    password VARCHAR(255) NOT NULL,                      
    email VARCHAR(100) UNIQUE NOT NULL,                  
    full_name VARCHAR(100) NULL,                         
    phone VARCHAR(20) NULL,                                  
    status ENUM('active','inactive') DEFAULT 'active',  
    last_login DATETIME NULL,                            
    last_ip VARCHAR(45) NULL,                            
    admin_agent TEXT NULL,                                                                     
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,        
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP                      
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Suppliers(
    supplier_id INT AUTO_INCREMENT PRIMARY KEY,
    product_type_id INT NOT NULL,
    supplier_phone VARCHAR(20),
    supplier_name VARCHAR(255) NOT NULL,
    supplier_address VARCHAR (255),
    supplier_email VARCHAR (100),
    payment_terms TEXT,
    status ENUM('active','paused','terminated') DEFAULT 'active',
    FOREIGN KEY (product_type_id) REFERENCES Product_types (product_type_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Product_types(
    product_type_id INT AUTO_INCREMENT PRIMARY KEY,
    type_name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT NULL,
    status ENUM ('active', 'inactive') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

INSERT INTO Product_types (type_name, description, status) VALUES
('bánh kẹo', 'đa dạng màu sắc và hương vị', 'active'),
('đồ uống', 'nhiều sản phẩm nước uống với nồng độ cồn, gas,... khác nhau', 'active'),
('gia vị', 'giúp món ăn bạn ngon hơn theo nhiều cách với nhiều kiểu chế biến', 'active'),
('đồ dùng', 'đồ gia dụng sinh hoạt hằng ngày', 'active'),
('rau củ', 'hàng tươi ngon, đảm bảo chất lượng', 'active'),
('thực phẩm', 'sạch, tươi, ngon, bổ dưỡng mỗi ngày', 'active'),
('trái cây', 'tùy theo mùa vụ và nguồn trồng mà hương vị có sự riêng biệt', 'active');

CREATE TABLE IF NOT EXISTS Products(
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR (100) NOT NULL,
    product_type_id INT,
    product_size VARCHAR (50),
    brand VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2) NOT NULL CHECK (price >= 0),
    quantity INT DEFAULT 0 CHECK (quantity >= 0),
    unit VARCHAR(50),
    image_url VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_type_id) REFERENCES Product_types (product_type_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Customers(
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_fullname VARCHAR(255) NOT NULL,
    customer_password VARCHAR (255) NOT NULL,
    customer_email VARCHAR(50) UNIQUE NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_address VARCHAR(100),
    last_login DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Cart(
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    status ENUM ('active', 'checked_out') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Cart_Items(
    c_item_id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1 CHECK (quantity >= 1),
    FOREIGN KEY (cart_id) REFERENCES Cart(cart_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE,
    UNIQUE (cart_id, product_id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Orders(
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    order_date DATE,
    order_total DECIMAL(10,2) DEFAULT 0,
    order_status ENUM('confirmed', 'pending', 'processing', 'delivered','completed', 'cancelled', 'returned', 'refunded') DEFAULT 'confirmed',
    recipient_name VARCHAR(255),
    recipient_phone VARCHAR(100),
    ship_address VARCHAR(100),
    ship_note TEXT,
    review TEXT,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Order_Items(
    o_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1 CHECK (quantity > 0),
    price DECIMAL(10,2) DEFAULT 0 CHECK (price >= 0),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(order_id) REFERENCES Orders(order_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(product_id) REFERENCES Products(product_id) ON DELETE CASCADE
) ENGINE=InnoDB;