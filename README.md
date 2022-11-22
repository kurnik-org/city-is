# Smart City IS

## Development setup

Clone the repo. If you're using sail, run

```
./vendor/bin/sail up
```

and maybe you should prefix the following commands with `./vendor/bin/sail`. And maybe not, idk.

Next, install all dependencies by running

```
composer install
npm install
```

Create simlink to the public storage folder and give appropriate read permissions to the folder.

```
php artisan storage:link
sudo chmod 775 -R storage
```

Apply all the migrations and seed the data - you'll likely have to create `.env` file. This file shouldn't be committed
to a git repository, because it contains sensitive data such as password to the database. There's a `.env.example` which
you can use to create your own `.env` file. To do that, execute

```bash
cp .env.example .env
```

and edit the `DB_` config. We recommend setting `DB_CONNECTION=sqlite` and deleting all the other `DB_` config so that
SQLite is used for development. But feel free to use any SQL database system you're comfortable with. To apply those 
migrations, run

```bash
php artisan migrate:fresh --seed
```

When pulling commits changing the database structure or seeds, make sure to apply migrations as well.

To launch the development server, execute

```
php artisan serve
npm run dev
```


## Deployment

The following section describes an example deployment using Digital Ocean's Droplet. One of the ways of doing it is to follow
instructions from [this article](https://blog.devgenius.io/quick-way-to-deploy-a-laravel-app-to-digitalocean-d212f088bcc5).

It's generally a good idea to execute all the instructions, but here are some things it's good to be aware of.

GitHub stopped supporting HTTPS password authentication, so it's recommended to use either SSH or setting up a 
Fine-grained personal access token to perform authentication.

Before executing `compose` commands, we recommend creating
a non-root account using

`sudo useradd --create-home <username>` 

and setting it a password. This user should have a write access on `/var/www/` directory (follow 
[these instructions](https://superuser.com/a/19333) to set it). After that, you can switch to this user by running

`su - <username>`.

This project is using Javascript dependencies, so it's necessary to install them with `npm install` and then
build them by running

```
npm ci
npm run build
```

as mentioned in [the deployment section](https://bootcamp.laravel.com/deploying) of Laravel Bootcamp.
