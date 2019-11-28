<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Product;
use App\TransactionDetail;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['transactionDetail', 'customer'])->get();

        return response()->json([
            'transactions' => $transactions,
        ], 200);
    }

    public function store()
    {
        $data = collect(request()->all())->collapse();

        $subtotal = $data['subtotal'];
        $discount_harga = $subtotal * ($data['discount']/100);
        $total = $subtotal - $discount_harga;


        $transaction = Transaction::create([
            'customer_id' => $data['customer_id'],
            'user_id' => $data['user_id'],
            'discount' => $data['discount'],
            'subtotal' => $subtotal,
            'discount_harga' => $discount_harga,
            'total' => $total,
        ]);

        foreach ($data['cart'] as $key => $value) {
            TransactionDetail::create([
                'transaction_id' => $transaction['id'],
                'product_id' => $value['id'],
                'price' => $value['price'],
                'qty' => $value['qty'],
                'subtotal' => $value['price'] * $value['qty'],
            ]);

            Product::find($value['id'])->decrement('stock', $value['qty']);
        }

        return response()->json([
            'cart' => $data['cart'],
            'transaction' => $transaction,
        ], 200);
    }

    public function show($id = null)
    {
        $transaction = Transaction::with('user')->find($id);
        $subtotal = TransactionDetail::where('transaction_id', $id)->sum('subtotal');
        $total_qty = TransactionDetail::where('transaction_id', $id)->sum('qty');

        return view('print', compact('transaction', 'subtotal', 'total_qty'));
    }
}
