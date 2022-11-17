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

Apply all the migrations and seed the data - you'll likely have to create `.env` file, just make sure it's never 
committed into git repository, because it often contains data such as passwords to the database 
and so on.

```
php artisan migrate:fresh --seed
```

When pulling commits changing database structure or seeds, make sure to apply migrations as well.

To launch the development servers, execute

```
php artisan serve
npm run dev
```
