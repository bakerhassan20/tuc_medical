
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
        <div class="row mb-5">
            <div class="col d-flex justify-content-start">
                <h4 class="main-heading mt-5">اضافة صلاحيه </h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm " style="margin-top: 21px;height: 35px;" href="{{ route('roles.index') }}">رجوع</a>
            </div>
        </div>
<!-- row -->

{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
            <br/>    <div class="form-group">
                            <p>اسم الصلاحية :</p>
                            {!! Form::text('name', null, array('class' => 'form-control')) !!}

                    </div><br/><br/>
                           <div class="row">
                            @foreach($permission as $value)
                               <div class="col-lg-3 col-md-6">
                            <label style="font-size:17px;" class="form-check">
                            {{ Form::checkbox('permission[]', $value->id, false, ['id'=>'inlineCheckbox2','class' => 'form-check-input', 'style' => 'transform: scale(1.2);']) }}
                           <span style="margin-right: 5px;"> {{ $value->name }}</span> </label>
                                        <br/>
                                          </div>
                            @endforeach
                                </div>


                      <br/>   <br/> <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">اضافة</button>
                    </div>



            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
      </div>
    </section>
@endsection
