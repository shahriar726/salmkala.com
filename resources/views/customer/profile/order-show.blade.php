@extends('customer.layouts.master-two-col')

@section('head-tag')
    <title>سفارشات شما</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <a class="btn btn-info btn-sm mx-1"
               href="{{ route('customer.profile.orders') }}">بازگشت</a>

        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        فاکتور
                    </h5>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover h-150px" id="printable">

                        <tbody>

                        <tr class="table-primary">
                            <th>{{ $order->id }} </th>
                            <td class="width-8-rem text-left">
                                <a href="" class="btn btn-dark btn-sm text-white" id="print">
                                    <i class="fa fa-print"></i>
                                    چاپ
                                </a>

                                <a href="{{ route('customer.profile.order.show.detail', $order) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-book"></i>
                                    جزئیات
                                </a>
                            </td>
                        </tr>

                        <tr class="border-bottom">
                            <th>نام مشتری</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->user->fullName ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>ایمیل مشتری</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->user->email ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>شماره تلفن مشتری</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->user->mobile  ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>آدرس</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->address ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>استان</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->city->province->name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>شهر</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->city->name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>کد پستی</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->postal_code ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>پلاک</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->no ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>واحد</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->unit ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نام گیرنده</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->recipient_first_name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نام خانوادگی گیرنده</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->recipient_last_name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>موبایل</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->mobile ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نوع پرداخت</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->payment_type_value }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>وضعیت پرداخت</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->payment_status_value }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مبلغ ارسال</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->delivery_amount ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>وضعیت ارسال</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->delivery_status_value }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>تاریخ ارسال</th>
                            <td class="text-left font-weight-bolder">
                                {{ jalaliDate($order->delivery_time) }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مجموع مبلغ سفارش (بدون تخفیف)</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_final_amount ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مجموع تمامی مبلغ تخفیفات</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_discount_amount ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مبلغ تخفیف همه محصولات</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_total_products_discount_amount ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مبلغ نهایی</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_final_amount -  $order->order_discount_amount }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>بانک</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->payment->paymentable->gateway ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>کوپن استفاده شده</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->copan->code ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>تخفیف کد تخفیف</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_copan_discount_amount ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>تخفیف عمومی استفاده شده</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->commonDiscount->title ?? '-' }}
                            </td>
                        </tr>

                        <tr class="border-bottom">
                            <th>مبلغ تخفیف عمومی</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_common_discount_amount ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>وضعیت سفارش</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_status_value }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>کد تحویل</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->delivery_object}}
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')

    <script>

        var printBtn = document.getElementById('print');
        printBtn.addEventListener('click', function(){
            printContent('printable');
        })


        function printContent(el){

            var restorePage = $('body').html();
            var printContent = $('#' + el).clone();
            $('body').empty().html(printContent);
            window.print();
            $('body').html(restorePage);
        }


    </script>

@endsection
