<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalNews = News::count();
        $totalNewsAccepted = News::where('status', '==', 'Accept')->count();
        $totalNewsNotAccepted = News::where('status', '!=', 'Accept')->count();

        // Chart JS
        $usersPerMonth = [];
        $newsPerMonth = [];

        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = Carbon::create(null, $month)->startOfMonth();
            $endOfMonth = Carbon::create(null, $month)->endOfMonth();

            $usersPerMonth[] = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $newsPerMonth[] = News::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        }

        $currentMonth = Carbon::now()->month;
        $totalUsersCurrentMonth = $usersPerMonth[$currentMonth - 1];
        $totalNewsCurrentMonth = $newsPerMonth[$currentMonth - 1];

        return view('dashboard', compact(
            'totalUsers',
            'totalNews',
            'totalNewsNotAccepted',
            'totalNewsAccepted',
            'currentMonth',
            'usersPerMonth',
            'newsPerMonth',
            'totalUsersCurrentMonth',
            'totalNewsCurrentMonth'
        ));
    }
}
