@extends('layouts.base')

@section('content')
     <section class="main-section py-5">
      <div class="container">
      @if (count($errors) > 0)
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>خطا</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif




          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-md-12">

                  <div class="card mb-6">

                    <form id="formAccountSettings"  action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                            <!-- User Avatar -->
                            <img
                                src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                alt="user-avatar"
                                class="d-block w-px-100 h-px-100 rounded"
                                id="uploadedAvatar"
                            />

                            <div class="button-wrapper">
                                <!-- Upload Button -->
                                <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">تغير الصورة</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input
                                        type="file"
                                        id="upload"
                                        class="account-file-input"
                                        hidden
                                        accept="image/png, image/jpeg"
                                        onchange="previewImage(event)"
                                        name="avatar"
                                    />
                                </label>

                                <!-- Reset Button -->
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4" onclick="resetImage()">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">اعادة تعيين</span>
                                </button>

                                <div class="text-muted">الملفات المدعومة: JPG، GIF، أو PNG. الحد الأقصى لحجم الملف هو 800 كيلوبايت.</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-4">

                        <div class="row g-6">
                          <div class="col-md-6">
                            <label for="firstName" class="form-label">اسم المستخدم</label>
                            <input
                              class="form-control"
                              type="text"
                              id="firstName"
                              name="name"
                               value="{{ Auth::user()->name }}"
                              autofocus />
                          </div>
                          <div class="col-md-6">
                            <label for="email" class="form-label">البريد الالكتروني</label>
                            <input
                              class="form-control"
                              type="text"
                              id="email"
                              name="email"
                              value="{{ Auth::user()->email }}"

                              placeholder="john.doe@example.com" />
                          </div>

                          <div class="col-md-6">
                            <label class="form-label" for="phoneNumber">الهاتف</label>
                            <div class="input-group input-group-merge">

                              <input
                                type="text"
                                id="phoneNumber"
                                name="phone"
                                class="form-control"
                                value="{{ auth::user()->phone }}"/>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="address" class="form-label">الصلاحية</label>
                            <select id="country" class="select2 form-select" name="roles[]">
                                @foreach ($roles as $role)
                        <option value="{{ $role }}" {{ $role == Auth::user()->roles->first()->name ? 'selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="mt-6">
                          <button type="submit" class="btn btn-primary me-3">تحديث </button>
                          <a type="reset" class="btn btn-danger btn-buy-now" href="{{ route('dashboard') }}">إلغاء</a>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>


                  <div class="card mb-6">

                    <form id="formAccountSettings"  action="{{ route('profile.update-password') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <!-- Account -->

                    <div class="card-body pt-4">

                        <div class="row g-6">
                          <div class="col-md-6">
                            <label for="" class="form-label"> كلمه المرور الحالية</label>
                            <input
                              class="form-control"
                              type="password"
                              id="password"
                              name="old_password"
                               value="" />
                          </div>
                          <div class="col-md-6">
                            <label for="" class="form-label"> كلمه المرور الجديدة</label>
                            <input
                              class="form-control"
                              type="password"
                              id="password"
                              name="password"
                              value=""
                             />
                          </div>

                          <div class="col-md-6">
                            <label class="form-label" for="phoneNumber">تاكيد كلمه المرور الجديدة</label>
                            <div class="input-group input-group-merge">

                              <input
                                type="password"
                                id="phoneNumber"
                                name="confirm-password"
                                class="form-control"
                                value=""/>
                            </div>
                          </div>

                        </div>
                        <div class="mt-6">
                          <button type="submit" class="btn btn-primary me-3">تحديث </button>
                          <a type="reset" class="btn btn-danger btn-buy-now" href="{{ route('dashboard') }}">إلغاء</a>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>

                </div>
              </div>
            </div>
            <!-- / Content -->



            <script>
                // Image preview function
                function previewImage(event) {
                    const file = event.target.files[0];
                    const reader = new FileReader();
                    reader.onload = function () {
                        const uploadedAvatar = document.getElementById('uploadedAvatar');
                        uploadedAvatar.src = reader.result;
                    };
                    if (file) {
                        reader.readAsDataURL(file);
                    }
                }

                // Reset the image to the default
                function resetImage() {
                    const uploadedAvatar = document.getElementById('uploadedAvatar');
                    uploadedAvatar.src = "{{ asset('storage/' . auth()->user()->avatar) }}";
                    document.getElementById('upload').value = ''; // Reset file input
                }
            </script>
@endsection


