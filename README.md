# FastVoting

## Installation

1. Clone this repository.
2. Install the dependencies. Run `composer install` command, then run `npm install` command.
3. Create `.env` file by simply copying the `.env.example` file and rename it.
4. Configure the `.env` file with your **database connection**, **seeder configuration**, **mailer**, etc.
5. Generate the application key with `php artisan key:generate` command.
6. Generate the database structure with this commands based on your preferences:

    - Use **`php artisan migrate`** for [creating / updating the database](https://laravel.com/docs/10.x/migrations).
    - Use **`php artisan db:seed`** for [seeding the database](https://laravel.com/docs/10.x/seeding#running-seeders).
    - Use `php artisan migrate:fresh` for fresh installation.
    - Use `php artisan migrate:fresh --seed` for fresh installation and seeding the database.

    > **Warning!** If you use `php artisan migrate:fresh` command, all tables will be dropped and recreated. **All data in the tables will be lost**.

7. Generate the app resources (public assets, like: styles, scripts, etc.)

    - In **development**, use `npm run dev` command.
    - In **production**, use `npm run prod` command.

    > Note: Before **running in watch mode**, you need to start the application first.

8. Finally, start the application with `php artisan serve` command.

## Installation with Docker

[Laravel Sail](https://laravel.com/docs/10.x/sail) is used to help dockerize this app easily. Laravel Sail is supported on:

-   macOS
-   Linux
-   Windows (via [WSL2](https://learn.microsoft.com/en-us/windows/wsl))

### Prerequisites

To install this application with Docker, you must have Docker running on your machine.

Please go to the [Docker installation guide](https://docs.docker.com/engine/install), select your platform machine, and follow the instructions.

### Docker Services

The [docker-compose.yml](docker-compose.yml) file is used to define the app's services, consist of:

-   `laravel.test` - the app container, which is based on [Laravel Sail's PHP 8.2 image](https://hub.docker.com/r/laravelsail/php82-composer).
-   `mysql` - the database container, which is based on [MySQL Server 8.0 image](https://hub.docker.com/r/mysql/mysql-server/tags?name=8.0).

### Steps

1. Clone this repository.
1. Install the dependencies.

    Move to the application's directory, then execute the following command:

    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs
    ```

    This command will installing the back-end dependencies.

    > See the [Installing Composer Dependencies for Existing Projects](https://laravel.com/docs/10.x/sail#installing-composer-dependencies-for-existing-projects) in Laravel documentation for details.

1. Create `.env` file and configure it
1. Build and start the app

    Run this command:

    ```bash
    ./vendor/bin/sail up -d
    ```

    This command will download and install the container images that defined in [docker-compose.yml](docker-compose.yml) if not exists, then start the app container (include the database container).

    > To **stop the app**, use `./vendor/bin/sail down` command.

1. Accessing the app container from Bash

    After the containers run, you can access the app container from the Bash CLI using this command:

    ```bash
    ./vendor/bin/sail bash
    ```

    Then you can execute any command directly inside the container, like `npm run dev`.

    > See [Executing Commands](https://laravel.com/docs/10.x/sail#executing-sail-commands) in Laravel documentation for details.

1. Install the front-end dependencies

    To install the front-end dependencies, you can use `./vendor/bin/sail npm install` command to execute it from app directory.

    If you have already in the app container (previous step), you can run `npm install` directly.

    > See [Executing Node / NPM Commands](https://laravel.com/docs/10.x/sail#executing-node-npm-commands) in Laravel documentation.

1. Generate the app key
1. Generate the database
1. Generate the app resources
1. Last, open the app

    Open your browser and go to `http://localhost:8000` (or `http://localhost:APP_PORT` if you have changed the `APP_PORT` in `.env` file).
