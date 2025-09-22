<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CardService;
use App\Models\TopUpService;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function getCartList()
    {
        return view(template() . 'frontend.card.cart');
    }

    public function getCartItems()
    {
        $carts = [];
        $subtotal = 0;
        $discount = 0;
        $totalDiscount = 0;
        $totalPrice = 0;
        $totalSubtotal = 0;
        $cartItems = session()->get('cart');
        if (!empty($cartItems)) {
            $reversedCartItems = array_reverse($cartItems);
            foreach ($reversedCartItems as $cart) {
                $carts[] = [
                    "id" => $cart['id'],
                    "name" => $cart['name'],
                    "image" => $cart['image'],
                    "quantity" => $cart['quantity'],
                    "price" => userCurrencyPosition($cart['price']),
                    "actualPrice" => userCurrencyPosition($cart['actualPrice']),
                    "discount" => $cart['discount'] . '' . ($cart['discountType'] == 'flat' ? basicControl()->base_currency : '%'),
                    'totalPrice' => userCurrencyPosition($cart['quantity'] * $cart['price'])
                ];

                $price = $cart['price'] * (int)$cart['quantity'];
                $discount += calculateDiscountAmount($price, $cart['discount'], $cart['discountType']);
                $subtotal += $price;
            }

            $totalPrice = userCurrencyPosition(($subtotal - $discount));
            $totalSubtotal = userCurrencyPosition($subtotal);
            $totalDiscount = userCurrencyPosition($discount);
        }
        return response()->json(['status' => true, 'items' => $carts,
            'totalPrice' => $totalPrice, 'totalSubtotal' => $totalSubtotal, 'totalDiscount' => $totalDiscount]);
    }

    public function addCart(Request $request)
    {
        $service = CardService::where('status', 1)->find($request->serviceId);

        if (!$service) {
            return response()->json(['status' => false, 'message' => 'Service not found']);
        }

        $cart = session()->get('cart', []);
        $serviceId = $service->id;
        $quantity = $request->quantity;

        if (isset($cart[$serviceId])) {
            $cart[$serviceId]['quantity'] += $quantity;
        } else {
            $cart[$serviceId] = [
                "id" => $serviceId,
                "name" => $service->name,
                "image" => $service->imagePath(),
                "quantity" => $quantity,
                "price" => $service->price,
                "actualPrice" => showActualPrice($service),
                "discount" => $service->discount,
                "discountType" => $service->discount_type,
            ];
        }

        session()->put('cart', $cart);
        return response()->json(['status' => true, 'cartCount' => count(session()->get('cart')),
            'message' => 'Product added to cart successfully!']);
    }


    public function quantityUpdate(Request $request)
    {
        $cart = session()->get('cart');
        if (isset($cart[$request->serviceId])) {
            $cart[$request->serviceId]['quantity'] += $request->type;
            session()->put('cart', $cart);
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false, 'message', 'Something went wrong']);
    }

    public function remove(Request $request)
    {
        if ($request->serviceId) {
            $cart = session()->get('cart');
            if (isset($cart[$request->serviceId])) {
                unset($cart[$request->serviceId]);
                session()->put('cart', $cart);
                return response()->json(['status' => true]);
            }
        }
        return response()->json(['status' => false, 'message', 'Something went wrong']);
    }

    public function cartCount()
    {
        $cartCount = 0;
        if (session()->get('cart')) {
            $cartCount = count(session()->get('cart'));
            if (in_array($cartCount, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9])) {
                $cartCount = $cartCount;
            }
        }
        $cartData = session()->get('cart', []);

        $totalDiscountAmount = 0;
        $totalAmount = 0;

        if (!empty($cartData)) {
            foreach ($cartData as $key => $item) {
                if (isset($item['price'], $item['actualPrice'])) {
                    $cartData[$key]['price'] = userCurrencyPosition($item['price']);
                    $cartData[$key]['actualPrice'] = userCurrencyPosition($item['actualPrice']);

                    $discountAmount = $item['price'] - $item['actualPrice'];
                    $cartData[$key]['discountAmount'] = userCurrencyPosition($discountAmount);
                    $amount = $item['price'] * $item['quantity'];
                    $totalDiscountAmount += ($discountAmount * $item['quantity']);
                    $totalAmount += ($amount - ($discountAmount * $item['quantity']));
                }
            }
        }

        $totalDiscountAmountFormatted = userCurrencyPosition($totalDiscountAmount);

        return response()->json([
            'status' => true,
            'cartCount' => $cartCount,
            'sessionCard' => $cartData,
            'totalDiscountAmount' => $totalDiscountAmountFormatted,
            'subTotal' => userCurrencyPosition($totalAmount),
        ]);
    }

}
