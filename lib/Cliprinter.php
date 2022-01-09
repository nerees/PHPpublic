<?php

namespace Myapp;

class CliPrinter
{
    public function out($message)
    {
        echo $message;
    }

    public function newline()
    {
        $this->out("\n");
    }

    /**
     * Print simple message to screen
     * @param $message
     * @return void
     */
    public function display($message)
    {
        $this->newline();
        $this->out($message);
        $this->newline();
        $this->newline();
    }

    /**
     * Print fron assoc array to screen (for command list)
     * @param $arrayForPrint
     * @return void
     */
    public function printAssocArray($arrayForPrint)
    {
        if (!is_array($arrayForPrint)) exit;

        foreach ($arrayForPrint as $key => $value){
            echo $key . PHP_EOL;
        }

        $this->newline();
    }

    /**
     * Print database data in nicer table
     * @param $arrayForPrint
     * @return void
     */
    public function printRows($arrayForPrint)
    {
        if (!is_array($arrayForPrint)) exit;

        $mask = "|%5.5s |%-30.30s |%-30.30s |%-15.15s |%-60.60s|%-18.18s |\n";
        printf($mask, 'ID', 'Name', 'E-mail', 'Phone', 'Address', 'Date and Time');

        foreach ($arrayForPrint as $value){
            printf($mask, $value['id'], $value['name'], $value['email'], $value['phone'], $value['address'], $value['date_time']);
        }

        $this->newline();
    }

    /**
     * export to csv file
     * @param $arrayForPrint
     * @return void
     */
    public function printToCSV($arrayForPrint)
    {
        if (!is_array($arrayForPrint)) exit;

        $csv = fopen('export.csv', 'w');

        foreach ($arrayForPrint as $value){
            fputcsv($csv, array($value['id'], $value['name'], $value['email'], $value['phone'], $value['address'], $value['date_time']), ",");
        }
        fclose($csv);
        $this->display("Data exported to export.csv");
    }
}