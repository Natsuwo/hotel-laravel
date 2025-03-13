<?php

namespace App\Http\Controllers;

use App\Http\Requests\Coupons\StoreRequest;
use App\Http\Requests\Coupons\UpdateRequest;
use App\Models\Coupons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 10;
        $coupons = Coupons::paginate($perPage);
        return view('admin.pages.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Coupons::create($request->validated());
        return redirect()->route('admin.coupon.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $coupon = Coupons::with('couponItems.invoice', 'couponItems.guest', 'couponItems.invoice.reservation')
            ->findOrFail($id);
        return view('admin.pages.coupon.show', compact('coupon'));
    }

    public function getOne(string $id)
    {
        $coupon = Coupons::where('code', $id)
            ->where('status', '1')
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon not found'
            ]);
        }

        if ($coupon->start_date && $coupon->start_date > now()) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon is not yet valid'
            ]);
        }

        if ($coupon->end_date && $coupon->end_date < now()) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has expired'
            ]);
        }

        if ($coupon->usage_limit > 0 && $coupon->usage_count >= $coupon->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has reached its maximum usage limit'
            ]);
        }

        $guest = Auth::guard('guest')->user();

        if ($coupon->usage_per_user > 0) {
            $totalUserUsage = $coupon->couponItems()
                ->where('guest_id', $guest->id)
                ->where('coupon_id', $coupon->id)
                ->count();

            if ($totalUserUsage >= $coupon->usage_per_user) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have reached the maximum usage limit for this coupon'
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $coupon
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupons::findOrFail($id);
        return view('admin.pages.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $coupon = Coupons::findOrFail($id);
        $coupon->update($request->validated());
        return redirect()->route('admin.coupon.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Coupons::destroy($id);
        return redirect()->route('admin.coupon.index');
    }
}
