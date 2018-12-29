<?php

namespace Lionix\SeoManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Lionix\SeoManager\Models\SeoManager;
use Lionix\SeoManager\Traits\SeoManagerTrait;

class ManagerController extends Controller
{
    use SeoManagerTrait;

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
        $routes = SeoManager::all();
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
            $seoManager = SeoManager::find($id);
            if (in_array($type, $allowedColumns)) {
                $data = $request->get($type);
                $seoManager->$type = $data;
                $seoManager->save();
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
        try {
            $manager = SeoManager::find($request->id);
            $titles = $request->get('title_dynamic');
            $exampleTitle = $this->getDynamicTitle($titles, $manager);
            return response()->json(['example_title' => $exampleTitle]);
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);

        }
    }

    public function deleteRoute(Request $request)
    {
        try {
            SeoManager::destroy($request->id);
            return response()->json(['deleted' => true]);
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);

        }
    }
}
