-- Create the database
CREATE DATABASE mindmatrix;
USE mindmatrix;

-- Table for user details
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL -- Hashed password
);

-- Table for user responses to questions
CREATE TABLE responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    q1 VARCHAR(255) NOT NULL,
    q2 VARCHAR(255) NOT NULL,
    q3 VARCHAR(255) NOT NULL,
    q4 VARCHAR(255) NOT NULL,
    q5 VARCHAR(255) NOT NULL,
    q6 VARCHAR(255) NOT NULL,
    q7 VARCHAR(255) NOT NULL,
    q8 VARCHAR(255) NOT NULL,
    response TEXT() NOT NULL,
    responsed_at TIMESTAMP(CURRENT_TIMESTAMP) NOT NULL,
    depression_level VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table for therapist details
CREATE TABLE therapists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

-- Table for session details
CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    therapist_id INT NOT NULL,
    session_type ENUM('free', 'paid') NOT NULL,
    session_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (therapist_id) REFERENCES therapists(id) ON DELETE CASCADE
);

SHOW TABLES;
SHOW DATABASES;


SHOW DATABASES;
USE mindmatrix;
SHOW TABLES;

DESCRIBE users;
DESCRIBE responses;
DESCRIBE therapists;
DESCRIBE sessions;