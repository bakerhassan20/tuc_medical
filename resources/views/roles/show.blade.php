
@extends('layouts.base')

@section('content')
    <section class="main-section users">
      <div class="container">
        <div class="row mb-5">
            <div class="col d-flex justify-content-start">
                <h4 class="main-heading mt-5"> عرض صلاحيه</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm " style="margin-top: 21px;height: 35px;" href="{{ route('roles.index') }}">رجوع</a>
            </div>
        </div>
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                          <br> <li>{{ $role->name }}</li><br>

                                    @if(!empty($rolePermissions))
                                      <div class="row">
                                    @foreach($rolePermissions as $v)

                                        <div class="col-lg-3 col-md-6 mb-2">
                                          {{ $v->name }}
                                        </div>

                                    @endforeach
                                         </div>
                                    @endif



            </div>
        </div>
    </div>
</div>
      </div>
    </section>
@endsection
