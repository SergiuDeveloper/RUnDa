DROP SCHEMA IF EXISTS RUnDa;
CREATE SCHEMA RUnDa;

USE RUnDa;

DROP TABLE IF EXISTS Counties;
CREATE TABLE Counties (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(32) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS AgeCategories;
CREATE TABLE AgeCategories (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(32) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS EducationLevels;
CREATE TABLE EducationLevels (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(32) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS CompensationStatuses;
CREATE TABLE CompensationStatuses (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(32) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS Environments;
CREATE TABLE Environments (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(32) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS Genders;
CREATE TABLE Genders (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(32) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS DataPerAgeCategory;
CREATE TABLE DataPerAgeCategory (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    CountyID INT NOT NULL REFERENCES Counties.ID,
    AgeCategoryID INT NOT NULL REFERENCES AgeCategories.ID,
    Value INT NOT NULL,
    UNIQUE KEY (CountyID, AgeCategoryID)
);

DROP TABLE IF EXISTS DataPerEducationLevel;
CREATE TABLE DataPerEducationLevel (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    CountyID INT NOT NULL REFERENCES Counties.ID,
    EducationLevelID INT NOT NULL REFERENCES EducationLevels.ID,
    Value INT NOT NULL,
    UNIQUE KEY (CountyID, EducationLevelID)
);

DROP TABLE IF EXISTS DataPerCompensationStatus;
CREATE TABLE DataPerCompensationStatus (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    CountyID INT NOT NULL REFERENCES Counties.ID,
    CompensationStatusID INT NOT NULL REFERENCES CompensationStatus.ID,
    Value INT NOT NULL,
    UNIQUE KEY (CountyID, CompensationStatusID)
);

DROP TABLE IF EXISTS DataPerGenderAndEnvironment;
CREATE TABLE DataPerGenderAndEnvironment (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    CountyID INT NOT NULL REFERENCES Counties.ID,
    GenderID INT NOT NULL REFERENCES Genders.ID,
    EnvironmentID INT NOT NULL REFERENCES Environments.ID,
    Value INT NOT NULL,
    UNIQUE KEY (CountyID, GenderID, EnvironmentID)
);

DROP TABLE IF EXISTS RatePerGender;
CREATE TABLE RatePerGender (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    CountyID INT NOT NULL REFERENCES Counties.ID,
    GenderID INT NOT NULL REFERENCES Genders.ID,
    Value INT NOT NULL,
    UNIQUE KEY (CountyID, GenderID)
);

DROP TABLE IF EXISTS PredictionFunctionWeights;
CREATE TABLE PredictionFunctionWeights (
	ID INT PRIMARY KEY AUTO_INCREMENT,
    CountyID INT REFERENCES Counties.ID,
	AgeCategoryID INT REFERENCES AgeCategories.ID,
    EducationLevelID INT REFERENCES EducationLevels.ID,
    CompensationStatusID INT REFERENCES CompensationStatuses.ID,
    EnvironmentID INT REFERENCES Environments.ID,
    GenderID INT REFERENCES Genders.ID,
    W0 FLOAT NOT NULL,
    W1 FLOAT NOT NULL,
    UNIQUE KEY (
		CountyID,
        AgeCategoryID,
        EducationLevelID,
        CompensationStatusID,
        EnvironmentID, 
        GenderID
	),
	CONSTRAINT CHECK (
		CountyID IS NOT NULL OR
        AgeCategoryID IS NOT NULL OR
        EducationLevelID IS NOT NULL OR
        CompensationStatusID IS NOT NULL OR
        EnvironmentID IS NOT NULL OR
        GenderID IS NOT NULL
	)
);