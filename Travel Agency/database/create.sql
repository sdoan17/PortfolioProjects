CREATE TABLE Customer (
    Customer_ID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(30),
    LastName VARCHAR(30),
    Gender CHAR(1)
);

CREATE TABLE TravelAgents_Assist (
    AgentID INT PRIMARY KEY,
    FirstName VARCHAR(30),
    LastName VARCHAR(30),
    Customer_ID INT NOT NULL,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) 
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE Passport (
    PassportNumber VARCHAR(10),
    Customer_ID INT,
    PRIMARY KEY (PassportNumber, Customer_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Military (
    Customer_ID INT, 
    MilitaryID INT UNIQUE, 
    PRIMARY KEY (Customer_ID), 
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);

CREATE TABLE LoyaltyStatusBenefits (
    LoyaltyStatus VARCHAR(50),
    LoyaltyBenefits VARCHAR(200),
    PRIMARY KEY (LoyaltyStatus)
);

CREATE TABLE Non_Military (
    Customer_ID INT PRIMARY KEY,
    LoyaltyStatus VARCHAR(50), 
    LoyaltyRegistrationDate DATE,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (LoyaltyStatus) REFERENCES LoyaltyStatusBenefits(LoyaltyStatus)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE Supervises (
    Employee_AgentID INT,
    Supervisor_AgentID INT,
    PRIMARY KEY (Employee_AgentID),
    FOREIGN KEY (Employee_AgentID) REFERENCES TravelAgents_Assist(AgentID)
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    FOREIGN KEY (Supervisor_AgentID) REFERENCES TravelAgents_Assist(AgentID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


Create Table Hotel(
    HotelID INT AUTO_INCREMENT Primary KEY,
    HotelName varchar(100),
    HotelLocation varchar(100),
    Rating REAL
);

CREATE TABLE Discount (
    Customer_ID INT,
    Hotel_ID INT,
    Percentage INT,
    PRIMARY KEY (Customer_ID, Hotel_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Military (Customer_ID) ON DELETE CASCADE,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel (HotelID) ON DELETE CASCADE
);


CREATE TABLE Has_Booking(
	BookingID INT not null,
    BookingData Date,
    PaymentMethod varchar(20),
    AmountPaid Float,
    CustomerID Integer not null,
    Primary Key (BookingID, CustomerID),
    Foreign Key (CustomerID) references Customer(Customer_ID) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE TripPackage (
    TripPackID INT AUTO_INCREMENT PRIMARY KEY,
    DepartureDate DATE,
    ReturnDate DATE
);


CREATE TABLE Provide_Hotel (
    TripPackID INT,
    Hotel_ID INT,
    SpecialRequest VARCHAR(255),
    PRIMARY KEY (TripPackID, Hotel_ID),
    FOREIGN KEY (TripPackID) REFERENCES TripPackage(TripPackID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(HotelID) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Destination (
    DestinationID INT,
    Reviews VARCHAR(255),
    Country VARCHAR(20),
    City VARCHAR(20),
    LocationName VARCHAR(20),
    PRIMARY KEY(DestinationID)
);


CREATE TABLE Trip_Package_Has_Destination (
    TripPackID INTEGER,
    DestinationID INTEGER,
    PRIMARY KEY(TripPackID, DestinationID),
    FOREIGN KEY(TripPackID) REFERENCES TripPackage(TripPackID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY(DestinationID) REFERENCES Destination(DestinationID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Transportation (
    TranspID INT,
    CompanyName VARCHAR(20),
    TicketType VARCHAR(20),
    PRIMARY KEY(TranspID)
);

CREATE TABLE TripPackage_Provide_Hotel (
    TripPackID INT,
    Hotel_ID INT,
    SpecialRequest VARCHAR(255),
    PRIMARY KEY (TripPackID, Hotel_ID),
    FOREIGN KEY (TripPackID) REFERENCES TripPackage (TripPackID)
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel (HotelID)
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);

CREATE TABLE Trip_Package_Includes_Transportation (
    TripPackID INTEGER,
    TranspID INTEGER,
    PRIMARY KEY (TranspID, TripPackID),
    FOREIGN KEY (TripPackID) REFERENCES TripPackage (TripPackID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (TranspID) REFERENCES Transportation (TranspID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Trip_Package_Associate_Booking (
    TripPackID INTEGER,
    BookingID INTEGER,
    PRIMARY KEY (TripPackID, BookingID),
    FOREIGN KEY (TripPackID) REFERENCES TripPackage(TripPackID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (BookingID) REFERENCES Has_Booking(BookingID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE TravelAgent_That_Assists_Customer_Offers (
    AgentID INTEGER,
    CustomerID INTEGER,
    TripPackID INTEGER,
    PRIMARY KEY (AgentID, CustomerID, TripPackID),
    FOREIGN KEY (AgentID) REFERENCES TravelAgents_Assist (AgentID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (CustomerID) REFERENCES Customer (Customer_ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (TripPackID) REFERENCES TripPackage (TripPackID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE Hotel_Room_In_A_Hotel (
    HotelID INT,
    RNumber INT,
    Type VARCHAR(20),
    PRIMARY KEY (HotelID, RNumber),
    FOREIGN KEY (HotelID) REFERENCES Hotel(HotelID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
