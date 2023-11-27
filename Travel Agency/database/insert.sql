-- Customer table
INSERT INTO Customer (FirstName, LastName, Gender) VALUES
('John', 'Doe', 'M'),
('Jane', 'Smith', 'F'),
('Mike', 'Johnson', 'M'),
('Emily', 'Williams', 'F'),
('Chris', 'Brown', 'M'),
('Jessica', 'Jones', 'F'),
('David', 'Clark', 'M'),
('Sophia', 'Miller', 'F'),
('Daniel', 'Moore', 'M'),
('Olivia', 'Davis', 'F');

-- TravelAgents_Assist table
INSERT INTO TravelAgents_Assist (AgentID, FirstName, LastName, Customer_ID) VALUES
(1, 'John', 'Smith', 1),
(2, 'Alice', 'Johnson', 2),
(3, 'Michael', 'Williams', 3),
(4, 'Emily', 'Jones', 4),
(5, 'David', 'Taylor', 5),
(6, 'Sarah', 'Miller', 6),
(7, 'Robert', 'Brown', 7),
(8, 'Jennifer', 'Davis', 8),
(9, 'Matthew', 'Moore', 9),
(10, 'Emma', 'Anderson', 10),
(11, 'Daniel', 'Martinez', 1),
(12, 'Olivia', 'Garcia', 2),
(13, 'William', 'Rodriguez', 3),
(14, 'Sophia', 'Lopez', 4),
(15, 'James', 'Martinez', 5),
(16, 'Grace', 'Clark', 6),
(17, 'Benjamin', 'Lewis', 7),
(18, 'Ava', 'Lee', 8),
(19, 'Logan', 'Hill', 9),
(20, 'Ella', 'Ward', 10);


-- Passport table
INSERT INTO Passport (PassportNumber, Customer_ID) VALUES
('A123456', 1),
('B789012', 2),
('C345678', 3),
('D901234', 4),
('E567890', 5),
('F123890', 6),
('G098765', 7),
('H543210', 8),
('I876543', 9),
('J210987', 10);

-- Military table
INSERT INTO Military (Customer_ID, MilitaryID) VALUES
(1, 123),
(3, 456),
(5, 789),
(7, 987),
(9, 654);

-- LoyaltyStatusBenefits table
INSERT INTO LoyaltyStatusBenefits (LoyaltyStatus, LoyaltyBenefits) VALUES
('Gold', 'Free upgrades, priority booking'),
('Silver', 'Discounts on bookings'),
('Bronze', 'Earn points for every booking');

-- Non_Military table
INSERT INTO Non_Military (Customer_ID, LoyaltyStatus, LoyaltyRegistrationDate) VALUES
(2, 'Gold', '2023-01-01'),
(4, 'Silver', '2023-02-15'),
(6, 'Bronze', '2023-03-20'),
(8, 'Gold', '2023-04-10'),
(10, 'Silver', '2023-05-05');

-- Supervises table
INSERT INTO Supervises (Employee_AgentID, Supervisor_AgentID) VALUES
(2, 1),
(4, 3),
(6, 5),
(8, 7),
(10, 9);

-- Hotel table
INSERT INTO Hotel (HotelName, HotelLocation, Rating) VALUES
('Grand Hotel', 'City1', 4.5),
('Luxury Inn', 'City2', 3.8),
('Comfort Suites', 'City3', 4.2),
('Oceanview Resort', 'City4', 4.7),
('Mountain Retreat', 'City5', 4.0);

-- Discount table
INSERT INTO Discount (Customer_ID, Hotel_ID, Percentage) VALUES
(1, 1, 10),
(3, 2, 15),
(5, 3, 20),
(7, 4, 12),
(9, 5, 18);

-- Has_Booking table
INSERT INTO Has_Booking (BookingID, BookingData, PaymentMethod, AmountPaid, CustomerID) VALUES
(1, '2023-01-10', 'Credit Card', 300.0, 1),
(2, '2023-02-20', 'PayPal', 250.0, 2),
(3, '2023-03-15', 'Cash', 400.0, 3),
(4, '2023-04-05', 'Credit Card', 350.0, 4),
(5, '2023-05-25', 'PayPal', 500.0, 5);

-- TripPackage table
INSERT INTO TripPackage (DepartureDate, ReturnDate) VALUES
('2023-11-27', '2023-12-10'),
('2023-11-28', '2023-12-25'),
('2023-11-29', '2023-12-20'),
('2023-11-30', '2023-12-15'),
('2023-12-01', '2023-12-30');

-- Provide_Hotel table
INSERT INTO Provide_Hotel (TripPackID, Hotel_ID, SpecialRequest) VALUES
(1, 1, 'Ocean view room'),
(2, 2, 'King-size bed'),
(3, 3, 'Wheelchair accessible'),
(4, 4, 'Mountain view suite'),
(5, 5, 'Pet-friendly room');

-- Destination table
INSERT INTO Destination (DestinationID, Reviews, Country, City, LocationName) VALUES
(1, 'Beautiful beaches', 'Maldives', 'Maafushi', 'Beach Resort'),
(2, 'Scenic landscapes', 'Switzerland', 'Zermatt', 'Mountain Retreat'),
(3, 'Vibrant nightlife', 'Spain', 'Barcelona', 'City Center'),
(4, 'Relaxing atmosphere', 'Thailand', 'Phuket', 'Spa Resort'),
(5, 'Adventure activities', 'New Zealand', 'Queenstown', 'Adventure Zone');

-- Trip_Package_Has_Destination table
INSERT INTO Trip_Package_Has_Destination (TripPackID, DestinationID) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- Transportation table
INSERT INTO Transportation (TranspID, CompanyName, TicketType) VALUES
(1, 'Airline1', 'Economy'),
(2, 'TrainCo', 'First Class'),
(3, 'CruiseLine', 'Standard'),
(4, 'BusTravel', 'Regular'),
(5, 'CarRentals', 'Luxury');

-- TripPackage_Provide_Hotel table
INSERT INTO TripPackage_Provide_Hotel (TripPackID, Hotel_ID, SpecialRequest) VALUES
(1, 1, 'Ocean view room'),
(2, 2, 'King-size bed'),
(3, 3, 'Wheelchair accessible'),
(4, 4, 'Mountain view suite'),
(5, 5, 'Pet-friendly room');

-- Trip_Package_Includes_Transportation table
INSERT INTO Trip_Package_Includes_Transportation (TripPackID, TranspID) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- Trip_Package_Associate_Booking table
INSERT INTO Trip_Package_Associate_Booking (TripPackID, BookingID) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- TravelAgent_That_Assists_Customer_Offers table
INSERT INTO TravelAgent_That_Assists_Customer_Offers (AgentID, CustomerID, TripPackID) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 1),
(7, 7, 2),
(8, 8, 3),
(9, 9, 4),
(10, 10, 5),
(11, 1, 1),
(11, 2, 2),
(11, 3, 3),
(11, 4, 4),
(11, 5, 5),
(11, 6, 1),
(11, 7, 2),
(11, 8, 3),
(11, 9, 4),
(11, 10, 5);

-- Hotel_Room_In_A_Hotel table
INSERT INTO Hotel_Room_In_A_Hotel (HotelID, RNumber, Type) VALUES
(1, 101, 'Single'),
(1, 102, 'Double'),
(2, 201, 'Suite'),
(2, 202, 'Standard'),
(3, 301, 'King'),
(3, 302, 'Queen'),
(4, 401, 'Deluxe'),
(4, 402, 'Executive'),
(5, 501, 'Family'),
(5, 502, 'Presidential');
