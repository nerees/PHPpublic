<?php

namespace Myapp;

class Validation
{
    public array $patterns = array(
        //'tel' => '/[^0-9]/',
        'tel' => '/[0-9]{8}/',
        //'tel' => '/^(86|\+3706) \d{3} \d{4}/^$',
        'date_time' => '/202[2-9]{1}\-[0-1]{1}[0-9]{1}\-[0-1]{1}[0-9]{1}\ [0-2]{1}[0-3]\:[0-5]{1}[0-9]{1}/',
        'date' => '/202[2-9]{1}\-[0-1]{1}[0-9]{1}\-[0-1]{1}[0-9]{1}/'
        //'date' => '/^202+[2-9]{1}+\-+[0-1]{1}+[0-9]{1}+\-+[0-1]{1}+[0-9]{1}$/'
        //'email' => '/[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+[.]+[a-z-A-Z]/'
    );

    public string $error;

    /*TODO fix regex of change to some other validation method (not working properly)*/
    /**
     * Validate entered data by regex and prevent empty inputs
     * @param $value
     * @param $pattern
     * @return bool
     */
    public function isValid($value, $pattern)
    {
        $regex = $this->patterns[$pattern];

        if ( strlen($value) <= 0 && !preg_match($regex, $value) ) {
            $this->error = "Entered Invalid " . $value . " value";
            return false;
        }

        $this->error= "";
        return true;
    }

    /**
     * Check if entered ID exists in database
     * @param $value
     * @return bool
     */
    public function idExists($value)
    {
        $id = RegistrationRepo::idExists($value);

        if ( empty($id) ) {
            $this->error = "Reservation with ID " . $value . " does not exists";
            return false;
        }

        $this->error= "";
        return true;
    }

    /**
     * Validate input fields from USER
     * @param $field
     * @param $value
     * @return bool|mixed
     */
    public function validate($field, $value)
    {
        switch ($field){
            case "Address":
            case "Name" :
                return true;
            case "Email" :
                //return $this->isValid($value, "email");
                return filter_var($value, FILTER_VALIDATE_EMAIL);
            case "Phone" :
                return $this->isValid($value, "tel");
            case "Date and Time" :
                return $this->isValid($value, "date_time");
            case "Date" :
                echo "ikritom";
                return $this->isValid($value, "date");
            case "ID" :
                return $this->idExists($value);
            default:
                return false;
        }
    }
}