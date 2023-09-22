<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Http\Services\Message\MessageSerivce;
use App\Http\Services\Message\SMS\SmsService;
use App\Http\Services\Payment\PaymentService;
use App\Mail\ReceiveCodeOrderMail;
use App\Models\Market\CartItem;
use App\Models\Market\CashPayment;
use App\Models\Market\Copan;
use App\Models\Market\OfflinePayment;
use App\Models\Market\OnlinePayment;
use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use App\Models\Market\Payment;
use App\Models\User;
use App\Notifications\NewUserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;

class PaymentController extends Controller
{
    public function payment()
    {
        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->first();

//        dd(object_get($order,'delivery.amount'));
        return view('customer.sales-process.payment', compact('cartItems', 'order'));
    }

    public function copanDiscount(Request $request)
    {
        $request->validate(
            ['copan' => 'required']
        );

        $copan = Copan::where([['code', $request->copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();
        if ($copan != null) {
            if ($copan->user_id != null) {
                $copan = Copan::where([['code', $request->copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['user_id', auth()->user()->id]])->first();
                if ($copan == null) {
                    return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
                }
            }

            $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->where('copan_id', null)->first();

            if ($order) {
                if ($copan->amount_type == 0) {
                    $copanDiscountAmount = $order->order_final_amount * ($copan->amount / 100);
                    if ($copanDiscountAmount > $copan->discount_ceiling) {
                        $copanDiscountAmount = $copan->discount_ceiling;
                    }
                } else {
                    $copanDiscountAmount = $copan->amount;
                }

                $order->order_final_amount = $order->order_final_amount - $copanDiscountAmount;

                $finalDiscount = $order->order_total_products_discount_amount + $copanDiscountAmount;

                $order->update(
                    ['copan_id' => $copan->id, 'order_copan_discount_amount' => $copanDiscountAmount, 'order_total_products_discount_amount' => $finalDiscount]
                );

                return redirect()->back()->with(['copan' => 'کد تخفیف با موفقیت اعمال شد']);
            } else {
                return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
            }
        } else {
            return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
        }
    }

    public function paymentSubmit(Request $request, PaymentService $paymentService)
    {
        $request->validate(
            ['payment_type' => 'required']
        );

        $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->first();
        $cartItems = CartItem::where('user_id', Auth::user()->id);
        $cash_receiver = null;
        $order->update(
             ['order_final_amount'=>object_get($order,'delivery.amount')+$order->order_final_amount]
        );
        switch ($request->payment_type) {
            case '1':
                $targetModel = OnlinePayment::class;
                $type = 0;
                break;
            case '2':
                $targetModel = OfflinePayment::class;
                $type = 1;
                break;
            case '3':
                $targetModel = CashPayment::class;
                $type = 2;
                $cash_receiver = $request->cash_receiver ? $request->cash_receiver : null;
                break;
            default:
                return redirect()->back()->withErrors(['error' => 'خطا']);
        }

        $paymented = $targetModel::create([
            'amount' => $order->order_final_amount,
            'user_id' => auth()->user()->id,
            'pay_date' => now(),
            'cash_receiver' => $cash_receiver,
            'status' => 1,
        ]);

        $payment = Payment::create(
            [
                'amount' => $order->order_final_amount,
                'user_id' => auth()->user()->id,
                'pay_date' => now(),
                'type' => $type,
                'paymentable_id' => $paymented->id,
                'paymentable_type' => $targetModel,
                'status' => 1,
            ]
        );
        session()->put('paymented',$paymented->id);

        $order->update(
            ['order_status' => 3,'delivery_amount'=>object_get($order,'delivery.amount')]
        );
//        $order->update(
//            ['delivery_amount'=>(int)$order->delivery_amount+(int)$order->order_final_amount]
//        );
        session()->put('order_id',$order->id);

        foreach ($cartItems->get() as $cartItem) {

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product' => $cartItem->product,
                'amazing_sale_id' => $cartItem->product->activeAmazingSales()->id ?? null,
                'amazing_sale_object' => $cartItem->product->activeAmazingSales() ?? null,
                'amazing_sale_discount_amount' => empty($cartItem->product->activeAmazingSales()) ? 0 : $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100),
                'number' => $cartItem->number,
                'final_product_price' => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() : ($cartItem->cartItemProductPrice() - $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100)),
                'final_total_price' => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() * ($cartItem->number) : ($cartItem->cartItemProductPrice() - $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100)) * ($cartItem->number),
                'color_id' => $cartItem->color_id,
                'guarantee_id' => $cartItem->guarantee_id,
            ]);
        }


