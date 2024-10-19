<?php

namespace App\Interfaces\Controllers;

use App\UseCases\Interactors\RegisterUserInteractor;
use App\Interfaces\Presenters\UserPresenter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    private RegisterUserInteractor $interactor;
    private UserPresenter $presenter;

    public function __construct(RegisterUserInteractor $interactor, UserPresenter $presenter)
    {
        $this->interactor = $interactor;
        $this->presenter  = $presenter;
    }

    public function register(Request $request)
    {
        $data = $request->only(['name', 'email', 'password']);

        try {
            $user = $this->interactor->handle($data);
            $responseData = $this->presenter->format($user);

            return response()->json([
                'message' => 'User registered successfully',
                'data'    => $responseData,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
