
@extends('layouts.base')

@section('content')


    <section class="main-section users">
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
                <h4 class="main-heading mt-5">اضافة مستخدم جديد</h4>
        <!-- row -->
            <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="al">
                        <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}">رجوع</a>
                    </div>
                </div><br>

                <form class="parsley-style-1" id="selectForm4" autocomplete="off" name="selectForm2"
                    action="{{route('users.store','test')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                <div class="">

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6" id="fnWrapper">
                            <label>اسم المستخدم: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="name" required="" placeholder="" />
                            </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label>البريد الالكتروني: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="email" name="email" required="" />
                            </div>
                    </div>

                </div><br>

                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>كلمة المرور: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="password" name="password" required=""  placeholder="" />
                        </div>

                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label> تاكيد كلمة المرور: <span class="tx-danger">*</span></label>
                        <input class="form-control"   name="confirm-password" required="" type="password" />
                        </div>
                </div><br>

                <div class="row mg-b-20">
                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">

                          <label>  <strong>نوع المستخدم :</strong><span class="tx-danger">*</span></label>
                          {!! Form::select('roles_name[]', $roles,[], array('class' => 'form-control')) !!}


                    </div>
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label> الهاتف: <span class="tx-danger">*</span></label>
                            {!! Form::number('phone', null, array('class' => 'form-control','required')) !!}
                        </div>
                        </div>
                <div class="row mt-5">
                    <div class="col" id="">
                        <label> اضافة صورة: <span class="tx-danger">*</span></label>
                        <input accept="image/png, image/jpeg" class="form-control" type="file" name="avatar" required=""  placeholder="" />
                        </div>
                </div><br><br>


                <div class="mg-t-30 text-center">
                    <button class="btn btn-primary pd-x-20" type="submit">اضافة</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        </div>
      </div>
    </section>
@endsection
