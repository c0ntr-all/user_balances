<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $user = auth()->user()->load('balance');

        return response(new UserResource($user));
    }
}
