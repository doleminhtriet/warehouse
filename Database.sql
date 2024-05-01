SELECT * FROM ecommerece.Category;

CREATE TABLE `Category` (
  `CatID` bigint NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(50) NOT NULL,
  `CategoryDescription` varchar(100) DEFAULT NULL,
  `CategoryImage` longblob,
  PRIMARY KEY (`CatID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `Product` (
  `ProductID` bigint NOT NULL AUTO_INCREMENT,
  `ProductName` varchar(50) NOT NULL,
  `ProductDescription` varchar(100) DEFAULT NULL,
  `CatID` bigint NOT NULL,
  `ProductPrice` decimal(10,2) NOT NULL,
  `ProductQTY` int DEFAULT NULL,
  `ProductImage` longblob,
  PRIMARY KEY (`ProductID`),
  KEY `CatID` (`CatID`),
  CONSTRAINT `Product_ibfk_1` FOREIGN KEY (`CatID`) REFERENCES `Category` (`CatID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Cart` (
  `CartID` int NOT NULL AUTO_INCREMENT,
  `ProducID` int NOT NULL,
  `IpAdd` varchar(250) NOT NULL,
  `UserID` int DEFAULT NULL,
  `CartQTY` int NOT NULL,
  PRIMARY KEY (`CartID`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=latin1;


select * from Cart

ALTER TABLE `Product`
MODIFY COLUMN `ProductName` VARCHAR(200) NOT NULL,
MODIFY COLUMN `ProductDescription` VARCHAR(200) DEFAULT NULL;


CREATE TABLE `CustomerInfo` (
  `UserId` int NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) NOT NULL,
  `Email` varchar(300) NOT NULL,
  `Password` varchar(300) NOT NULL,
  `Mobile` varchar(10) NOT NULL,
  `Address` varchar(300) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
select * from CustomerInfo


CREATE TABLE StockDetail(
    ProductID BIGINT NOT NULL,
    Total DECIMAL (10, 2) AS (SELECT SUM(ProductQTY * ProductPrice) FROM Product WHERE ProductID = Product.ProductID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);

CREATE TABLE Supplier(
	SupplierID BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    SupplierName VARCHAR(100),
    ContactName VARCHAR(100),
    Address VARCHAR(200),
    Phone VARCHAR(15)
);

CREATE TABLE `CustomerInfo` (
  `UserId` int NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) NOT NULL,
  `Email` varchar(300) NOT NULL,
  `Password` varchar(300) NOT NULL,
  `Mobile` varchar(10) NOT NULL,
  `Address` varchar(300) NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;


CREATE TABLE `OrderInfo` (
  `OrderId` int NOT NULL AUTO_INCREMENT,
  `UserId` int NOT NULL,
  `Address` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `State` varchar(255) NOT NULL,
  `Zip` int NOT NULL,
  `Cardname` varchar(255) NOT NULL,
  `Cardnumber` varchar(20) NOT NULL,
  `Expdate` varchar(255) NOT NULL,
  `ProdCount` int DEFAULT NULL,
  `TotalAmt` int DEFAULT NULL,
  `Cvv` int NOT NULL,
  PRIMARY KEY (`OrderId`),
  KEY `UserId` (`UserId`),
  CONSTRAINT `UserId` FOREIGN KEY (`UserId`) REFERENCES `CustomerInfo` (`UserId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

CREATE TABLE `OrderDetail` (
  `OrderDetailID` bigint NOT NULL AUTO_INCREMENT,
  `OrderId` INT NOT NULL,
  `ProductID` bigint NOT NULL,
  `OrderQTY` INT DEFAULT NULL,
  `Amt` DECIMAL(10, 2) DEFAULT NULL, -- Adjust precision and scale as needed
  PRIMARY KEY (`OrderDetailID`),
  KEY `OrderDetail_OrderId` (`OrderId`), -- Unique name for the foreign key constraint
  KEY `OrderDetail_ProductID` (`ProductID`), -- Unique name for the foreign key constraint
  CONSTRAINT `FK_OrderDetail_OrderId` FOREIGN KEY (`OrderId`) REFERENCES `OrderInfo` (`OrderId`) ON UPDATE CASCADE,
  CONSTRAINT `FK_OrderDetail_ProductID` FOREIGN KEY (`ProductID`) REFERENCES `Product` (`ProductID`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;

CREATE TABLE StockIn (
    StockId INT AUTO_INCREMENT PRIMARY KEY,
    UserID int,
    SupplierID BIGINT,
    StockDate DATE,
    StockNote TEXT,
    StockStatus VARCHAR(50),
    KEY `StockIn_UserId` (`UserID`),
    KEY `StockIn_SupplierId` (`SupplierID`),
    CONSTRAINT `FK_StockIn_UserID` FOREIGN KEY (`UserID`) REFERENCES `CustomerInfo` (`UserId`),
    CONSTRAINT `FK_StockIn_SupplierID` FOREIGN KEY (`SupplierID`) REFERENCES `Supplier` (`SupplierID`)
);


CREATE TABLE StockInDetail (
    StockInDetailId BIGINT AUTO_INCREMENT PRIMARY KEY,
    StockInId INT,
    ProductID VARCHAR(50),
    Quantity INT,
    Price DECIMAL(10,2),
    Total DECIMAL(10,2),
    FOREIGN KEY (StockInId) add_stockInREFERENCES StockIn(StockId)
);

CREATE VIEW V_StockInAll AS
Select StockId, FullName, StockDate, StockStatus, SupplierName, sum(Quantity*Quantity) as TotalAmt
From StockIn inner join CustomerInfo on StockIn.UserID = CustomerInfo.UserId
			 inner join Supplier on Supplier.SupplierID = StockIn.SupplierID
             inner join StockInDetail on StockInDetail.StockInId = StockIn.StockId
group by StockId, FullName, StockDate, StockStatus, SupplierName


SELECT a.ProductID,a.ProductName,a.ProductPrice,a.ProductImage, b.CartID, b.CartQTY 
FROM Product a,Cart b WHERE a.ProductID=b.ProductID 
select * from CustomerInfo
select * from OrderInfo
select * from StockInDetail
select * from Supplier
select * from Product
select * from StockInDetail
SELECT * FROM Supplier

SELECT * FROM CustomerInfo WHERE Email = 'minh@yahoo.com' AND Password = '1111111111'