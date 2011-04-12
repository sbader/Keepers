Author: Scott Bader

This application was developed to create the combinations of players that can be kept on a Fantasy Baseball Keeper League from year to year. The rules in some leagues are that you are allowed to keep a set number of players where their total points are not greater than a set limit. For example in my league we are allowed to keep 5 players with a total of 2300 points.

The app uses MySQL as the data store and JQuery with JQuery UI.

The file includes/config.php has all of the setup for the MySQL database. A database will have to be created and the file includes/db.sql will need to run inside that database. The variable $dbdatabase will need to be changed to the name of your database.

A database user with Select, Insert, Update and Delete privileges will need to be used for the variable $dbuser along with that user's password for $dbpassword