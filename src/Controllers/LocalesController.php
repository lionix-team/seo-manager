<?php

namespace Lionix\SeoManager\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lionix\SeoManager\Models\Locale;

class LocalesController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocales()
    {
        $locales = Locale::pluck('name');
        return response()->json(['locales' => $locales]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addLocale(Request $request)
    {
        try{
            $locale = Locale::whereName($request->get('name'))->first();
            if(!$locale){
                $locale = new Locale();
                $locale->fill($request->all());
                $locale->save();
                return response()->json(['locale' => $locale->name]);
            }
            throw new \Exception('Locale is already exist');
        }catch (\Exception $exception){
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 400);
        }
    }
}
