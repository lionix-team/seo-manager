<?php

namespace Lionix\SeoManager\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Lionix\SeoManager\Traits\SeoManagerTrait;

class ImportController extends Controller
{
    use SeoManagerTrait;

    /**
     * Import routes to the SeoManager database table
     * @return \Illuminate\Http\JsonResponse
     */

    public function __invoke()
    {
        try {
            $routes = $this->importRoutes();
            return response()->json(['routes' => $routes]);
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }
    }
}
