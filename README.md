# ZSchedule

App used to book playing centres ahead of time in colleges/universities. Meant for use by students, college staff and authorities.

This project has been built as part of a college course

# To build and run

Ensure you have

-   A MySQL client and server
-   A server capable of running PHP
-   Flutter SDKs

## Create a local instance of the database

Inside the mysql shell

```
\source db/init.sql
\source db/populate.sql
```

Create a file named `config.php` inside the `rest` folder. \
A `config.example.php` is already present for convenience. \
These are defaults for a local MySQL server installation. \
You may or may not need to change these.

```
<?php
	define("DB_HOST", "localhost");
	define("DB_PORT", "3306");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "zschedule_dev");
?>
```

## Run the server

Steps may be different for the server application that you use. \

### For use with XAMPP using Apache

Either change the server config to serve the project's `rest` folder (not recommended) or \
Create a symlink in the htdocs folder that points to the project's `rest` folder.

-   On Windows (Use correct and absolute paths)

```
mklink /D C:\xampp\htdocs\zschedule C:\absolute\path\to\your\project\root\rest
```

After that the server api should be accessible at `localhost/api`

## Run the flutter app

Run the app as usual with flutter

```
cd app
flutter pub get
flutter run
```
