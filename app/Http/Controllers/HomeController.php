<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function menu(Request $request, UserService $service)
    {
        $userSession = $request->user();
        $result = $service->getPermissionTree($userSession->id, true);
        // dump($result);
        return $result;
    }

    public function menu_title(Request $request, UserService $service)
    {
        $userSession = $request->user();
        $result = $service->getPermissionList($userSession->id, true, true);
        // dump($result);
        return $result;
    }


}
