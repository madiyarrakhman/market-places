<?php
/**
 * Created by PhpStorm.
 * User: madiyarrakhman
 * Date: 6/13/19
 * Time: 5:34 PM
 */

return [
    'providers' => [
        /*
        * Package Service Providers...
        */
        Maatwebsite\Excel\ExcelServiceProvider::class,

    ],
    'aliases' => [
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
    ]
];