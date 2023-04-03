@extends('customer.layouts.master-two-col')

@section('head-tag')
    <title>تیکت های شما</title>
@endsection

@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                @include('customer.layouts.partials.profile-sidebar')
                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>تاریخچه تیکت ها</span>
                                </h2>
                                <section class="content-header-link m-2">
                                    <a href="#" class="btn btn-success text-white">ارسال تیکت جدید</a>
                                </section>
                            </section>
                        </section>
                        <section class="order-wrapper">
                            <section class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>نویسنده تیکت</th>
                                        <th>عنوان تیکت</th>
                                        <th>دسته تیکت</th>
                                        <th>اولویت تیکت</th>
                                        <th>ارجاع شده از</th>
                                        <th>تیکت مرجع</th>
                                        <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <td>{{ $ticket->user->first_name . ' ' . $ticket->user->last_name }}</td>
                                            <td>{{ $ticket->subject }}</td>
                                            <td>{{ $ticket->category->name }}</td>
                                            <td>{{ $ticket->priority->name }}</td>
                                            <td>{{ $ticket->admin->user->first_name . ' ' . $ticket->admin->user->last_name }}</td>
                                            <td>{{ $ticket->parent->subject ?? '-' }}</td>
                                            <td class="width-16-rem text-left">
                                                <a href="{{ route('admin.ticket.show', $ticket->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> مشاهده</a>
                                                <a href="{{ route('admin.ticket.change', $ticket->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-check"></i> {{ $ticket->status == 1 ? 'باز کردن' : 'بستن' }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </section>
                        </section>
                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
