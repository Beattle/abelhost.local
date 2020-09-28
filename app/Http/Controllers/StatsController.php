<?php


namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class StatsController extends Controller
{
    /**
     * @param  \Illuminate\Support\Facades\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $departments = Department::select('name')->
        withCount('users')
            ->get()->toArray();

        return Inertia::render('Stats/Index', [
            'data' => $departments
        ]);
    }

}