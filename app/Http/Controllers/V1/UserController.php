<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Services\UserService;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {
        $this->setupLogger('user_controller_new');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse {
        $data = [
          'name' => 'LoopNBit',
          'age' => 1 
        ];

        $this->logger->info('User log.', $data);
        try {
            //code...
            $data = $this->userService->test($data);
        } catch (\Throwable $th) {
            //throw $th;
            $log = [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'function' => $th->getTrace()[0]['function'] ?? null,
            ];

            $this->logger->error('User controller catch', $log);
        }



        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
