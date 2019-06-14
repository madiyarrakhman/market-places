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
add('shared_files', ['storage']);
add('shared_dirs', ['.env']);

// Writable dirs by web server 
add('writable_dirs', []);

// Hosts
host('178.57.217.90')
    ->user('root')
    ->set('deploy_path', '/var/www/market-places');
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

after('deploy', 'reload:php-fpm');
after('deploy', 'deploy:flush_config');
after('rollback', 'reload:php-fpm');
after('rollback', 'deploy:flush_config');

