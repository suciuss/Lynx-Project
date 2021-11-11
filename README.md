
# Notes to run the project:

You will need: 
- Docker

Follow the steps:

1. Open terminal and go to the folder where you want to clone the repository and then paste this:
```
git clone git@github.com:suciuss/Lynx-Project.git
```

2. Go to the Lynx-Project folder in the terminal and paste:
```
composer install
```

3. Paste this command in order to build the Docker containers:
```
./vendor/bin/sail up
```

4. Open docker's php shell by running the command:
```
docker exec -it lynx-project_laravel.test_1 sh
```

## All the following commands will be ran in the shell


5. Paste this command to run the migrations for the database:
```
php artisan migrate
```

6. Run the seeders with these commands (run the TermsSeeder first):
```
php artisan db:seed --class=TermsSeeder
php artisan db:seed --class=UserSeeder
```

7. Open the app on the following link: http://0.0.0.0/

8. Open MailHog on the following link: http://0.0.0.0:8025/

9. Register your user and confirm your e-mail on MailHog.

10. Explore the app.

#### Commands to unverify a user's email & to delede Terms that are published and not accepted by anyone are (run those in the docker shell):
```
php artisan unverify:user {userId}

php artisan delete-old:terms
```
