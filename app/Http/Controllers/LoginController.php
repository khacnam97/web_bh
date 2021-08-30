<?php


namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

/**
 * Class UserController
 * @package App\Http\Controllers
 * @property UserService userService
 */
class LoginController extends Controller
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
     * @return Application|Factory|View|RedirectResponse
     */
    public function getLogin()
    {
        if(Auth::check()) {
            if (auth()->user()->hasRole('admin')) {
                return redirect()->route('user.index');
            }
            return view('page');
        }
        return view('auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(LoginRequest $request)
    {
        $username = $request->username;
        $credentials = $request->except(['_token']);
        if (auth()->attempt($credentials)) {
            if(auth()->user()->hasRole('admin')) {
                return redirect()->route('user.index');
            }
            return view('page');
        }
        return back()->with(['msg' => __('user.Message Error'), 'username' => $username]);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return view('page');
    }

    /**
     * @return Application|Factory|View
     */
    public function getChangePassword(){
        return view('auth/change-password');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return RedirectResponse
     */
    public function postChangePassword(ChangePasswordRequest $request): RedirectResponse
    {
       $this->userService->updatePassword($request);
        return  redirect()->route('logout');
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * @param RegisterRequest $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function postRegister(RegisterRequest $request)
    {
        try {
            $roleDis = Role::findByName('distribution center');
            $request['role_id'] = $roleDis->id;
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
        return view('page')->with('info', __('common.Create Success'));
    }
}
