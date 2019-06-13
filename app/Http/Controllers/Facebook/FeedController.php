<?php
/**
 * Created by PhpStorm.
 * User: madiyarrakhman
 * Date: 6/13/19
 * Time: 4:47 PM
 */

namespace App\Http\Controllers\Facebook;


use App\Exports\Facebook\FeedExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class FeedController extends Controller
{
    public function export()
    {
        return Excel::download(new FeedExport(), 'feed.xlsx');
    }
}