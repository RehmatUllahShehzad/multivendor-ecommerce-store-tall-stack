# Installation Instructions

1. Clone Repository from bitbucket.

2. Copy .env.example to .env file on root.

3. Copy docker directory to .docker.

4. Update .docker/.env file with your custom ports and db credentials. (Note: DB credentials set here will be used first time to setup new database).

5. Update .env on root with proper db credentials.
    a. Database Host must be db.
    b. User name will be root.
    c. Database name will be same as you defined in .docker/.env.
    d. Database password will be same as you defined in .docker/.env.
6. Cd into .docker directory.

7. Run `docker-compose build` command.

8. Once build process completed run `docker-compose up -d`.

9. Access your app on browser with <http://localhost>:{PORT} from .docker/.env}

10. To run any commands on php artisan open docker shell by running `docker exec -u docker_app_user -it {project name from .docker/.env}_php_service bash`.

## Post Installation Instructions

### Generate Application Key

Run `php artisan key:generate`

### Migrate Database

Run `php artisan migrate` to create database tables;

### Update Permissions

Run `php artisan system:update-permissions` to update permissions in database;

### Create Admin user

Run `php artisan db:see --class DefaultAdminSeeder`
