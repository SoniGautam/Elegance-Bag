<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $old_cartitems = Cart::where('user_id', Auth::id())->get();
        $cartitems = Cart::where('user_id', Auth::id())->get();
        return view('frontend.checkout', compact('cartitems'));
    }

     public function placeorder(Request $request)
     {
        $order = new Order();
        $order->user_id = Auth::id();
        $order->fname = $request->input('fname');
        $order->lname = $request->input('lname');
        $order->email = $request->input('email');
        $order->phone = $request->input('phone');
        $order->address1 = $request->input('address1');
        $order->address2 = $request->input('address2');
        $order->city = $request->input('city');
        $order->state = $request->input('state');
        $order->pincode = $request->input('pincode');
        $order->tracking_no = 'abcd'.rand(1111,9999);
        $order->save();

        $order->id;

        $cartitems = Cart::where('user_id', Auth::id())->get();
        foreach($cartitems as $item)
        {
            OrderItem::create([
                'order_id'=> $order->id,
                'prod_id'=> $item->prod_id,
                'qty'=> $item->prod_qty,
                'price'=> $item->products->selling_price,
            ]);
        }

        if (Auth::user()->address1 == NULL) {
            $user = User::where('id', Auth::id())->first(); // Add the ->first() method
            $user->name = $request->input('fname');
            $user->lname = $request->input('lname');
            $user->phone = $request->input('phone');
            $user->address1 = $request->input('address1');
            $user->address2 = $request->input('address2');
            $user->city = $request->input('city');
            $user->state = $request->input('state');
            $user->pincode = $request->input('pincode'); // Fix the variable name from $resquest to $request
            $user->update();
        }

        $cartitems = Cart::where('user_id', Auth::id())->get();
        Cart::destroy($cartitems);
        return redirect('/')->with('status', "Order Placed Successfully");
        
     }
}
