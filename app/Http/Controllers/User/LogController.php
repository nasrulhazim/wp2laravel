<?php

namespace WPTL\Http\Controllers\User;

use WPTL\Http\Controllers\Controller;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke()
    {
        $logs = auth()->user()->activity->sortByDesc('created_at');
        return view('users.log', compact('logs'));
    }
}
