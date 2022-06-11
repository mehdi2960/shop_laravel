@extends('customer.layouts.master-simple')

@section('content')


<section class="vh-100 d-flex justify-content-center align-items-center pb-5">
    <form action="{{ route('auth.customer.login-confirm', $token) }}" method="post">
        @csrf
    <section class="login-wrapper mb-5">
        <section class="login-logo">
            <img src="{{ asset('customer-assets/images/logo/4.png') }}" alt="">
        </section>
        <section class="login-title mb-2">
            <a href="{{ route('auth.customer.login-register-form') }}">
                <i class="fa fa-arrow-right"></i>
            </a>
        </section>
          <section class="login-title">
            کد تایید را وارد نمایید
        </section>

        @if($otp->type == 0)
        <section class="login-info">
            کد تایید برای شماره موبایل {{ $otp->login_id }} ارسال گردید
        </section>
        @else
        <section class="login-info">
            کد تایید برای ایمیل {{ $otp->login_id }} ارسال گردید
        </section>
        @endif
        <section class="login-input-text">
            <input type="text" name="id" value="{{ old('id') }}">
            @error('id')
            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
        @enderror
        </section>
        <section class="login-btn d-grid g-2"><button class="btn btn-danger">تایید</button></section>
    </section>
    </form>
</section>


@endsection
