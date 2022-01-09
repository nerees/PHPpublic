<?php
/**
 * MAIN app runner
 */

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use Myapp\App;
use Myapp\SQLiteConnection;
use Myapp\Registration;
use Myapp\RegistrationRepo;

/**
 * Get database PDO object
 * Initialize database if not exists
 */
$pdo = (new SQLiteConnection())->connect();

/**
 * Initialize main app instance for work :)
 */
$app = new App();

/**
 * Register "help" command - for displaying usage example
 */
$app->registerCommand('help', function (array $argv) use ($app) {
    $app->getPrinter()->display("----------------\nusage: php run.php 'command' \n\nFor listing available commands type: php run.php list\n----------\n");
});

/**
 * Registering "list" command - for displaying available commands list
 */
$app->registerCommand('list', function (array $argv) use ($app) {
    $app->getPrinter()->display("Available commands:");
    $app->getPrinter()->printAssocArray($app->getAllCommands());
});

/**
 * Registering "add" command - for adding new registration to database
 */
$app->registerCommand('add', function (array $argv) use ($app) {
    $registration = new Registration();
    $registration->setUName($app->askInput("Name", "(First and Last name)" ));
    $registration->setEmail($app->askInput("Email", "(example: your_name@domain.com)"));
    $registration->setPhone($app->askInput("Phone", "(digits only, example: 868679600)"));
    $registration->setAddress($app->askInput("Address", "(Place of service)"));
    $registration->setDate($app->askInput("Date and Time", "(example: '2022-01-02 12:30' )"));
    $rr = new RegistrationRepo($registration);
    $rr->save();
});

/**
 * Registering "update" command - for updating registration by given ID
 */
$app->registerCommand('update', function (array $argv) use ($app) {
    $registration = new Registration();
    $registration->setId($app->askInput("ID", "(ID of Reservation)" ));
    $registration->setUName($app->askInput("Name", "(First and Last name)" ));
    $registration->setEmail($app->askInput("Email", "(example: your_name@domain.com)"));
    $registration->setPhone($app->askInput("Phone", "(digits only, example: 868679600)"));
    $registration->setAddress($app->askInput("Address", "(Place of service)"));
    $registration->setDate($app->askInput("Date and Time", "(example: '2022-01-02 12:30' )"));
    $rr = new RegistrationRepo($registration);
    $rr->update();
});

/**
 * Registering "delete" command - for deleting registration by given ID
 */
$app->registerCommand('delete', function (array $argv) use ($app) {
    $id = $app->askInput("ID", "(ID of Reservation)" );
    RegistrationRepo::deleteById($id);
});

/**
 *  Registering "all" command - for displaying all registrations sorted by date
 */
$app->registerCommand('all', function (array $argv) use ($app) {
    $rez = RegistrationRepo::getAll();
    $app->getPrinter()->display("All Reservations:");
    $app->getPrinter()->printRows($rez);
});

/**
 * Registering "date" command - for displaying all registrations by given date, sorted by time
 */
$app->registerCommand('date', function (array $argv) use ($app) {
    $rez = RegistrationRepo::getAllByDate($app->askInput("Date", "(example: '2022-01-02' )"));
    $app->getPrinter()->printRows($rez);
});

/**
 * Registering "export" command - for exporting database data to csv
 */
$app->registerCommand('export', function (array $argv) use ($app) {
    $rez = RegistrationRepo::getAll();
    $app->getPrinter()->display("Exporting to export.csv ....");
    $app->getPrinter()->printToCSV($rez);
});

/**
 * Registering "import" command - for importing data to database from csv
 */
$app->registerCommand('import', function (array $argv) use ($app) {
    $current_dir = __DIR__;
    RegistrationRepo::importCSV($current_dir);
    $app->getPrinter()->display("Importing from csv ....");

});

/**
 * for running commands
 */
$app->runCommand($argv);