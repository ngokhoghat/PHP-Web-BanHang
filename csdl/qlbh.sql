	DROP DATABASE IF exists Ban_Sach;

	CREATE DATABASE IF NOT exists Ban_Sach CHARACTER SET utf8 collate utf8_unicode_ci;
	USE Ban_Sach;

	CREATE TABLE  IF NOT exists category
	(
		id int PRIMARY KEY AUTO_INCREMENT,
		name varchar(100) NOT NULL UNIQUE,
		status tinyint(1) DEFAULT '0' Comment '0 là hiện 1 là ẩn',
		parent_id int DEFAULT '0',
		ordering int DEFAULT '0'
	);

	CREATE TABLE  IF NOT exists tacgia
	(
		id int PRIMARY KEY AUTO_INCREMENT,
		name varchar(100) not null,
		tieu_su text,
		hinh_anh varchar(200),
		email varchar(100),
		phone varchar(100),
		address varchar(200)
	);

	CREATE TABLE  IF NOT exists nxb
	(
		id int PRIMARY KEY AUTO_INCREMENT,
		name varchar(100) not null,
		email varchar(100),
		phone varchar(100),
		address varchar(200)
	);


	CREATE TABLE IF NOT exists product
	(
		id int PRIMARY KEY AUTO_INCREMENT,
		name varchar(150) NOT NULL,
		price float DEFAULT '0',
		sale_price float  DEFAULT '0',
		view int DEFAULT '0',
		mota text,
		status tinyint DEFAULT '0' COMMENT '0 là hiện, 1 là ẩn, 2 là sản phẩm mới',
		anh_bia varchar(200),
		anh_phu text DEFAULT '',
		created timestamp DEFAULT CURRENT_TIMESTAMP,
		updated timestamp DEFAULT CURRENT_TIMESTAMP,
		quantity int DEFAULT '0',
		lang varchar(50),
		cate_id int NOT NULL,
		tacgia_id int NOT NULL,
		nxb_id int NOT NULL,
		FOREIGN key (cate_id) REFERENCES category(id),
		FOREIGN key (tacgia_id) REFERENCES tacgia(id),
		FOREIGN key (nxb_id) REFERENCES nxb(id)
	);

	CREATE TABLE IF NOT exists account
	(
		id int PRIMARY key AUTO_INCREMENT,
		name varchar(50) NOT NULL,
		email varchar(50) NOT NULL UNIQUE,
		phone varchar(11),
		password varchar(100),
		address varchar(100) NULL,
		image varchar(100),
		sex tinyint COMMENT '0 là nữ 1 là nam 2 là khác',
		birthday date,
		type tinyint DEFAULT '0' COMMENT '0 là khách hàng, 1 là quản trị viên',
		created timestamp DEFAULT CURRENT_TIMESTAMP,
		updated timestamp DEFAULT CURRENT_TIMESTAMP
	);

	CREATE TABLE IF NOT exists payment
	(
		id int PRIMARY key AUTO_INCREMENT,
		name int NOT NULL
	);


	CREATE TABLE IF NOT exists orders
	(
		id int PRIMARY key AUTO_INCREMENT,
		acc_id int,
		payment_id int,
		created timestamp DEFAULT CURRENT_TIMESTAMP,
		deliveri timestamp,
		name varchar(150),
		phone varchar(50),
		address varchar(150),
		amount float DEFAULT '0',
		status tinyint DEFAULT '0' COMMENT '0 là chưa duyệt, 1 đang giao hàng, 2 là Hủy, 3 là đã giao hàng',
		FOREIGN KEY (acc_id) REFERENCES account(id),
		FOREIGN KEY (payment_id) REFERENCES payment(id)
	);

	CREATE TABLE IF NOT exists orders_detail
	(
		orders_id int NOT NULL,
		prod_id int NOT NULL,
		quantity int NOT NULL,
		price float NOT NULL,
		PRIMARY KEY(orders_id,prod_id),
		FOREIGN KEY (orders_id) REFERENCES orders(id),
		FOREIGN KEY (prod_id) REFERENCES product(id)
	);

	CREATE TABLE IF NOT exists comments (
		id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
		name varchar(100) NULL,
		email varchar(100) NULL,
		content text,
		acc_id int NULL DEFAULT '0',
		proc_id int NOT NULL,
		parent_id int DEFAULT '0',
		created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		FOREIGN KEY (proc_id) REFERENCES product(id),
		FOREIGN KEY (acc_id) REFERENCES account(id)
	);

	CREATE TABLE IF NOT exists news (
		id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
		author int,
		title varchar(200),
		content text,	
		ordering int,	
		status tinyint(1) DEFAULT '0' Comment '0 là hiện, 1 là ẩn',
		created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		FOREIGN KEY (author) REFERENCES account(id)
	);

	CREATE TABLE IF NOT exists image (
		id int AUTO_INCREMENT PRIMARY KEY,
		title varchar(200),
		content text,
		img_link varchar(200) not null,
		ordering tinyint DEFAULT '0',
		type tinyint DEFAULT '0' COMMENT "0 là slide, 1 là banner, 2 là post",
		status tinyint DEFAULT '0'
	);

	INSERT INTO image(title, content, img_link,ordering, type, status)
	VALUES
	('Free shipping item', 'For all orders over $500', 'service-1.png',3, 3, 0),
	('Money back guarante', '100% money back guarante', 'service-2.png', 2,3, 0),
	('Cash on delivery', 'Lorem ipsum dolor amet', 'service-3.png', 1,3, 0),
	('', '', '20.jpg',4, 3, 0),
	('G. Meyer Books & Spiritual Traveler Press', '', '30.jpg',0, 1, 0),
	('G. Meyer Books & Spiritual Traveler Press', '', '5.jpg',0, 1, 0),
	('G. Meyer Books & Spiritual Traveler Press', 'Sale up to 30% off', '5.jpg',0, 1, 0),
	('G. Meyer Books & Spiritual Traveler Press', '', '33.jpg',0, 1, 0),
	('G. Meyer Books & Spiritual Traveler Press', '', '32.jpg',0, 1, 0),
	('G. Meyer Books & Spiritual Traveler Press', '', '31.jpg',0, 1, 0),
	('Giảm giá đến 30%', 'Sale up to 30% off', '2.jpg',0, 0, 0);

	-- Insert rows into table 'category'
	INSERT INTO category
	( name, status, parent_id, ordering)
	VALUES
	( 'Sách văn học', 0,0, 0),
	( 'Thơ', 0,1, 0),
	( 'Truyện cổ tích - ngụ ngôn', 0,1, 0),
	( 'Truyện cười', 0,1, 0),
	( 'Truyện ngắn', 0,1, 0),
	( 'Ca dao tục ngữ', 0,1, 0),
	( 'Sách kinh tế', 0,0, 0),
	( 'Bài học kinh doanh', 0,7, 0),
	( 'Sách doanh nhân', 0,7, 0),
	( 'Sách khởi nghiệp', 0,7, 0),
	( 'Sách kinh tế học', 0,7, 0),
	( 'Sách kĩ năng làm việc', 0,7, 0),
	( 'Truyện - tranh', 0,0, 0),
	( 'Naruto', 0,13, 0),
	( 'One Punch Man', 0,13, 0),
	( 'Áo giáp vàng', 0,13, 0),
	( 'Đô rê mon', 0,13, 0),
	( 'truyện ngôn tình', 0,13, 0),
	( 'Tiểu thuyết', 0,0, 0),
	( 'trong nước', 0,19, 0),
	( 'ngoài nước', 0,19, 0);

	Insert into tacgia(name, tieu_su, hinh_anh,email, phone, address)
	VALUES
	('Nguyễn du','', '1.jpg','','', ''),
	('Bửu ý', '', '1.jpg','','', ''),
	('Hồ anh thái ', '','1.jpg','', '', ''),
	('Nguyễn tuấn anh ', '','1.jpg','', '', '');

	Insert into nxb(name, email, phone, address)
	VALUES
	('NXB kim đồng', '', '', ''),
	('NXB tuổi trẻ', '', '', ''),
	('NXB báo lao động ', '', '', ''),
	('NXB thành công', '', '', '');

	INSERT INTO product(name,price,sale_price,mota, status,anh_bia,lang,quantity,cate_id, tacgia_id, nxb_id)
	VALUES
	('ISRAVEL',100000, 90000,'', 0,'1.jpg','Tiếng Nhật',200,1,1,2),
	('BLUE LIKE',100000, 70000,'', 0,'2.jpg','Tiếng Nhật',200,2,1,2),
	('Delirium',100000, 80000,'', 0,'3.jpg','Tiếng Nhật',200,3,1,2),
	('Costa Rica',100000, 96000,'', 0,'4.jpg','Tiếng Nhật',200,4,1,2),
	('Princesas',100000, 0,'', 0,'5.jpg','Tiếng Nhật',200,5,1,2),
	('Conan 95',100000, 0,'', 0,'6.jpg','Tiếng Nhật',200,6,1,2),
	('Inspiration speaks',100000, 0,'', 0,'7.jpg','Tiếng Nhật',200,7,1,2),
	('Emprire',100000, 0,'', 0,'8.jpg','Tiếng Nhật',200,1,1,2),
	('Adoress',100000, 0,'', 0,'9.jpg','Tiếng Nhật',200,2,1,2),
	('Harryposter',100000, 0,'', 0,'10.jpg','Tiếng Nhật',200,3,1,2),
	('Shaping humanity',100000, 0,'', 0,'11.jpg','Tiếng Nhật',200,4,1,2),
	('A Bigger Brize',100000, 0,'', 0,'12.jpg','Tiếng Nhật',200,5,1,2),
	('One a milion',100000, 0,'', 0,'13.jpg','Tiếng Nhật',200,6,1,2),
	('Tim oBrien',100000, 0,'', 0,'14.jpg','Tiếng Nhật',200,7,1,2),
	('Pigeon Blood Red',100000, 0,'', 0,'15.jpg','Tiếng Nhật',200,8,1,2),
	('ISRAVEL',100000, 0,'', 0,'16.jpg','Tiếng Nhật',200,9,1,2),
	('Delirium ',100000, 0,'', 0,'17.jpg','Tiếng Nhật',200,10,1,2),
	('Inspiration speaks ',100000, 0,'', 0,'18.jpg','Tiếng Nhật',200,11,1,2),
	('Emprire ',100000, 0,'', 2,'19.jpg','Tiếng Nhật',200,12,1,2),
	(' Adoress',100000, 0,'', 2,'20.jpg','Tiếng Nhật',200,13,1,2),
	('ISRAVEL ',100000, 0,'', 2,'21.jpg','Tiếng Nhật',200,14,1,2),
	(' Inspiration speaks',100000, 0,'', 2,'22.jpg','Tiếng Nhật',200,15,1,2),
	(' Delirium',100000, 0,'', 2,'23.jpg','Tiếng Nhật',200,16,1,2),
	(' A Bigger Brize',100000, 0,'', 2,'24.jpg','Tiếng Nhật',200,17,1,2),
	(' Emprire',100000, 0,'', 2,'25.jpg','Tiếng Nhật',200,18,1,2),
	('Inspiration ',100000, 0,'', 2,'26.jpg','Tiếng Nhật',200,3,1,2),
	(' BLUE LIKE',100000, 0,'', 2,'27.jpg','Tiếng Nhật',200,4,1,2),
	('Princesas ',100000, 0,'', 2,'28.jpg','Tiếng Nhật',200,5,1,2),
	(' Pigeon Blood Red',100000, 0,'', 2,'29.jpg','Tiếng Nhật',200,6,1,2),
	('Adoressa ',100000, 0,'', 2,'30.jpg','Tiếng Nhật',200,7,1,2);


	Insert into account(name,password,phone,address,birthday,email,type, image)
	VALUES 
	('Đinh Thế Ngọc', MD5('admin'), '0394082387', 'Vĩnh Ngọc, Đông Anh, Hà Nội','1997-09-24', 'admin',1, '1.jpg');

	INSERT INTO news (author, title, content, ordering, status) 
	VALUES 
	(1, 'Khuyến mãi 20% cho các mẫu sách cũ', 'Nhân ngày mùng 8/3 shop khuyễn mãi 20% các mặt hàng', '0', '0'),
	(1, 'Khuyến mãi tưng bừng', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis praesentium illum vitae officia repudiandae, totam quibusdam cum. Eius blanditiis quos, fuga molestias cumque incidunt harum repellat dolor atque maxime excepturi!', '0', '0');
