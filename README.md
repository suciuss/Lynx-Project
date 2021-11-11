
# Notes to run the project:

You will need: 
- any IDE ( I’ve used PHPStorm )
- Docker.

All commands exept "composer install" & "./vendor/bin/sail up" need to be run in the docker's php container.

Open that container shell by running: 
```
docker exec -it lynx-project_laravel.test_1 sh
```
These commands are:



1. Clone git repository

2. Open project in a IDE and run in the terminal “composer install”

3. Run in the terminal the command “./vendor/bin/sail up” to build the Docker containers 

4. Open docker's php shell terminal by running the command “docker exec -it lynx-project_laravel.test_1 sh”

5. Run the migrations in the docker’s php shell terminal using the “php artisan migrate” command.

6. Run the seeders in the docker’s php shell terminal: “php artisan db:seed --class=TermsSeeder” and “php artisan db:seed --class=UserSeeder”

7. Open the app on the following link: http://0.0.0.0/

8. Open MailHog on the following link: http://0.0.0.0:8025/

9. Register your user and confirm your e-mail on MailHog.

10. Explore the app.
