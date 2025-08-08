<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\RoomAssignment;
use App\Models\Tenant;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with summary statistics.
     */
    public function index()
    {
        // Get current month's data
        $currentMonth = now()->format('Y-m');
        
        $stats = [
            'total_boarding_houses' => BoardingHouse::count(),
            'total_rooms' => Room::count(),
            'occupied_rooms' => Room::where('status', 'occupied')->count(),
            'vacant_rooms' => Room::where('status', 'vacant')->count(),
            'total_tenants' => Tenant::active()->count(),
            'current_month_bills' => Bill::forCurrentMonth()->count(),
            'current_month_income' => Bill::forCurrentMonth()->paid()->sum('amount'),
            'pending_bills' => Bill::pending()->count(),
            'overdue_bills' => Bill::overdue()->count(),
        ];

        // Recent activities
        $recentBills = Bill::with(['roomAssignment.tenant', 'roomAssignment.room.boardingHouse'])
            ->latest()
            ->limit(5)
            ->get();

        $recentTenants = Tenant::with(['activeAssignment.room.boardingHouse'])
            ->latest()
            ->limit(5)
            ->get();

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'recentBills' => $recentBills,
            'recentTenants' => $recentTenants,
        ]);
    }
}