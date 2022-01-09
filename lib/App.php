<?php

namespace Myapp;


class App
{
    private CliPrinter $printer;
    private array $registry = [];
    private Validation $validator;

    public function __construct()
    {
        $this->printer = new CliPrinter();
        $this->validator = new Validation();
    }

    /**
     * returns printer object for easier printing to screen
     * @return CliPrinter
     */
    public function getPrinter()
    {
        return $this->printer;
    }

    /**
     * Register command
     * @param $name
     * @param $callable
     * @return void
     */
    public function registerCommand($name, $callable)
    {
        $this->registry[$name] = $callable;
    }

    /**
     * Get given command from registered commands
     * @param $command
     * @return mixed|null
     */
    public function getCommand($command)
    {
        return isset($this->registry[$command]) ? $this->registry[$command] : null;
    }

    /**
     * Get all registered commands
     * @return array
     */
    public function getAllCommands()
    {
        return $this->registry;
    }

    /**
     * Run if command is registered, and print help if not found
     * @param array $argv
     * @return void
     */
    public function runCommand(array $argv = [])
    {
        $command_name = "help";

        if (isset($argv[1])) {
            $command_name = $argv[1];
        }

        $command = $this->getCommand($command_name);
        if ($command === null) {
            $this->getPrinter()->display("ERROR: Command \"$command_name\" not found. \n For available commands type: 'php run.php list' \n");
            exit;
        }

        call_user_func($command, $argv);
    }

    /**
     * Ask for User input
     * @param $fieldName
     * @param $tip
     * @return string
     */
    public function askInput($fieldName, $tip)
    {
        $go = false;

        while ($go === false) {
            $this->getPrinter()->display("Enter Your " .$fieldName. $tip . ":");
            $input = fopen ("php://stdin", "r");
            $text = trim(fgets($input));
            $go = $this->validator->validate($fieldName, $text);
            fclose($input);

            if (!empty($this->validator->error))
                $this->getPrinter()->display($this->validator->error);
        }

        return $text;
    }
}