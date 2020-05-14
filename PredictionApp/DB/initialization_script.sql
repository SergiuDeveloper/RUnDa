DROP SCHEMA PredictionApp;
CREATE SCHEMA PredictionApp;
USE PredictionApp;

CREATE TABLE Categories (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(64) NOT NULL,
    
    UNIQUE KEY (
		Title
	)
);

CREATE TABLE Subcategories (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(64) NOT NULL,
    
    UNIQUE KEY (
		Title
	)
);

CREATE TABLE Locations (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(64) NOT NULL,
    
    UNIQUE KEY (
		Title
	)
);

CREATE TABLE Data_Attributes (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Category_ID INT NOT NULL,
    Subcategory_ID INT NOT NULL,
    Location_ID INT NOT NULL,
    
    CONSTRAINT fk_Data_Attributes_Category_ID FOREIGN KEY (Category_ID) REFERENCES Categories(ID) ON DELETE CASCADE,
    CONSTRAINT fk_Data_Attributes_Subcategory_ID FOREIGN KEY (Subcategory_ID) REFERENCES Subcategories(ID) ON DELETE CASCADE,
    CONSTRAINT fk_Data_Attributes_Location_ID FOREIGN KEY (Location_ID) REFERENCES Locations(ID) ON DELETE CASCADE,
    
    UNIQUE KEY (
		Category_ID,
        Subcategory_ID,
        Location_ID
    )
);

CREATE TABLE Data_Points (
	ID INT PRIMARY KEY AUTO_INCREMENT,
	Data_Attribute_ID INT NOT NULL,
    X_Coordinate INT NOT NULL,
    Y_Coordinate FLOAT NOT NULL,
    
    CONSTRAINT fk_Data_Points_Data_Attribute_ID FOREIGN KEY (Data_Attribute_ID) REFERENCES Data_Attributes(ID) ON DELETE CASCADE,
    
    UNIQUE KEY (
		Data_Attribute_ID,
        X_Coordinate
	)
);

CREATE TABLE Regression_Types (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(64) NOT NULL,
    
    UNIQUE KEY (
		Title
	)
);

CREATE TABLE Coefficient_Types (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(64) NOT NULL,
    
    UNIQUE KEY (
		Title
	)
);

CREATE TABLE Training_Results (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Data_Attribute_ID INT NOT NULL,
    Regression_Type_ID INT NOT NULL,
    Coefficient_Type_ID INT NOT NULL,
    Value FLOAT NOT NULL,
    Degree INT NOT NULL,
    
    CONSTRAINT fk_Training_Results_Data_Attribute_ID FOREIGN KEY (Data_Attribute_ID) REFERENCES Data_Attributes(ID) ON DELETE CASCADE,
    CONSTRAINT fk_Training_Results_Regression_Type_ID FOREIGN KEY (Regression_Type_ID) REFERENCES Regression_Types(ID) ON DELETE CASCADE,
    CONSTRAINT fk_Training_Results_Coefficient_Type_ID FOREIGN KEY (Coefficient_Type_ID) REFERENCES Coefficient_Types(ID) ON DELETE CASCADE,
    
    UNIQUE KEY (
		Data_Attribute_ID,
        Regression_Type_ID,
        Coefficient_Type_ID,
        Degree
	)
);

CREATE TABLE Data_Subtrahends (
	ID INT PRIMARY KEY AUTO_INCREMENT,
	Data_Attribute_ID INT NOT NULL,
    X_Value INT NOT NULL,
	Y_Value INT NOT NULL,
    
    CONSTRAINT fk_Data_Subtrahends_Data_Attribute_ID FOREIGN KEY (Data_Attribute_ID) REFERENCES Data_Attributes(ID) ON DELETE CASCADE,
    
    UNIQUE KEY (
		Data_Attribute_ID
	)
);

CREATE TABLE MSEs (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Training_Result_ID INT NOT NULL,
    Value FLOAT NOT NULL,
    
    CONSTRAINT fk_MSEs_Training_Result_ID FOREIGN KEY (Training_Result_ID) REFERENCES Training_Results(ID) ON DELETE CASCADE,
    
    UNIQUE KEY (
		Training_Result_ID
	)
);

INSERT INTO Regression_Types(Title) VALUES ('Linear'), ('Polynomial'), ('Logistic Polynomial');
INSERT INTO Coefficient_Types(Title) VALUES ('Bias'), ('Weight'), ('Exponent');