
@extends('auth.layouts.base')

@section('content')

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card px-sm-6 px-0">
            <div class="card-body">
              <!-- Logo -->
              @php
                  $logo = \App\Models\Setting::where('key','logo')->first();
              @endphp
              <div class="app-brand justify-content-center">
                <a href="{{ route('dashboard') }}" class="app-brand-link gap-2">
        <img src="{{ asset($logo->value) }}" alt class="w-px-100 h-auto" />
                </a>
              </div>
              <!-- /Logo -->


              <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('login') }}">
              @csrf
                <div class="mb-6">
                  <label for="email" class="form-label">اسم المستخدم</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="name"
                    placeholder="Enter your username"
                    autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                </div>
                <div class="mb-6 form-password-toggle">
                  <label class="form-label" for="password">كلمه المرور</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
          <!--       <div class="mb-8">
                  <div class="d-flex justify-content-between mt-8">
                    <div class="form-check mb-0 ms-2">
                      <input class="form-check-input" type="checkbox" id="remember-me" />
                      <label class="form-check-label" for="remember-me"> Remember Me </label>
                    </div>
                  </div> -->
                </div>
                <div class="mb-6">
                  <button class="btn btn-primary d-grid w-100" type="submit">تسجيل دخول</button>
                </div>
              </form>

            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

@endsection



