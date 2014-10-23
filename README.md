Hexagonal Symfony
=================

Welcome to the Hexagonal Symfony. This is a sandbox for experimenting with Cockburn's hexagonal ideas with Symfony2.

Note: this is work in progress, your PR is welcome!

Installation
------------

Download [composer](http://getcomposer.org/), add it to your path, go to the root of the project and run:

    composer.phar install

This installs the project dependencies like Symfony2. Next create a database, a database schema and load the fixtures.

    app/console doctrine:database:create
    app/console doctrine:schema:create
    app/console doctrine:fixtures:load

The only fixture that is loaded is a Project Manager with login "everzet" and password "qwerty".

For the ease of use, this application can be used with Vagrant with:

    vagrant up

Features
--------

The core of this application is a project management system. The features are "documented" in the tests.
You can run the tests with behat:

    bin/behat

There are also phpspec tests. Run them with:

    bin/phpspec --format=pretty

See also
--------

- [Doucheswag](https://github.com/igorw/doucheswag/) a silex based hexagonal application.
- [Cockburn's hexagonal](http://alistair.cockburn.us/Hexagonal+architecture) explains the architecture.
- [SymfonyLive London 2013 - Marcello Duarte & Konstantin Kudryashov - The Framework as an implementation detail](https://www.youtube.com/watch?v=0L_9NutiJlc) accompanying presentation 
