<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::where('status', 'paid')->latest()->paginate(10);
        $kasbons = Transaction::where('status', 'on_credit')->latest()->paginate(10);
        return view('transaksi', compact('transactions', 'kasbons'));
    }

    public function transactionDetail($id)
    {
        $transaction = Transaction::with('detail')->where('id', $id)->first();
        return view('transaction.transaction-detail', compact('transaction'));
    }

    public function showPayForm()
    {
        
        return back()->with('modalPayForm' , true);
    }

    public function payOffKasbon($id , Request $request)
    {
        $transaction = Transaction::find($id);

        $validated = $request->validate([
            'payment' => 'required|integer|min:0',
        ]);

        $transaction->update([
            'paid_amount' => $transaction->paid_amount + $validated['payment'],
            'due_amount' => max(0, $transaction->due_amount - $validated['payment']),
            'status' => $transaction->due_amount - $validated['payment'] <= 0 ? 'paid' : 'on_credit',
            'change_amount' => ( $transaction->due_amount - $validated['payment'] ) < 0 ? $validated['payment'] - $transaction->due_amount : 0,
            
        ]);

        return redirect()->route('transaksi.detail', $transaction->id);
    }

}
