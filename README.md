Aenianos is a website written using the framework [Laravel](http://laravel.com/).

#Setting up

##Requirements

- Apache (other HTTP servers can be used)
- MySQL (other databases can be used)
- [Composer](https://getcomposer.org/download/)
- [Node](https://nodejs.org) (to compile assets using Laravel's Elixir)

##Configuration
- Configure the `.env` (copy the `.env.example` if it doesn't exist) file on the root directory. Update the database/email credentials where needed.
- Run the command `composer install` from the repo folder;
- Run `npm install` (This will install all Node modules);
- Run `php artisan migrate --seed`. This will create the tables on the DB. The `--seed` argument will also add some test data;
- In the Apache configuration file, change the document root folder to `path/to/repo/public/` (you may also setup a virtual host);
- You're all set up! Give it a go on `localhost`. You can now login with the e-mail "admin@mail.com" and password "admin".

#License
This project is licensed unser Apache License Version 2.
