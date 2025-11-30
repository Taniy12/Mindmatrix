package com.mindmatrix.util;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class DBUtils {

    private static final String DB_URL = "jdbc:mysql://localhost:3306/mindmatrix"; // Change to your DB URL
    private static final String DB_USERNAME = "root"; // Change to your DB username
    private static final String DB_PASSWORD = "taniya1204"; // Change to your DB password

    public static Connection getConnection() throws SQLException {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver"); // MySQL Driver class
            return DriverManager.getConnection(DB_URL, DB_USERNAME, DB_PASSWORD);
        } catch (ClassNotFoundException e) {
            throw new SQLException("Database driver not found", e);
        }
    }
}
