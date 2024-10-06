`posts``posts`-- creating admin table

CREATE DATABASE pharmacy;

USE pharmacy; 

CREATE TABLE ADMIN  (
  id INT PRIMARY KEY,
  username VARCHAR(20), 
  PASSWORD VARCHAR(10) ,
  repassword VARCHAR(100),
  address VARCHAR(20),
  email VARCHAR(100) 
);

-- create table useR
CREATE TABLE USER (
	id INT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(50),
	PASSWORD VARCHAR(50),
	address VARCHAR(50),
	email VARCHAR(100),
	contact VARCHAR(10)
);

-- create table medicine purchase
CREATE TABLE purchase  (
  s_name VARCHAR(20),
  s_id INT,
  address VARCHAR (20),
  contact NVARCHAR (10),
  m_id INT PRIMARY KEY,
  m_name VARCHAR(20), 
  batch_no INT , 
  mft_date DATE ,
  exp_date DATE,
  price INT,
  qty INT,
  descript VARCHAR(100) ,
  p_date DATE ,
  image BLOB
);

CREATE TABLE TRANSACTION  (
  t_id INT PRIMARY KEY AUTO_INCREMENT,
  u_id INT,
  STATUS VARCHAR(50),
  m_id INT, 
  total_price INT,
  t_date DATE,
  quty INT,
  approved BOOLEAN DEFAULT 0
);


-- inserting into purchase 
INSERT INTO  purchase VALUES('Buddha Pharma',1,'Butwal','9948724242',1,'Sinex',0112,'2020-10-2','2024-10-2',3000,10,'for fever or cold','2022-10-9');
INSERT INTO  purchase VALUES('Kiran Pharma',2,'Andheri East','9823387894',2,'Calcium',0112,'2020-06-2','2024-06-2',2500,10,'for strong bone','2021-10-2');
INSERT INTO  purchase VALUES('Sam Pharma',3,'New Road','987654323',3,'Metfor',1204,'2021-10-2','2025-10-2',6200,10,'for sugar control','2023-2-6');
INSERT INTO  purchase VALUES('Gita Pharma',4,'Ratnapark','9876754325',4,'Detol',1212,'2020-04-25','2023-10-2',1500,10,'for bacterial infection','2022-5-2');
INSERT INTO  purchase VALUES('Buddha Pharma',1,'Butwal','9948724242',5,'Pudinhara',0223,'2020-12-2','2024-12-2',3000,10,'for diarrhoea','2023-1-23');
INSERT INTO  purchase VALUES('Kiran Pharma',2,'Andheri East','9823387894',6,'Paracetamol',0131,'2022-10-2','2024-10-2',100,10,'for fever','2022-6-22');
INSERT INTO  purchase VALUES('Gita Pharma',4,'Ratnapark','9876754325',7,'Repace',0440,'2020-10-12','2024-10-12',400,10,'for diabaties','2021-9-23');
INSERT INTO  purchase VALUES('Prashant Pharma',5,'Wotu','9857485634',8,'Nesboring',2204,'2020-10-2','2024-10-2',300, 10,'for worms','2022-4-29');
INSERT INTO  purchase VALUES('Hari Pharma',6,'JhoChe','9856378743',9,'Ibuprofen',0946,'2020-12-2','2024-12-2',500,10,'for sore throat','2022-7-14');

-- creating table records
-- CREATE TABLE records  (
--   pdate VARCHAR(10),
--   p_id INT PRIMARY KEY,
--   p_name VARCHAR(20), 
--   m_name VARCHAR(20), 
--   contact NVARCHAR (10) ,
--   price INT,
--   qty INT
-- );

-- inserting into records
-- INSERT INTO  records VALUES('2022-12-20',1,'ram','sinex',9822046999,3000,1);
-- INSERT INTO  records VALUES('2023-01-23',2,'sam','calcium',9876767654,2500,1);
-- INSERT INTO  records VALUES('2023-02-18',3,'hari','metfor',9876754345,6200,1);
-- INSERT INTO  records VALUES('2023-02-19',4,'sita','pudinhara',9878878667,3000,2);
-- INSERT INTO  records VALUES('2024-03-17',5,'gita','detol',9878987643,1500,3);
-- INSERT INTO  records VALUES('2022-03-28',6,'rita','paracetamol',9833089867,100,8);
-- INSERT INTO  records VALUES('2022-04-01',7,'priya','repace',9811004788,400,2);
-- INSERT INTO  records VALUES('2022-04-9',8,'shreeya','polysporing',9801736655,300,3);
-- INSERT INTO  records VALUES('2022-04-25',9,'mohan','Ibuprofen',9865654345,500,1);
-- INSERT INTO  records VALUES('2022-05-05',10,'sohan','eye drop',9876787654,600,4);


-- creating table suppliers
CREATE TABLE suppliers  (
  s_id INT PRIMARY KEY,
  s_name VARCHAR(20), 
  email VARCHAR(20), 
  contact NVARCHAR (10) ,
  address VARCHAR(20)
);

INSERT INTO `suppliers` (`s_id`, `s_name`, `email`, `contact`, `address`) VALUES
(1, 'Buddha Pharma', 'buddha@gmail.com', '9948724242', 'Butwal'),
(2, 'Ktm Pharma', 'ktm@gmail.com', '9875456787', 'Kathmandu'),
(3, 'Kiran Pharma', 'kiranpharma@gmail.com', '9823387894', 'Andheri East'),
(4, 'Ram Pharma', 'Ram@gmail.com', '9867654543', 'Lagan'),
(5, 'Sam Pharma', 'Sam@gmail.com', '987654323', 'New Road'),
(6, 'Hari Pharma', 'Hari@gamil.com', '9856378743', 'JhoChe'),
(7, 'Sita Pharma', 'Sita@gmail.com', '9867564534', 'Teku'),
(8, 'Gita Pharma', 'Gita@gmail.com', '9876754325', 'Ratnapark'),
(9, 'Prashant Pharma', 'Prashant@gmail.com', '9857485634', 'Wotu'),
(10, 'Pandu Pharma', 'Pandu@gmail.com', '9876756453', 'Wonde')