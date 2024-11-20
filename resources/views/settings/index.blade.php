@extends('layouts.base')

@section('content')
@can("الاعدادات")

<section class="main-section staff">
    <div class="container">


        <div class="row mb-5">
            <div class="col d-flex justify-content-start">
                <h4 class="main-heading mt-5">الاعدادات</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <form class="parsley-style-1" id="createStaffForm" autocomplete="off" action="{{ route('set.settings') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row mg-b-20 mt-5">
                    <div class="parsley-input col">
                    <label>اسم الموقع</label>
                    <input class="form-control" type="text" name="site_name" required
                    value="{{ optional($site_name)->value ?? ''}}" placeholder="" />
                    </div>
                    </div>

                    <div class="row mg-b-20 mt-5">
                        <div class="parsley-input col">
                        <label>Footer</label>
                    <input class="form-control" type="text" name="footer" required
                     value="{{ optional($footer)->value ?? '' }}" placeholder="" />
                        </div>
                        </div>
                    <div class="row mg-b-20 mt-5">
                        <div class="parsley-input col">
                            <label>لوجو الموقع</label>
                            <input class="form-control" type="file" name="logo" accept=".jpg, .jpeg, .png" />
                        </div>
                    </div>

                    <div class="mg-t-30 text-center mt-5">
                        <button class="btn btn-primary pd-x-20" type="submit">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endcan
@cannot('الاعدادات')
    <div class="col-md-offset-1 col-md-10 alert alert-danger can">
        ليس لديك صلاحية يرجي مراجعة المسؤول
    </div>
@endcannot
@endsection
