<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AuthController;
use App\Oms\User\Manager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class GetPresentUsersByDate
 * @package App\Http\Controllers\User
 */
class GetPresentUsersByDate extends AuthController
{
    /**
     * @param Request $request
     * @param Manager $userManager
     * @return JsonResponse
     */
    public function __invoke(Request $request, Manager $userManager)
    {
        $details = $request->validate([
           'date' => 'required|date'
        ]);

        return new JsonResponse($userManager->getPresentUsersByDate($details));
    }
}