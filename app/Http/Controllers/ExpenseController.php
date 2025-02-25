<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $thisWeekIncome = Transaction::whereBetween('transaction_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('type', 'income')
            ->sum('amount');

        $lastWeekIncome = Transaction::whereBetween('transaction_date', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->where('type', 'income')
            ->sum('amount');

        $thisWeekExpense = Transaction::whereBetween('transaction_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('type', 'expense')
            ->sum('amount');

        $lastWeekExpense = Transaction::whereBetween('transaction_date', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->where('type', 'expense')
            ->sum('amount');

        // Tính tổng balance tuần này và tuần trước
        $thisWeekBalance = $thisWeekIncome - $thisWeekExpense;
        $lastWeekBalance = $lastWeekIncome - $lastWeekExpense;

        // Tính phần trăm thay đổi
        $incomeChange = $lastWeekIncome != 0 ? (($thisWeekIncome - $lastWeekIncome) / $lastWeekIncome) * 100 : 0;
        $expenseChange = $lastWeekExpense != 0 ? (($thisWeekExpense - $lastWeekExpense) / $lastWeekExpense) * 100 : 0;
        $balanceChange = $lastWeekBalance != 0 ? (($thisWeekBalance - $lastWeekBalance) / $lastWeekBalance) * 100 : 0;

        // Lấy danh sách các loại giao dịch
        $categories = Transaction::select('category')
            ->distinct()
            ->get()
            ->pluck('category');

        $categoryComparisons = [];

        foreach ($categories as $category) {
            $totalCategoryIncome = Transaction::where('type', 'income')
                ->where('category', $category)
                ->sum('amount');

            $totalCategoryExpense = Transaction::where('type', 'expense')
                ->where('category', $category)
                ->sum('amount');

            $categoryComparisons[$category] = [
                'totalIncome' => $totalCategoryIncome,
                'totalExpense' => $totalCategoryExpense,
                'colorCode' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            ];
        }

        // Dữ liệu biểu đồ earnings (12 tháng)
        $monthlyEarnings = Transaction::selectRaw('YEAR(transaction_date) as year, MONTH(transaction_date) as month, 
            SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income,
            SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense')
            ->where('transaction_date', '>=', now()->startOfYear())
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return view('admin.pages.expense.index', compact(
            'thisWeekIncome',
            'lastWeekIncome',
            'thisWeekExpense',
            'lastWeekExpense',
            'thisWeekBalance',
            'lastWeekBalance',
            'incomeChange',
            'expenseChange',
            'balanceChange',
            'monthlyEarnings',
            'categoryComparisons'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
