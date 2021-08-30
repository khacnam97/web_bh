<?php


namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\services\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Woo\GridView\DataProviders\EloquentDataProvider;

/**
 * Class UserController
 * @package App\Http\Controllers
 * @property UserService userService
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }

    /**
     * @return Application|Factory|View
     */
    public function userIndex() {
        $data = $this->userService->getFirstPage();
        return view('user/index',['data' => $data]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userList(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->userService->getUsers($request));
    }

    /**
     * @return Application|Factory|View
     */
    public function getCreate() {
        $roles = $this->userService->getRole();
        return view('user/create', ['roles' => $roles]);
    }

    /**
     * @param UserRequest $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function postCreate(UserRequest $request)
    {
        try {
            $check = $this->userService->store($request);
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
        return redirect()->route('user.index')->with('info', __('common.Create Success'));
    }

    /**
     * @param $id
     * @return string
     */
    public function delete(int $id)
    {
        try {
            if(auth()->id() !== $id) {
                $check = $this->userService->delete($id);
                if(!$check){
                    return response()->json(
                        array(
                            'message' => __('common.Server Error'),
                            'status'  => 500,
                        ), 500);
                }
            }
            else{
                return response()->json(
                    array(
                        'message' => __('common.Do not have permission to delete'),
                        'status'  => 403,
                    ), 403);
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
     * @param $id
     * @return string
     */
    public function restore(int $id)
    {
        try {
            if(auth()->id() !== $id) {
                $check = $this->userService->restore($id);
                if(!$check){
                    return response()->json(
                        array(
                            'message' => __('common.Server Error'),
                            'status'  => 500,
                        ), 500);
                }
            }
            else{
                return response()->json(
                    array(
                        'message' => __('common.Do not have permission to delete'),
                        'status'  => 403,
                    ), 403);
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
            'message' => __('common.Active Success')
        ], 200);
    }

    /**
     * @param $id
     * @return string
     */
    public function trash(int $id)
    {
        try {
            if(auth()->id() !== $id) {
                $check = $this->userService->trash($id);
                if(!$check){
                    return response()->json(
                        array(
                            'message' => __('common.Server Error'),
                            'status'  => 500,
                        ), 500);
                }
            }
            else{
                return response()->json(
                    array(
                        'message' => __('common.No disable permission'),
                        'status'  => 403,
                    ), 403);
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
            'message' => __('common.Trash Success')
        ], 200);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function getEdit($id){
        $data['user'] = $this->userService->findUser($id);
        $data['roles'] = $this->userService->getRole();
        return view('user/edit',['data' => $data]);
    }
    /**
     * @param UserRequest $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function postEdit(UserRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            if(auth()->id() !== $id) {
                $check = $this->userService->update($request,$id);
                if(!$check){
                    return view('errors.error-admin', [
                        'message' =>  __('validation.An error has occurred on the server.'),
                        'code' => 500
                    ]);
                }
                DB::commit();
            }
            else {
                return back()->with('error', __('user.Error Edit'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return view('errors.error-admin', [
                'message' =>  __('validation.An error has occurred on the server.'),
                'code' => 500
            ]);
        }
        return redirect()->route('user.index')->with('info', __('common.Edit Success'));
    }

    /**
     * @return Application|Factory|View
     */
    public function getProfile() {
        $data = $this->userService->findUser(auth()->user()->id);
        return view('user/profile',['data' => $data]);
    }

    /**
     * @param UserRequest $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function postProfile(UserRequest $request, int $id)
    {
        try {
            $check = $this->userService->update($request, $id);
            if(!$check) {
                return view('errors.base', [
                    'message' =>  __('validation.An error has occurred on the server.'),
                    'code' => 500
                ]);
            }
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return view('errors.base', [
                'message' =>  __('validation.An error has occurred on the server.'),
                'code' => 500
            ]);
        }
        if ($this->userService->findUser($id)->hasRole('admin')) {
            return redirect()->route('user.index')->with('info', __('common.Edit Success'));
        }
        return redirect()->route('get-analyze')->with('info', __('common.Edit Success'));
    }

    public function example(Request $request)
    {
//        dd($request->all());
        $dataProvider = new EloquentDataProvider(User::query());

        return view('user.example-view', [
            'dataProvider' => $dataProvider
        ]);
    }
}