        if ($request->payment_type == 1) {
//            $paymentService->zarinpal($order->order_final_amount, $order, $paymented);

            $invoice = (new Invoice())->amount($order->order_final_amount)->detail('خرید از سایت ...');
            return \Shetabit\Payment\Facade\Payment::via('zarinpal')->callbackUrl(route('customer.sales-process.payment-call-back'))/**/
                ->purchase($invoice, function ($driver, $transactionId) use ($paymented, $cartItems) {
                    $paymented->find((int) session()->get('paymented'))->updated(['gateway'=>$driver,'transaction_id'=>$transactionId]);
                    session()->put('transaction', $transactionId);
                    $cartItems->delete();
                })->pay()->render();

        }

    }

    public function paymentCallback()
    {
        $peymented = OnlinePayment::find((int)session()->get('paymented'));
        $amount = $peymented->amount;
        $cartItems = CartItem::where('user_id', auth()->id())->get();
        $order = Order::find((int)session()->get('order_id'));
        try {
            $paymentConfig = config('payment');
            $payment = (new \Shetabit\Multipay\Payment($paymentConfig))
                ->amount((int) $amount)
                ->transactionId(session()->get('transaction'))
                ->verify();

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => session()->get('order_id'),
                    'product_id' => $cartItem->product_id,
                    'product' => $cartItem->product,
                    'amazing_sale_id' => $cartItem->product->activeAmazingSales()->id ?? null,
                    'amazing_sale_object' => $cartItem->product->activeAmazingSales() ?? null,
                    'amazing_sale_discount_amount' => empty($cartItem->product->activeAmazingSales()) ? 0 : $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100),
                    'number' => $cartItem->number,
                    'final_product_price' => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() : ($cartItem->cartItemProductPrice() - $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100)),
                    'final_total_price' => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() * ($cartItem->number) : ($cartItem->cartItemProductPrice() - $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100)) * ($cartItem->number),
                    'color_id' => $cartItem->color_id,
                    'guarantee_id' => $cartItem->guarantee_id,
                ]);

                $cartItem->delete();
            }
            $order->update(
                ['order_status' => 3,'payment_status' => 1]
            );
            $peymented->update(['reference_code'=>$payment->getReferenceId(),
                'gateway'=>$payment->getDriver(),
                'transaction_id'=>session()->get('transaction')]);
            session()->forget('order_id');
            session()->forget('transaction');
            //send sms when success
//            $receiveCode = rand(111111, 999999);

//            $customer=User::where('user_type', 0)->first();
//            $smsService = new SmsService();
//            $smsService->setFrom(Config::get('sms.otp_from'));
//            $smsService->setTo(['0' . $customer->mobile]);
//            $smsService->setText("مجموعه سلم کالا \n  کد تحویل : $receiveCode");
//            $smsService->setIsFlash(true);
//            $messagesService = new MessageSerivce($smsService);
//            $messagesService->send();
            //notification_for_admin
            $details=[
                'message'=>'یک سفارش انلاین انجام شد لطفا چک کنید'
            ];
            $adminUser=User::where('user_type', 1)->first();
            $adminUser->notify(new NewUserRegistered($details));
//            $emailService=Mail::to($user->email)->send(new ReceiveCodeOrderMail($receiveCode));
            return redirect()->route('customer.home')->with('alert-section-success', 'پرداخت شما با موفقیت انجام شد');
        }
        catch(InvalidPaymentException $exception) {
            $order->update(
                ['order_status' => 2,'payment_status' => 0 ]
            );
            return redirect()->route('customer.home')->with('alert-section-error', $exception->getMessage());
        }
    }

}
