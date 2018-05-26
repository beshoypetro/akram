<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePre_orderRequest;
use App\Http\Requests\UpdatePre_orderRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Order;
use App\Models\PreOrder;
use App\Models\products;
use App\Notifications\Notify;
use App\User;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PreOrderController extends AppBaseController
{
    /** @var  Pre_orderRepository */

    public function __construct()
    {
        $this->middleware('auth');

    }
    public function confirmation(Request $request)
    {
        $total_price = 0 ;
        $products = array();
        foreach($request->productId as $id)
        {
            $product = products::find($id);
            array_push($products , $product);
            $price = $product->price;
            $total_price += $price;
        }
        return view('pre_orders.index',compact('total_price' , 'products'));
    }
    public function saveOrder(Request $request)
    {
//        dd($request->toArray());
        $user = User::find($request->user_id);
        $order = Order::create([
            'name'        => $user->name,
            'price'       => $request->price,
            'discription' => $user->address.$user->address_specific,
            'user_id'     => $user->id,
            'store_id'    => $request->store_id
        ]);
        foreach ($request->products as $product)
        {
            $preProduct = PreOrder::create([
                'product_id'  => $product,
                'user_id'     => $request->user_id,
                'order_id'    => $order->id
            ]);
        }
        $admins = User::where('role_id' , '4')->get();
        foreach ($admins as $admin)
        {
            $admin->notify(new Notify($order , $user));

        }
        return view('pre_orders.show',compact(  'order'));
    }

}
