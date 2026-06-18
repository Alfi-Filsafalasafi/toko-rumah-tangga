<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // Status yang valid untuk order
    const STATUSES = ['pending', 'paid', 'shipped', 'completed', 'cancelled'];

    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders   = $query->paginate(10)->withQueryString();
        $statuses = self::STATUSES;

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        $statuses = self::STATUSES;

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', self::STATUSES),
        ]);

        // Cegah mengubah order yang sudah selesai/dibatalkan
        if (in_array($order->status, ['completed', 'cancelled'])) {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Order dengan status "' . $order->status . '" tidak dapat diubah.');
        }

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Status order berhasil diperbarui menjadi "' . $validated['status'] . '".');
    }
}
