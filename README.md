# IS Project 1 (PHP + MariaDB signup/login)

A small LAMP application: signup, login, dashboard, and a feedback form with its own table.

## Requirements
Apache (or Nginx + PHP-FPM), PHP with `php-mysql`, MariaDB, Git.

    sudo apt install apache2 php libapache2-mod-php php-mysql mariadb-server git -y

## Setup
1. Edit the password in `schema.sql` (the `CREATE USER` line), then create the database and tables:

       sudo mysql < schema.sql

2. Put the same password in `db.php`.
3. Copy the files to the web root and set ownership:

       sudo cp -r ./* /var/www/html/
       sudo rm /var/www/html/index.html
       sudo chown -R www-data:www-data /var/www/html

4. Open `http://<server-ip>/` in a browser.

## Pages
- `signup.php`: registers a user (validation, `password_hash`, prepared statements)
- `login.php`: checks the password with `password_verify`, starts a session
- `dashboard.php`: visible only when logged in
- `feedback.php`: extra form that POSTs to the `feedback` table and lists stored rows
- `logout.php`: ends the session

