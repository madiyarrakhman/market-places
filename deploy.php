<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'marketplaces');

// Project repository
set('repository', 'git@github.com:madiyarrakhman/market-places.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', ['.env']);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);

// Hosts
host('178.57.217.90')
    ->user('root')
    ->set('deploy_path', '/var/www/market-places');
    
// Tasks

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);

task('build', function () {
    run('cd {{release_path}} && build');
});

task('reload:php-fpm', function () {
    run('sudo /usr/sbin/service php-fpm reload');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

//before('deploy:symlink', 'artisan:migrate');

after('deploy', 'reload:php-fpm');
after('rollback', 'reload:php-fpm');

