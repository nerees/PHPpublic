PHP CLI (console) application
-
___

A MUST:
SQLITE extension must be enabled in php.ini
```
extension=php_pdo_sqlite.dll
extension=php_sqlite.dll
```
___

HOW TO USE:
-
___
run terminal in root directory

in terminal type: " php run.php 'command' "

COMMANDS:
```
"help" command - for displaying usage example
"list" command - for displaying available command list
"add" command - for adding new registration to database
"update" command - for updating registration by given ID
"delete" command - for deleting registration by given ID
"all" command - for displaying all registrations sorted by date
"date" command - for displaying all registrations by given date, sorted by time
"export" command - for exporting database data to csv
"import" command - for importing data to database from csv
```
___
TODO:
-
In case database is not available use only csv files.
