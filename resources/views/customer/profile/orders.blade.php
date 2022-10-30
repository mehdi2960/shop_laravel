@extends('customer.layouts.master-two-col')

@section('head-tag')
    <title>سفارشات شما</title>
@endsection

@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                <aside id="sidebar" class="sidebar col-md-3">


                    <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                        <!-- start sidebar nav-->
                        <section class="sidebar-nav">
                            <section class="sidebar-nav-item">
                                <span class="sidebar-nav-item-title"><a class="p-3" href="my-orders.html">سفارش های من</a></span>
                            </section>
                            <section class="sidebar-nav-item">
                                <span class="sidebar-nav-item-title"><a class="p-3" href="my-addresses.html">آدرس های من</a></span>
                            </section>
                            <section class="sidebar-nav-item">
                                <span class="sidebar-nav-item-title"><a class="p-3" href="my-favorites.html">لیست علاقه مندی</a></span>
                            </section>
                            <section class="sidebar-nav-item">
                                <span class="sidebar-nav-item-title"><a class="p-3" href="my-profile.html">ویرایش حساب</a></span>
                            </section>
                            <section class="sidebar-nav-item">
                                <span class="sidebar-nav-item-title"><a class="p-3" href="#">خروج از حساب کاربری</a></span>
                            </section>

                        </section>
                        <!--end sidebar nav-->
                    </section>

                </aside>
                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>تاریخچه سفارشات</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->


                        <section class="d-flex justify-content-center my-4">
                            <a class="btn btn-info btn-sm mx-1" href="#">در انتظار پرداخت</a>
                            <a class="btn btn-warning btn-sm mx-1" href="#">در حال پردازش</a>
                            <a class="btn btn-success btn-sm mx-1" href="#">تحویل شده</a>
                            <a class="btn btn-danger btn-sm mx-1" href="#">مرجوعی</a>
                            <a class="btn btn-dark btn-sm mx-1" href="#">لغو شده</a>
                        </section>


                        <!-- start content header -->
                        <section class="content-header mb-3">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                    در انتظار پرداخت
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end content header -->


                        <section class="order-wrapper">
                          @forelse($orders as $order)
                                <section class="order-item">
                                    <section class="d-flex justify-content-between">
                                        <section>
                                            <section class="order-item-date"><i class="fa fa-calendar-alt"></i>{{jdate($order->created_at)}}</section>
                                            <section class="order-item-id"><i class="fa fa-id-card-alt"></i>کد سفارش : {{$order->id}}</section>
                                            <section class="order-item-status"><i class="fa fa-clock"></i>{{$order->paymentStatusValue}}</section>
                                            <section class="order-item-products">
                                                <a href="#"><img src="assets/images/products/1.jpg" alt=""></a>
                                                <a href="#"><img src="assets/images/products/2.jpg" alt=""></a>
                                            </section>
                                        </section>
                                        <section class="order-item-link"><a href="#">پرداخت سفارش</a></section>
                                    </section>
                                </section>
                            @empty
                              <section class="order-item">
                                <section class="d-flex justify-content-between">
                                    <p>سفارشی یافت نشد</p>
                                </section>
                              </section>

                            @endforelse

                        </section>


                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
