# Destruktiv - A non-social social site

[![GitHub release (latest by date)](https://img.shields.io/github/v/release/amusablelemur/destruktiv)](https://github.com/AmusableLemur/Destruktiv/releases)

## Setup & Installation

### Configuration

Copy .env to .env.local and change the settings to match your local environment.

    $ cp .env .env.local && vim .env.local

### Dependencies

This project uses [Composer](https://getcomposer.org/) and [Yarn](https://yarnpkg.com/) to manage dependencies. Run the following commands to install or update necessary dependencies.

    $ composer install
    $ yarn install

### Database

The database is managed by Doctrine ORM. Run the migrations to bring the latest schema up to date.

    $ php bin/console doctrine:database:create
    $ php bin/console doctrine:migrations:migrate

Run the fixtures to get some test data and an admin user. (Warning: this will remove any previous data in the database)

    $ php bin/console doctrine:fixtures:load
