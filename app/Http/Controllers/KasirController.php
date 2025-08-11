<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class KasirController extends Controller
{
    //
    public function index(){
        $cart = Session::get('cart', []);
        $product = Product::all();
        $total = array_sum(array_column($cart, 'subtotal'));

        return view('kasir', compact('cart', 'product', 'total'));
    }

    public function addToChart(Request $request){
        $product = Product::where('barcode', $request->barcode)->first();

        if(!$product){
            return back()->with('error', 'Produk tidak valid ');
        }

        $cart = session::get('cart', []);

        if(isset($cart[$product->id])){
            $quantity = $cart[$product->id]['quantity'] + 1;
        }else{
            $quantity = 1;
        }

        if ($quantity > $product->stok) {
            return back()->with('error', 'Stok Produk kurang.');
        }

        $subtotal = $product->harga * $quantity;

        $cart[$product->id] = [
            'id' => $product->id,
            'name' => $product->nama,
            'price' => $product->harga,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
        ];

        session::put('cart', $cart);
        return back()->with('success', 'Produk ditambahkan ke keranjang.', );
    }

    public function checkout(Request $request) {
        $cart = session::get('cart', []);
        $total = array_sum(array_column($cart, 'subtotal'));
        $paid = (int) $request->paid_amount;
        $dueAmount = $total - $paid;

        $status = $dueAmount > 0 ? 'on_credit' : 'paid';

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'invoice_number' => 'INV-' . now()->format('YmdHis'),
            'total_price' => $total,
            'paid_amount' => $paid,
            'change_amount' => $paid >= $total ? $paid - $total : 0,
            'status' => $status,
            'due_amount' => $dueAmount > 0 ? $dueAmount : 0,
        ]);

        foreach ($cart as $item){
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);

            Product::find($item['id'])->decrement('stok', $item['quantity']);
        };

       

        $detail = Transaction::where('id', $transaction->id)->get();

        Session::forget('cart');
        return redirect()->route('kasir')->with(['showModal' => true, 'detail' => $detail,]);
    }

    public function editQuantity(Request $request, string $id) {
        $product = Product::where('id', $id)->first();
        $cart = Session::get('cart', []);

        if($request->quantity > $product->stok){
            return back()->with('error', 'Error, Stok Product '. $product->stok);
        }

        $cart[$id]['quantity'] = $request->quantity;
        $cart[$id]['subtotal'] = $cart[$id]['price'] * $request->quantity;

        Session::put('cart', $cart);

        return back();
    }

    public function removeToChart($id){
        $cart = Session::get('cart', []);

        if(isset($cart[$id])){
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return back();
    }

}
