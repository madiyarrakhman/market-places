<?php
/**
 * Created by PhpStorm.
 * User: madiyar
 * Date: 2019-06-12
 * Time: 22:25
 */

namespace App\Console\Commands;


use App\Providers\PrestaShopServiceProvider;
use http\Client\Request;
use Illuminate\Console\Command;

class ProductCommand extends Command
{
    protected $name = 'Product';

    public function handle()
    {
        $fa = new PrestaShopServiceProvider('GET', 'https://api.github.com/user');

        $response = $fa->response;
    }
}
