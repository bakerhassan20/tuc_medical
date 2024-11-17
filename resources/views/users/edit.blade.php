
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


        <div class="row d-flex justify-content-between align-items-center">

             <!-- Heading section (right) -->
             <div class="col-auto">
                <h4 class="main-heading mt-5 text-right">تعديل مستخدم</h4>
            </div>

            <!-- "رجوع" button section (left) -->
            <div class="col-auto">
                <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}">رجوع</a>
            </div>


        </div>


        <!-- row -->
            <div class="card">
            <div class="card-body">


                {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id] ,'enctype'=>"multipart/form-data"]) !!}

                <div class="">


                     <!-- Display existing image if it exists -->
                     <div class="row mt-3">
                                <div class="col edit-img">
                                    @if($user->avatar && file_exists(public_path('storage/' . $user->avatar)))
                                        <!-- Show the current image -->
                                        <img src="{{ asset('storage/' . $user->avatar) }}" class="edit-user-img" alt="User Image">
                                    @else
                                        <!-- Show a default placeholder image if no image is found -->
                                        <img src="{{ asset('storage/default-avatar.png') }}" alt="Default Image" width="100">
                                    @endif
                                </div>
                            </div>


                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6" id="fnWrapper">
                            <label>  <strong>اسم المستخدم</strong> : <span class="tx-danger">*</span></label>
                            {!! Form::text('name', null, array('class' => 'form-control','required' )) !!}
                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label> <strong>البريد الالكتروني: </strong><span class="tx-danger">*</span></label>
                            {!! Form::text('email', null, array('class' => 'form-control','required')) !!}
                        </div>
                    </div>

                </div><br>

                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label> <strong>كلمة المرور: </strong> <span class="tx-danger">*</span></label>
                        {!! Form::password('password', array('class' => 'form-control','name'=>'password')) !!}
                    </div>

                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label><strong> تاكيد كلمة المرور: </strong><span class="tx-danger">*</span></label>
                        {!! Form::password('confirm-password', ['class' => 'form-control', 'placeholder' => 'Confirm your password']) !!}
                        </div>
                </div><br>

                <div class="row mg-b-20">
                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">

                          <label>  <strong>نوع المستخدم :</strong><span class="tx-danger">*</span></label>

                            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control'))
                            !!}

                    </div>
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label><strong> الهاتف: </strong><span class="tx-danger">*</span></label>
                            {!! Form::number('phone', null, array('class' => 'form-control','required')) !!}
                        </div>


                </div>

                <div class="row mt-5">
                    <div class="col" id="">
                        <label><strong> اضافة صورة: </strong><span class="tx-danger">*</span></label>
                        <input accept="image/png, image/jpeg" class="form-control" type="file" name="avatar"   placeholder="" />
                        </div>
                </div><br><br>

                <div class="mg-t-30 text-center">
                    <button class="btn btn-primary pd-x-20" type="submit">تحديث</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        </div>
      </div>
    </section>
@endsection
