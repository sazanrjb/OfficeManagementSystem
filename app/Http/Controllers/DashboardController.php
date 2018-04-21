<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class DashboardController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|View
     */
	public function __invoke()
	{
        return view('oms.pages.dashboard');
	}
}
