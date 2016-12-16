<?php

require 'recipe/laravel.php';

server('readonly.demo.jildertmiedema.nl', 'vps8.pimenta.nl', 22)
    ->user('forge')
    ->forwardAgent()
    ->stage('demo')
    ->env('deploy_path', '/home/forge/readonly.demo.jildertmiedema.nl');

set('keep_releases', 10);

task('reload:php-fpm', function () {
    run('sudo /usr/sbin/service php7.0-fpm reload');
});

after('deploy', 'reload:php-fpm');

set('repository', 'git@github.com:jildertmiedema/demo-read-models.git');