<?php

namespace Myapp;


use Exception;

class RegistrationRepo
{
    private Registration $registration;

    public function __construct($registration)
    {
        $this->registration = $registration;
    }

    /**
     * Save Registration to database
     * @return void
     */
    public function save()
    {
        $db = (new SQLiteConnection())->connect();
        $query = "INSERT INTO registrations (name, email, phone, address, date_time) VALUES('". $this->registration->getUName() . "','" . $this->registration->getEmail() . "','" . $this->registration->getPhone() . "','" . $this->registration->getAddress() . "','" . $this->registration->getDate() . "')";
        $result = null;

        try {
            $result = $db->query($query);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            //var_dump($e->errorInfo);
            die("ERROR saving registration");
        }
    }

    /**
     * Update Registration by ID field
     * @return void
     */
    public function update()
    {

        $db = (new SQLiteConnection())->connect();
        $query = "UPDATE registrations SET name = '". $this->registration->getUName() . "', email = '" . $this->registration->getEmail() . "', phone = '" . $this->registration->getPhone() . "', address = '" . $this->registration->getAddress() . "', date_time = '" . $this->registration->getDate() . "' WHERE id = '" . $this->registration->getId() . "'";
        $result = null;

        try {
            $result = $db->query($query);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            //var_dump($e->errorInfo);
            die("ERROR UPDATING registration");
        }
    }

    /**
     * Return all registrations from database (limited to 1000 rows)
     * @return array|false|void
     */
    public static function getAll()
    {
        $db = (new SQLiteConnection())->connect();
        $query = "SELECT id, name, email, phone, address, date_time FROM registrations ORDER BY date_time LIMIT 1000";
        $result = null;

        try {
            $result = $db->query($query);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            //var_dump($e->errorInfo);
            die("ERROR saving registration");
        }
        return $result->fetchAll();
    }

    /**
     * Returns all Registrations by given date
     * @param $requested_date
     * @return array|false|void
     */
    public static function getAllByDate($requested_date)
    {
        $db = (new SQLiteConnection())->connect();
        $query = "SELECT id, name, email, phone, address, date_time FROM registrations WHERE date_time LIKE '%".trim($requested_date)."%' ORDER BY date_time ASC";
        $result = null;

        try {
            $result = $db->query($query);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            //var_dump($e->errorInfo);
            die("ERROR saving registration");
        }

        return $result->fetchAll();
    }

    /**
     * For chech if row with given ID exists
     * @param $id
     * @return array|false|void
     */
    public static function idExists($id)
    {
        $db = (new SQLiteConnection())->connect();
        $query = "SELECT id FROM registrations WHERE id = '".trim($id)."'";
        $result = null;

        try {
            $result = $db->query($query);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            //var_dump($e->errorInfo);
            die("ERROR saving registration");
        }

        return $result->fetchAll();
    }

    /**
     * Deletes row from database by given ID
     * @param $id
     * @return bool|void
     */
    public static function deleteById($id)
    {
        $db = (new SQLiteConnection())->connect();
        $query = "DELETE FROM registrations WHERE id = '".trim($id)."'";
        $result = null;

        try {
            $result = $db->query($query);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            var_dump($e->errorInfo);
            die("ERROR deleting registration");
        }

        return true;
    }

    /**
     * Import data from CSV file toi database
     * @param $dir
     * @return bool
     * @throws Exception
     */
    public static function importCSV($dir)
    {
        if (($csv = fopen($dir."/import.csv", "r")) === FALSE)
            throw new Exception('Cannot open CSV file');

        while (($result = fgetcsv($csv)) !== false)
        {
            $registration = new Registration();
            $registration->setUName(trim($result[0]));
            $registration->setEmail(trim($result[1]));
            $registration->setPhone(trim($result[2]));
            $registration->setAddress(trim($result[3]));
            $registration->setDate(trim($result[4]));
            $rr = new RegistrationRepo($registration);
            $rr->save();
        }
        fclose($csv);
        return true;
    }
}
