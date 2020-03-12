package com.runda.data;

import java.io.Console;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

import com.mysql.cj.jdbc.Driver;

public class Scrapper {
    public static void main(String[] args) throws SQLException {
        Driver sqlDriver = new Driver();
        DriverManager.registerDriver(sqlDriver);

        Console programConsole = System.console();
        programConsole.printf("DB Server IP: ");
        String sqlServerIP = programConsole.readLine();
        programConsole.printf("DB name: ");
        String sqlDBName = programConsole.readLine();
        programConsole.printf("DB user: ");
        String sqlDBUser = programConsole.readLine();
        programConsole.printf("DB pass: ");
        String sqlDBPassword = new String(programConsole.readPassword());

        Connection sqlConnection = DriverManager.getConnection("jdbc:mysql://" + sqlServerIP + "/" + sqlDBName  + "?" + "user=" + sqlDBUser + "&password=" + sqlDBPassword);
        programConsole.printf("Successfully connected to DB\n");

        sqlConnection.close();
        DriverManager.deregisterDriver(sqlDriver);

        programConsole.printf("Successfully disconnected from DB\n");
    }
}