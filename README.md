# WebSecLab-1

## Configuration for mysql
 Replace mysql credentials with your credentials in functions.php
 ```
<?php
session_start();
     $db = mysqli_connect("localhost","user","password","twitter");
    if(mysqli_connect_errno()){
        print_r(mysqli_connect_errno());
        exit();
    }

 ```
 ## Create mysql user
Run the following commands in mysql
```
CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON * . * TO 'user'@'localhost';
```
 
## setup database
```
root@kali:/var/www/html# service mysql start
root@kali:/var/www/html# mysql -u root -p -e "create database twitter"
root@kali:/var/www/html# mysql -u root -p twitter < twitter.sql
```


Follow: <a href="https://twitter.com/m0nkeyshell">@m0nkeyshell</a>
