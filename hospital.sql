DROP TABLE Patient CASCADE CONSTRAINTS;
CREATE TABLE Patient(
	id INTEGER PRIMARY KEY,
	care_card_num CHAR(50) NOT NULL UNIQUE,
	name CHAR(50) NOT NULL,
	age INTEGER,
	address CHAR(50) NOT NULL,
	phone CHAR(50) NOT NULL,
	emergency_contact_num CHAR(50) NOT NULL,
	UNIQUE(name, phone));
    
INSERT INTO Patient
VALUES (100, '9999 212 909', 'John Hanks', 41, '1234 Robson St, Vancouver, BC V7Y 0A2', '778 909 1232',
'604 211 2211');
INSERT INTO Patient
VALUES (101, '9000 788 500', 'Emily Brown', 61, '1000 Mathers Ave, West Vancouver, BC V7V 2G7', '778
398 2233', '778 888 3910');
INSERT INTO Patient
VALUES (102, '9899 255 444', 'Tommy Lee', 33, '6400 Hawke Ave, Vancouver, BC V6R 2C9', '778 556
0000', '604 234 9190');
INSERT INTO Patient
VALUES (103, '9989 299 144', 'Michelle Smith', 29, '1011 Richards St, Vancouver, BC V7B 0A2', '604 123
5577', '604 778 2332');
INSERT INTO Patient
VALUES (104, '9123 098 230', 'Jill Garcia', 25, '5000 Main St, Vancouver, BC V6B 1A9', '778 387 5321',
'604 239 8109');
INSERT INTO Patient
VALUES (105, '8123 098 231', 'Tommy Haverford', 91, '5010 Science St, Pawnee, BC V9X 1C7', '778 912 0012',
'604 244 4001');
INSERT INTO Patient
VALUES (106, '2123 098 232', 'Kevin Malone', 78, '4300 Happy St, Scranton, BC V2X 2C2', '778 212 2013',
'604 254 5505');
INSERT INTO Patient
VALUES (107, '9323 098 233', 'Andy Bernard', 51, '433 Pleasant St, Scranton, BC V0X 0X1', '604 312 3014',
'604 353 3535');
INSERT INTO Patient
VALUES (108, '6126 698 261', 'Kelly Kapoor', 40, '890 Business St, Maple Ridge, BC V3X 3C0', '778 662 6613',
'604 654 6505');
INSERT INTO Patient
VALUES (109, '5123 598 535', 'Pamala Beesley', 91, '9123 Park St, Victoria, BC V2P 2P3', '778 222 3813',
'604 854 5885');
INSERT INTO Patient
VALUES (110, '6663 698 535', 'Jim Halpert', 55, '555 Beach St, Naniamo, BC V3C 3C3', '778 555 8818',
'604 774 5875');
    
DROP TABLE Disease CASCADE CONSTRAINTS;
CREATE TABLE Disease(name CHAR(50) PRIMARY KEY);

INSERT INTO Disease VALUES ('Alzheimers Disease');
INSERT INTO Disease VALUES ('Type I Diabetes');
INSERT INTO Disease VALUES ('Cardiovascular Disease');
INSERT INTO Disease VALUES ('Liver Cancer');
INSERT INTO Disease VALUES ('Chickenpox');
INSERT INTO Disease VALUES ('Mental Illness');
INSERT INTO Disease VALUES ('Liver Cancer Stage 2');
INSERT INTO Disease VALUES ('Seasonal Flu');
INSERT INTO Disease VALUES ('ADHD');
INSERT INTO Disease VALUES ('Autism');
    
DROP TABLE Has_Disease CASCADE CONSTRAINTS;
CREATE TABLE Has_Disease(
	disease_name CHAR(50),
	cured CHAR(1) NOT NULL,
	patient_id INTEGER,
	PRIMARY KEY(disease_name, patient_id),
	FOREIGN KEY(patient_id) REFERENCES Patient(id) ON DELETE CASCADE,
	FOREIGN KEY(disease_name) REFERENCES Disease(name) ON DELETE CASCADE
	);

INSERT INTO Has_Disease VALUES('Liver Cancer', '0', 100);
INSERT INTO Has_Disease VALUES('Cardiovascular Disease', '0', 101);
INSERT INTO Has_Disease VALUES('Chickenpox', '0', 102);
INSERT INTO Has_Disease VALUES('Type I Diabetes', '0', 103);
INSERT INTO Has_Disease VALUES('Type I Diabetes', '0', 100); 
INSERT INTO Has_Disease VALUES('Alzheimers Disease', '0', 104);
INSERT INTO Has_Disease VALUES('Chickenpox', '1', 105);
INSERT INTO Has_Disease VALUES('Mental Illness', '0', 105);
INSERT INTO Has_Disease VALUES('Liver Cancer Stage 2', '0', 106);
INSERT INTO Has_Disease VALUES('Seasonal Flu', '0', 107);
INSERT INTO Has_Disease VALUES('Mental Illness', '0', 107);
INSERT INTO Has_Disease VALUES('ADHD', '0', 108);
INSERT INTO Has_Disease VALUES('Seasonal Flu', '1', 108);
INSERT INTO Has_Disease VALUES('Autism', '0', 109);
INSERT INTO Has_Disease VALUES('ADHD', '0', 109);
INSERT INTO Has_Disease VALUES('Seasonal Flu', '0', 109);
INSERT INTO Has_Disease VALUES('Liver Cancer Stage 2', '0', 109);
INSERT INTO Has_Disease VALUES('Mental Illness', '0', 109);
INSERT INTO Has_Disease VALUES('Chickenpox', '1', 109);
INSERT INTO Has_Disease VALUES('Liver Cancer', '0', 109);
INSERT INTO Has_Disease VALUES('Cardiovascular Disease', '1', 109);
INSERT INTO Has_Disease VALUES('Type I Diabetes', '0', 109);
INSERT INTO Has_Disease VALUES('Alzheimers Disease', '0', 109);

DROP TABLE Doctor CASCADE CONSTRAINTS;
CREATE TABLE Doctor (
	id INTEGER PRIMARY KEY,
	name CHAR(50) NOT NULL,
	phone CHAR(50) NOT NULL,
	address CHAR(50),
	specialization CHAR(50) NOT NULL,
	department CHAR(50),
	UNIQUE(name, phone));
    
INSERT INTO Doctor
VALUES (1000, 'Jake Holt', '778 290 4839', '5948 Granville St, Vancouver, BC V4D 1R2', 'Cardiovascular
Disease', 'Cardiology');
INSERT INTO Doctor
VALUES (1001, 'Rachel Wilkins', '604 129 8109', '1239 Apple St, Vancouver, BC V5A 1Z2', 'Liver Cancer',
'Oncology');
INSERT INTO Doctor
VALUES (1002, 'Billy Yang', '604 120 2984', '9928 Davie St, Vancouver, BC V6B 1R3', 'Type I Diabetes',
'Nutrition and Dietetics');
INSERT INTO Doctor
VALUES (1003, 'Amy Whittle', '778 109 2491', '5819 Graham St, Vancouver, BC V9A 1B6', 'Chickenpox',
'Infection Control');
INSERT INTO Doctor
VALUES (1004, 'Tim Watsons', '778 129 8419', '1209 Renfrew St, Vancouver, BC V1T 1S3', 'Alzheimers
Disease', 'Elderly Services');
INSERT INTO Doctor
VALUES (1005, 'Tim Poke', '778 229 8319', '1209 Nickel St, Vancouver, BC V2K 5X3', 'Mental Illness', 'Mental Health');
INSERT INTO Doctor
VALUES (1006, 'Jim Cow', '738 129 8419', '1209 Happy St, Vancouver, BC V3K 1P3', 'Seasonal Viruses', 'Infection Control');
INSERT INTO Doctor
VALUES (1007, 'Ishan Sohal', '814 139 3419', '1209 Mildew St, Vancouver, BC V1C 1C7', 'ADHD', 'Mental Health');
INSERT INTO Doctor
VALUES (1008, 'Kanna Ken', '604 729 7312', '1209 Rainer St, Vancouver, BC V9T 8J9', 'Autism', 'Mental Health');
INSERT INTO Doctor
VALUES (1009, 'Mickey Stanley', '604 646 7483', '1209 Baker St, Vancouver, BC V6T 1B3', 'Alzheimers
Disease', 'Elderly Services');
    
DROP TABLE Nurse CASCADE CONSTRAINTS;
CREATE TABLE Nurse (
	id INTEGER PRIMARY KEY,
	name CHAR(50) NOT NULL,
	phone CHAR(50) NOT NULL,
	address CHAR(50),
	department CHAR(50),
	UNIQUE(name, phone));
    
INSERT INTO Nurse
VALUES (3000, 'Arthur Davila', '778 333 8898', '1209 Hawke Ave, Vancouver, BC V6R 2C9', 'Cardiology');
INSERT INTO Nurse
VALUES (3001, 'Susan Lovell', '604 239 8849', '2219 Hastings St, Vancouver, BC V2A 1B2', 'Oncology');
INSERT INTO Nurse
VALUES (3002, 'Harry Torres', '604 709 2293', '9089 Hazelbridge Way St, Vancouver, BC V6X 4J7', 'Oncology');
INSERT INTO Nurse
VALUES (3003, 'Shakir Leblanc', '778 120 9482', '2309 Main St, Vancouver, BC V6B 1A9', 'Oncology');
INSERT INTO Nurse
VALUES (3004, 'Aubrey Mitchell', '778 435 0921', '1209 Apple St, Vancouver, BC V5A 1Z2', 'Cardiology');

DROP TABLE Admin CASCADE CONSTRAINTS;
CREATE TABLE Admin (
	id INTEGER PRIMARY KEY,
	name CHAR(50) NOT NULL,
	phone CHAR(50) NOT NULL,
	address CHAR(50),
	department CHAR(50),
	UNIQUE(name, phone));

INSERT INTO Admin
VALUES (2000, 'Bob Ma', '778 120 9804', '2398 Mainland St, Vancouver, BC V4R 1D7', 'Cardiology');
INSERT INTO Admin
VALUES (2001, 'Will Banks', '604 509 8325', '1092 Hastings St, Vancouver, BC V2A 1B2', 'Oncology');
INSERT INTO Admin
VALUES (2002, 'Ariel Gordon', '604 792 1029', '6789 Hazelbridge Way St, Vancouver, BC V6X 4J7',
'Nutrition and Dietetics');
INSERT INTO Admin
VALUES (2003, 'Susan Tate', '778 289 7323', '4219 Graham St, Vancouver, BC V2C 1T6', 'Infection
Control');
INSERT INTO Admin
VALUES (2004, 'Ciara Conley', '778 129 8419', '6459 Robson St, Vancouver, BC V7Y 0A1', 'Elderly
Services');
INSERT INTO Admin
VALUES (2005, 'Cindy Brown', '778 883 2876', '2485 Broadway W, Vancouver, BC V6K 2E8', 'Cardiology');
INSERT INTO Admin
VALUES (2006, 'Jay Smith', '604 254 1344', '563 Union St, Vancouver, BC V6A 2B7', 'Nutrition and Dietetics');
INSERT INTO Admin
VALUES (2007, 'Jennie Wong', '604 876 8544', '1949 Comox St 305, Vancouver, BC V6G 1R7', 'Oncology');
INSERT INTO Admin
VALUES (2008, 'Shamus Menard', '778 895 2133', '1410 Tolmie St, Vancouver, BC V6R 4B3', 'Oncology');
INSERT INTO Admin
VALUES (2009, 'Aidan Menard', '778 345 2133', '5980 Battison St, Vancouver, BC V5R 4M8', 'Infection Control');	 
    
DROP TABLE Room CASCADE CONSTRAINTS;
CREATE TABLE Room (
	room_type CHAR(50) NOT NULL,
	department CHAR(50),
	room_number INTEGER,
	available CHAR(1) NOT NULL,
	PRIMARY KEY (department, room_number));

    
INSERT INTO Room
VALUES ('Surgery Room', 'Cardiology', 100, '0');
INSERT INTO Room
VALUES ('Meeting Room', 'Cardiology', 110, '1');
INSERT INTO Room
VALUES ('Surgery Room', 'Oncology', 200,'0');
INSERT INTO Room
VALUES ('Meeting Room', 'Oncology', 210, '1');
INSERT INTO Room
VALUES ('Meeting room', 'Nutrition and Dietetics', 300, '1');
INSERT INTO Room
VALUES ('Meeting room', 'Elderly Services', 400, '1');
INSERT INTO Room
VALUES ('Meeting room', 'Infection Control', 500, '1');
INSERT INTO Room
VALUES ('Meeting room', 'Mental Illness', 100, '1');
    
DROP TABLE AssignTo CASCADE CONSTRAINTS;
CREATE TABLE AssignTo (
	staff_id INTEGER, 
	room_department CHAR(50), 
	room_number INTEGER,
	PRIMARY KEY (staff_id, room_department, room_number),
	FOREIGN KEY (staff_id) REFERENCES Nurse(id) ON DELETE CASCADE, 
	FOREIGN KEY (room_department, room_number) REFERENCES Room (department, room_number) ON DELETE CASCADE);
    
INSERT INTO AssignTo
VALUES (3000, 'Cardiology', 100);
INSERT INTO AssignTo
VALUES (3001, 'Oncology',200);
INSERT INTO AssignTo
VALUES (3002, 'Oncology', 200);
INSERT INTO AssignTo
VALUES (3003, 'Oncology', 200);
INSERT INTO AssignTo
VALUES (3004, 'Cardiology', 100);
    
DROP TABLE Appointment CASCADE CONSTRAINTS;
CREATE TABLE Appointment(
	patient_id INTEGER,
	doctor_id INTEGER,
	room_dept CHAR(50),
	room_num INTEGER,
	start_date_time DATE NOT NULL,
	end_date_time DATE NOT NULL,
	PRIMARY KEY(patient_id, doctor_id, room_dept, room_num, start_date_time, end_date_time),
	FOREIGN KEY(patient_id) REFERENCES Patient(id) ON DELETE CASCADE,
	FOREIGN KEY(doctor_id) REFERENCES Doctor(id) ON DELETE CASCADE,
	FOREIGN KEY(room_dept, room_num) REFERENCES Room(department, room_number) ON
	DELETE CASCADE);

    
INSERT INTO Appointment
VALUES (100, 1001, 'Oncology', 210, TO_DATE ('2019-03-11 12:30:00', 'yyyy/mm/dd hh24:mi:ss'),
TO_DATE('2019-03-11 13:30:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO Appointment
VALUES (100, 1001, 'Oncology', 210, TO_DATE ('2019-03-12 12:30:00', 'yyyy/mm/dd hh24:mi:ss'),
TO_DATE('2019-03-12 13:30:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO Appointment
VALUES (100, 1002, 'Nutrition and Dietetics', 300, TO_DATE ('2019-11-10 8:30:00', 'yyyy/mm/dd hh24:mi:ss'),
TO_DATE('2019-11-10 9:30:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO Appointment
VALUES (100, 1001, 'Oncology', 210, TO_DATE ('2019-07-30 11:30:00', 'yyyy/mm/dd hh24:mi:ss'),
TO_DATE('2019-07-30 12:30:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO Appointment
VALUES (101, 1000, 'Cardiology', 110, TO_DATE('2019-04-01 15:30:00', 'yyyy/mm/dd hh24:mi:ss'),
TO_DATE('2019-04-01 16:30:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO Appointment
VALUES (102, 1003, 'Infection Control', 500, TO_DATE('2019-02-11 12:30:00', 'yyyy/mm/dd hh24:mi:ss'),
TO_DATE('2019-02-11 13:30:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO Appointment
VALUES (103, 1002, 'Nutrition and Dietetics', 300, TO_DATE ('2019-05-20 12:00:00', 'yyyy/mm/dd
hh24:mi:ss'), TO_DATE('2019-05-20 12:30:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO Appointment
VALUES (104, 1004, 'Elderly Services', 400, TO_DATE('2019-05-20 14:30:00', 'yyyy/mm/dd hh24:mi:ss'),
TO_DATE('2019-05-20 15:30:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO Appointment
VALUES (105, 1007, 'Mental Illness', 100, TO_DATE('2019-06-20 14:30:00', 'yyyy/mm/dd hh24:mi:ss'),
TO_DATE('2019-06-20 15:30:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO Appointment
VALUES (106, 1001, 'Oncology', 200, TO_DATE('2019-09-20 14:30:00', 'yyyy/mm/dd hh24:mi:ss'),
TO_DATE('2019-09-20 15:30:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO Appointment
VALUES (107, 1005, 'Mental Illness', 100, TO_DATE('2019-09-20 13:30:00', 'yyyy/mm/dd hh24:mi:ss'),
TO_DATE('2019-09-20 14:30:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO Appointment
VALUES (108, 1006, 'Infection Control', 500, TO_DATE('2019-09-21 13:30:00', 'yyyy/mm/dd hh24:mi:ss'),
TO_DATE('2019-09-21 14:30:00', 'yyyy/mm/dd hh24:mi:ss'));
INSERT INTO Appointment
VALUES (109, 1006, 'Elderly Services', 400, TO_DATE('2019-04-15 13:30:00', 'yyyy/mm/dd hh24:mi:ss'),
TO_DATE('2019-04-15 14:30:00', 'yyyy/mm/dd hh24:mi:ss'));

    
DROP TABLE Equipment1 CASCADE CONSTRAINTS;
CREATE TABLE Equipment1(
	name CHAR(50) PRIMARY KEY,
	usage CHAR(50));

INSERT INTO Equipment1
VALUES ('EKG Machine', 'Measures electrical activity of heart');
INSERT INTO Equipment1
VALUES ('Stress Testing Machine', 'Monitors heart rate during exercise');
INSERT INTO Equipment1
VALUES ('Radiation Delivery Machines', 'Cancer treatment');
INSERT INTO Equipment1
VALUES ('Blood Glucose Meter', 'Measures amount of glucose in blood');
INSERT INTO Equipment1
VALUES ('Insulin Pumps', 'Used for type I diabetes');
INSERT INTO Equipment1
VALUES ('MRI Machine', 'Used for brain scans');
INSERT INTO Equipment1
VALUES ('X-Ray Machine', 'Used for bone imaging');
    
DROP TABLE Equipment2 CASCADE CONSTRAINTS;
CREATE TABLE Equipment2(
	name CHAR(50),
	brand CHAR(50),
	manufactured_in CHAR(50),
	PRIMARY KEY (name, brand),
	FOREIGN KEY (name) REFERENCES Equipment1(name));

INSERT INTO Equipment2
VALUES ('EKG Machine', 'Bionet', 'USA');
INSERT INTO Equipment2
VALUES ('Stress Testing Machine','Welch Allyn', 'Germany');
INSERT INTO Equipment2
VALUES ('Radiation Delivery Machines', 'TrueBeam', 'Australia');
INSERT INTO Equipment2
VALUES ('Blood Glucose Meter', 'Accu-Chek', 'USA');
INSERT INTO Equipment2
VALUES ('Insulin Pumps', 'Medtronic', 'Japan');
INSERT INTO Equipment2
VALUES ('MRI Machine', 'MedFirst', 'Korea');
INSERT INTO Equipment2
VALUES ('X-Ray Machine', 'Radiant Medical', 'Canada');
    
DROP TABLE Equipment3 CASCADE CONSTRAINTS;
CREATE TABLE Equipment3(
	brand CHAR(50) PRIMARY KEY,
	customer_support_number CHAR(50));

INSERT INTO Equipment3
VALUES ('Bionet', '778 129 8948');
INSERT INTO Equipment3
VALUES ('Welch Allyn', '778 290 4823');
INSERT INTO Equipment3
VALUES ('TrueBeam', '778 520 9481');
INSERT INTO Equipment3
VALUES ('Accu-Chek', '778 320 9482');
INSERT INTO Equipment3
VALUES ('Medtronic', '778 998 2300');
INSERT INTO Equipment3
VALUES ('MedFirst', '778 664 2353');
INSERT INTO Equipment3
VALUES ('Radiant Medical', '1800 598 2322');
    
DROP TABLE Equipment CASCADE CONSTRAINTS;
CREATE TABLE Equipment (
	id INTEGER PRIMARY KEY,
	name CHAR(50) NOT NULL,
	brand CHAR(50) NOT NULL,
	purchase_date DATE,
	price REAL,
	FOREIGN KEY (brand) REFERENCES Equipment3(brand),
	FOREIGN KEY (name, brand) REFERENCES Equipment2(name, brand),
	FOREIGN KEY (name) REFERENCES Equipment1(name));
    
INSERT INTO Equipment
VALUES (1000, 'EKG Machine', 'Bionet', DATE '2017-01-02', 3000);
INSERT INTO Equipment
VALUES (1001, 'Stress Testing Machine', 'Welch Allyn', DATE '2016-10-11', 24000);
INSERT INTO Equipment
VALUES (1002, 'Radiation Delivery Machines', 'TrueBeam', DATE '2015-04-22', 750000);
INSERT INTO Equipment
VALUES (1003, 'Blood Glucose Meter', 'Accu-Chek', DATE '2015-03-20', 100);
INSERT INTO Equipment
VALUES (1004, 'Insulin Pumps', 'Medtronic', DATE '2016-07-08', 4500);
INSERT INTO Equipment
VALUES (1005, 'MRI Machine', 'MedFirst', DATE '2015-07-01', 150000);
INSERT INTO Equipment
VALUES (1006, 'X-Ray Machine', 'Radiant Medical', DATE '2011-01-08', 79599);
    
DROP TABLE LocatedAt CASCADE CONSTRAINTS;
CREATE TABLE LocatedAt (
	room_department CHAR(50),
	room_number INTEGER,
	equipment_id INTEGER,
	PRIMARY KEY (room_department, room_number, equipment_id),
	FOREIGN KEY (equipment_id) REFERENCES Equipment(id) ON DELETE CASCADE,
	FOREIGN KEY (room_department, room_number) REFERENCES Room(department,
	room_number) ON DELETE CASCADE);
    
INSERT INTO LocatedAt
VALUES ('Cardiology', 100, 1000);
INSERT INTO LocatedAt
VALUES ('Cardiology', 100, 1001);
INSERT INTO LocatedAt
VALUES ('Oncology', 200, 1002);
INSERT INTO LocatedAt
VALUES ('Oncology', 200, 1003);
INSERT INTO LocatedAt
VALUES ('Oncology', 200, 1004);
INSERT INTO LocatedAt
VALUES ('Oncology', 210, 1004);
INSERT INTO LocatedAt
VALUES ('Oncology', 210, 1005);
INSERT INTO LocatedAt
VALUES ('Oncology', 210, 1006);
INSERT INTO LocatedAt
VALUES ('Nutrition and Dietetics', 300, 1003);
    
DROP TABLE Treatment_History CASCADE CONSTRAINTS;
CREATE TABLE Treatment_History (
	id INTEGER PRIMARY KEY,
	treatment_date DATE,
	medical_notes CHAR(50),
	patient_id INTEGER NOT NULL,
	FOREIGN KEY (patient_id) REFERENCES Patient(id) ON DELETE CASCADE);

INSERT INTO Treatment_History
VALUES (1, DATE '2019-02-01', 'Patient had chemotherapy', 100);
INSERT INTO Treatment_History
VALUES (2, DATE '2019-02-15', 'Patient had surgery to remove tumour', 100);
INSERT INTO Treatment_History
VALUES (3, DATE '2019-03-30', 'Patient came for monthly cancer relapse checkup', 100);
INSERT INTO Treatment_History
VALUES (4, DATE '2019-01-10', 'Prescribed medications for cardiovascular disease', 101);
INSERT INTO Treatment_History
VALUES (5, DATE '2019-01-15', 'Prescribed antibiotics for chickenpox', 102);
INSERT INTO Treatment_History
VALUES (6, DATE '2019-02-03', 'Treated with insulin', 103);
INSERT INTO Treatment_History
VALUES (7, DATE '2019-02-05', 'Prescribed with Razadyne', 104);
INSERT INTO Treatment_History
VALUES (8, DATE '2019-02-05', 'Prescribed with Razadyne', 104);
INSERT INTO Treatment_History
VALUES (9, DATE '2019-02-05', 'Discussed anxiety triggers and gave citalopram', 105);
INSERT INTO Treatment_History
VALUES (10, DATE '2019-03-05', 'Discussed Cancer and prescribed Tylenol 2', 106);
INSERT INTO Treatment_History
VALUES (11, DATE '2019-04-03', 'Prescribed Codeine for flu symptoms', 107);
INSERT INTO Treatment_History
VALUES (12, DATE '2019-06-15', 'Prescribed with Ritalin', 108);
INSERT INTO Treatment_History
VALUES (13, DATE '2019-10-01', 'Given severe patient conditions, prescribed opiums', 109);
    
DROP TABLE Prescription1 CASCADE CONSTRAINTS;
CREATE TABLE Prescription1 (
    drug_name CHAR(50),
    total_amount INTEGER,
    price REAL,
    PRIMARY KEY (drug_name, total_amount));
    
INSERT INTO Prescription1
VALUES ('Ranitidine', 90, 200);
INSERT INTO Prescription1
VALUES ('Benazepril', 30, 300);
INSERT INTO Prescription1
VALUES ('Zovirax', 45, 100);
INSERT INTO Prescription1
VALUES ('Insulin glulisine', 600, 250);
INSERT INTO Prescription1
VALUES ('Razadyne', 300, 150);
INSERT INTO Prescription1
VALUES ('Ritalin', 60, 55);
INSERT INTO Prescription1
VALUES ('Opium', 150, 100);
INSERT INTO Prescription1
VALUES ('Codeine', 10, 5);
INSERT INTO Prescription1
VALUES ('Citalopram', 7, 37.99);
INSERT INTO Prescription1
VALUES ('Tylenol 2', 30, 25.01);
    
DROP TABLE Prescription2 CASCADE CONSTRAINTS;
CREATE TABLE Prescription2 (
	dosage INTEGER,
	duration_days INTEGER,
	total_amount INTEGER,
	PRIMARY KEY (dosage, duration_days));

INSERT INTO Prescription2
VALUES (3, 30, 90);
INSERT INTO Prescription2
VALUES (1, 30, 30);
INSERT INTO Prescription2
VALUES (3, 15, 45);
INSERT INTO Prescription2
VALUES (30, 20, 600);
INSERT INTO Prescription2
VALUES (10, 30, 300);
INSERT INTO Prescription2
VALUES (2, 30, 60);
INSERT INTO Prescription2
VALUES (5, 30, 150);
INSERT INTO Prescription2
VALUES (1, 10, 10);
INSERT INTO Prescription2
VALUES (1, 7, 7);
INSERT INTO Prescription2
VALUES (3, 10, 30);

DROP TABLE Prescription CASCADE CONSTRAINTS;
CREATE TABLE Prescription (
	drug_name CHAR(50),
	refills INTEGER,
	dosage INTEGER,
	duration_days INTEGER,
	treatment_history_id INTEGER NOT NULL,
	PRIMARY KEY (drug_name, treatment_history_id),
	FOREIGN KEY (dosage, duration_days) REFERENCES Prescription2(dosage, duration_days),
	FOREIGN KEY (treatment_history_id) REFERENCES Treatment_History(id));
    
INSERT INTO Prescription
VALUES ('Ranitidine', 0, 3, 30, 1);
INSERT INTO Prescription
VALUES ('Benazepril', 5, 1, 30, 1);
INSERT INTO Prescription
VALUES ('Zovirax', 0, 3, 15, 2);
INSERT INTO Prescription
VALUES ('Insulin glulisine', 2, 30, 20, 6);
INSERT INTO Prescription
VALUES ('Razadyne', 0, 10, 30, 7);
INSERT INTO Prescription
VALUES ('Ritalin', 0, 2, 30, 12);
INSERT INTO Prescription
VALUES ('Opium', 0, 5, 30, 13);
INSERT INTO Prescription
VALUES ('Codein', 0, 1, 10, 11);
INSERT INTO Prescription
VALUES ('Citalopram', 0, 1, 7, 9);
INSERT INTO Prescription
VALUES ('Tylenol 2', 0, 3, 10, 10);

DROP TABLE Maintenance_Record CASCADE CONSTRAINTS;  
CREATE TABLE Maintenance_Record(
	record_id INTEGER PRIMARY KEY,
	record_date DATE NOT NULL,
	pass CHAR(1) NOT NULL,
	admin_id INTEGER NOT NULL,
	equipment_id INTEGER NOT NULL,
	FOREIGN KEY(equipment_id) REFERENCES Equipment(id) ON DELETE CASCADE,
	FOREIGN KEY(admin_id) REFERENCES Admin(id) ON DELETE SET NULL);

INSERT INTO Maintenance_Record
VALUES (1000, DATE '2019-01-01', '1', 2000, 1000);
INSERT INTO Maintenance_Record
VALUES (1001, DATE '2019-01-01', '1', 2000, 1001);
INSERT INTO Maintenance_Record
VALUES (1002, DATE '2019-01-01', '1', 2001, 1002);
INSERT INTO Maintenance_Record
VALUES (1003, DATE '2019-01-01', '0', 2002, 1003);
INSERT INTO Maintenance_Record
VALUES (1004, DATE '2019-01-01', '1', 2002, 1002);
INSERT INTO Maintenance_Record
VALUES (1005, DATE '2019-02-11', '1', 2007, 1003);
INSERT INTO Maintenance_Record
VALUES (1006, DATE '2019-01-11', '1', 2003, 1003);
INSERT INTO Maintenance_Record
VALUES (1007, DATE '2019-02-22', '1', 2004, 1001);
INSERT INTO Maintenance_Record
VALUES (1008, DATE '2019-03-10', '0', 2005, 1004);
INSERT INTO Maintenance_Record
VALUES (1009, DATE '2016-10-14', '1', 2006, 1005);									
									
									
commit;
