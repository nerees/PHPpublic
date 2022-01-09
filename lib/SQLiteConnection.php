<?php

namespace Myapp;

use PDO;

/**
 * SQLite connnection
 */
class SQLiteConnection {

    private $pdo;
    private $printer;
    /**
     * return in instance of the PDO object that connects to the SQLite database
     * initiate DB tables if not exists
     * @return PDO
     */
    public function connect()
    {
        $this->printer = (new App())->getPrinter();

        if ($this->pdo == null) {

            try {
                $this->pdo = new PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);
            } catch (\PDOException $e) {
                $this->printer->display($e->getMessage());
                die("check if Your php.ini has sqlite extension enabled");
            }

        }
        /**
         * create new initial table if not exists
         * */
        try {
            $this->pdo->query('SELECT * FROM registrations LIMIT 1');
        } catch (\PDOException $e) {
            $this->printer->display("CREATING INITIAL DATABASE");
            $this->createInitialDbTable();
        }

        return $this->pdo;
    }

    /**
     * Create initial DB table
     * */
    public function createInitialDbTable()
    {
        try {
            $this->pdo->query('
                        CREATE TABLE registrations (
	                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	                    name TEXT NOT NULL,
	                    email TEXT NOT NULL,
	                    phone TEXT NOT NULL,
	                    address TEXT NOT NULL,
                        date_time DATE NOT NULL                           
                        )
            ');

        } catch (\PDOException $e) {
            $this->printer->display($e->getMessage());
        }
    }

}