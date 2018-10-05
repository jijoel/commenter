Commenter
===============

This is a very basic website comment system, using [Laravel](https://laravel.com), [Vue](https://vuejs.org), and [Vuetify](https://vuetifyjs.com). It supports markdown comments.

We can add new comments, and reply to existing comments. There's no logins, editing, deleting, moderation, or any of the other things you'd want in an actual production system.

Installation
-------------
It's a simple installation, and includes a basic sqlite database, so should work out of the box. Install with:

    git clone git@github.com:jijoel/commenter.git
    cd commenter
    cp .env.example .env
    composer install
    php artisan key:generate

