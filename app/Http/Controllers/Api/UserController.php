<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $module = 'User';
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    function index(): JsonResponse
    {
        $data = $this->userRepository->all();

        return response()->json([
            'status'  => 'success',
            'data'    => $data,
            'message' => "{$this->module} data fetched successfully."
        ]);
    }

    function me(): JsonResponse
    {
        $data = auth()->user();

        return response()->json([
            'status'  => 'success',
            'data'    => $data,
            'message' => "{$this->module} data fetched successfully."
        ]);
    }
}
