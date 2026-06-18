<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'      => User::count(),
            'total_products'   => Product::count(),
            'total_categories' => Category::count(),
            'total_orders'     => Order::count(),

            'pending_orders'   => Order::where('status', 'pending')->count(),
            'paid_orders'      => Order::where('status', 'paid')->count(),
            'shipped_orders'   => Order::where('status', 'shipped')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),

            'total_revenue'    => Order::whereIn('status', ['paid', 'shipped', 'completed'])
                ->sum('total_price'),
            'revenue_this_month' => Order::whereIn('status', ['paid', 'shipped', 'completed'])
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_price'),

            'low_stock_products' => Product::where('stock', '<=', 5)->count(),
        ];

        $recent_orders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $top_products = Product::withCount('orders')
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();

        $low_stock_products = Product::with('category')
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'top_products',
            'low_stock_products'
        ));
    }
}
