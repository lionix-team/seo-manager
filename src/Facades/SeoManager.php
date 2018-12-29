<?php
/**
 * Created by PhpStorm.
 * User: sergeykarakhanyan
 * Date: 12/23/18
 * Time: 13:54
 */

namespace Lionix\SeoManager\Facades;


use Illuminate\Support\Facades\Facade;

class SeoManager extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'seomanager';
    }
}
