<?php


namespace App\Http\Controllers;

use App\Http\Requests\ScriptRequest;
use App\services\ScriptService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class ScriptController
 * @package App\Http\Controllers
 * @property ScriptService scriptService
 */
class ScriptController extends Controller
{
    /**
     * UserController constructor.
     * @param ScriptService $service
     */
    public function __construct(ScriptService $service)
    {
        $this->scriptService = $service;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(){
        $data['listScript'] = $this->scriptService->getFirstPage();
        $data['listActive'] = $this->scriptService->listActive();
        return view('script/index',['data' => $data]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        return response()->json($this->scriptService->getScripts($request));
    }

    /**
     * @return Application|Factory|View
     */
    public function getCreate() {
        return view('script/create');
    }

    /**
     * @param ScriptRequest $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function postCreate(ScriptRequest $request)
    {
        try {
            $check = $this->scriptService->store($request);
            if(!$check) {
                return view('errors.error-admin', [
                    'message' =>  __('validation.An error has occurred on the server.'),
                    'code' => 500
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return view('errors.error-admin', [
                'message' =>  __('validation.An error has occurred on the server.'),
                'code' => 500
            ]);
        }
        return redirect()->route('script.index')->with('info', __('common.Create Success'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function getEdit($id){
        $data = $this->scriptService->findScript($id);
        return view('script/edit',['data' => $data]);
    }

    /**
     * @param ScriptRequest $request
     * @param int $id
     * @return Application|Factory|View|RedirectResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function postEdit(ScriptRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            $check = $this->scriptService->update($request,$id);
            if(!$check){
                return view('errors.error-admin', [
                    'message' =>  __('validation.An error has occurred on the server.'),
                    'code' => 500
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return view('errors.error-admin', [
                'message' =>  __('validation.An error has occurred on the server.'),
                'code' => 500
            ]);
        }
        return redirect()->route('script.index')->with('info', __('common.Edit Success'));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $check = $this->scriptService->delete($id);
            if(!$check){
                return response()->json(
                    array(
                        'message' => __('common.Server Error'),
                        'status'  => 500,
                    ), 500);
            }
        } catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'message' =>  __('validation.An error has occurred on the server.'),
                'code' => 500
            ], 500);
        }
        return response()->json([
            'status' => 200,
            'message' => __('common.Delete Success')
        ], 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function active(int $id)
    {
        DB::beginTransaction();
        try {

            $check = $this->scriptService->active($id);
            $isActive = $this->scriptService->findScript($id)->isActive;
            $isActive ? $message = __('common.Active Success') : $message = __('common.Trash Success');
            if(!$check){
                return response()->json(
                    array(
                        'message' => __('common.Server Error'),
                        'status'  => 500,
                    ), 500);
            }
            DB::commit();
        } catch(\Exception $e){
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json([
                'message' =>  __('validation.An error has occurred on the server.'),
                'code' => 500
            ], 500);
        }
        return response()->json([
            'status' => 200,
            'script' => $this->scriptService->findScript($id),
            'countScript' => count($this->scriptService->listActive()),
            'message' => $message
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function sort(Request $request) {
        DB::beginTransaction();
        try {
            $check = $this->scriptService->sort($request);
            if (!$check) {
                return response()->json(
                    array(
                        'message' => __('common.Server Error'),
                        'status' => 500,
                    ), 500);
            }
            DB::commit();
        } catch(\Exception $e){
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json([
                'message' =>  __('validation.An error has occurred on the server.'),
                'code' => 500
            ], 500);
        }
        return response()->json([
            'status' => 200,
            'message' => __('script.Sort Success')
        ], 200);
    }
}
