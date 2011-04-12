##About
This application was developed to create the combinations of players that can be kept on a Fantasy Baseball Keeper League from year to year. The rules in some leagues are that you are allowed to keep a set number of players where their total points are not greater than a set limit. For example in my league we are allowed to keep 5 players with a total of 2300 points.

The app uses MySQL as the data store and JQuery with JQuery UI.

The file includes/config.php has all of the setup for the MySQL database. A database will have to be created and the file includes/db.sql will need to run inside that database. The variable $dbdatabase will need to be changed to the name of your database.

A database user with Select, Insert, Update and Delete privileges will need to be used for the variable $dbuser along with that user's password for $dbpassword

##License (MIT License)

Copyright (c) 2011 Scott Bader

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.