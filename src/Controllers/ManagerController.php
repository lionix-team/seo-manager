<?php

namespace Lionix\SeoManager\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Input; // Outdated in Laravel 6
use Illuminate\Support\Facades\Schema;
use Lionix\SeoManager\Models\SeoManager as SeoManagerModel;
use Lionix\SeoManager\Models\Translate;
use Lionix\SeoManager\Traits\SeoManagerTrait;

class ManagerController extends Controller
{
    use SeoManagerTrait;

    protected $locale;

    public function __construct(Request $request)
    {
        if($request->get('locale')){
            app()->setLocale($request->get('locale'));
            $this->locale = app()->getLocale();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('seo-manager::index');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoutes()
    {
        $routes = SeoManagerModel::all();
        return response()->json(['routes' => $routes]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getModels()
    {
        try {
            $models = $this->getAllModels();
            return response()->json(['models' => $models]);
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getModelColumns(Request $request)
    {
        try {
            $model = $request->get('model');
            $columns = $this->getColumns($model);
            return response()->json(['columns' => $columns]);
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeData(Request $request)
    {
        $allowedColumns = Schema::getColumnListing(config('seo-manager.database.table'));
        try {
            $id = $request->get('id');
            $type = $request->get('type');
            $seoManager = SeoManagerModel::find($id);
            if (in_array($type, $allowedColumns)) {
                $data = $request->get($type);
                if($type != 'mapping' && $this->locale !== config('seo-manager.locale')){
                    $translate = $seoManager->translation()->where('locale', $this->locale)->first();
                    if(!$translate){
                        $newInst = new Translate();
                        $newInst->locale = $this->locale;
                        $translate = $seoManager->translation()->save($newInst);
                    }
                    $translate->$type = $data;
                    $translate->save();
                }else{
                    $seoManager->$type = $data;
                    $seoManager->save();
                }
            }
            return response()->json([$type => $seoManager->$type]);
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExampleTitle(Request $request)
    {
        $route = $request->get('route');
        try {
            $manager = SeoManagerModel::find($route['id']);
            $titles = $route['title_dynamic'];
            $exampleTitle = $this->getDynamicTitle($titles, $manager);
            return response()->json(['example_title' => $exampleTitle]);
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteRoute(Request $request)
    {
        try {
            SeoManagerModel::destroy($request->id);
            return response()->json(['deleted' => true]);
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return array|null
     */
    public function sharingPreview(Request $request)
    {
        $id = $request->get('id');
        $seoManager = SeoManagerModel::find($id);
        if(is_null($seoManager)){
            return null;
        }
        $ogData = $this->getOgData($seoManager, null);
        return response()->json(['og_data' => $ogData]);
    }
}
