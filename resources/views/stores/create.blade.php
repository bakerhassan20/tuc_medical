@extends('layouts.base')

@section('content')

    <section class="main-section store">
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
                    <h4 class="main-heading mt-5">إضافة متجر جديد</h4>
                </div>
                <div class="col d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm" style="margin-top: 21px; height: 35px;" href="{{ route('stores.index') }}">رجوع</a>
                </div>
            </div>

            <!-- row -->
            <div class="card">
                <div class="card-body">

                    <form class="parsley-style-1" id="storeForm" autocomplete="off" name="storeForm"
                        action="{{ route('stores.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="">

                            <!-- Store Name -->
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6" id="nameWrapper">
                                    <label>اسم المخزن</label>
                                    <input class="form-control" type="text" name="name" required value="{{ old('name') }}" placeholder="اسم المخزن"/>
                                </div>

                                <!-- Store Description -->
                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="descriptionWrapper">
                                    <label>الوصف</label>
                                    <input class="form-control" type="text" name="description" required value="{{ old('description') }}" placeholder="وصف المخزن"/>
                                </div>
                            </div>

                            <!-- Quantity and Location -->
                            <div class="row mg-b-20 mt-5">
                                <div class="parsley-input col-md-6" id="quantityWrapper">
                                    <label>الكمية</label>
                                    <input class="form-control" type="number" name="quantity" required value="{{ old('quantity') }}" placeholder="الكمية"/>
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="locationWrapper">
                                    <label>الموقع</label>
                                    <input class="form-control" type="text" name="location" required value="{{ old('location') }}" placeholder="الموقع"/>
                                </div>
                            </div>

                            <!-- Date and Notes -->
                            <div class="row mg-b-20 mt-5">
                                <div class="parsley-input col-md-6" id="dateWrapper">
                                    <label>التاريخ</label>
                                    <input class="form-control" type="date" name="date" required value="{{ old('date') }}" placeholder="التاريخ"/>
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="notesWrapper">
                                    <label>الملاحظات</label>
                                    <input class="form-control" type="text" name="notes" value="{{ old('notes') }}" placeholder="الملاحظات"/>
                                </div>
                            </div>

                        </div><br><br>

                        <div class="mg-t-30 text-center">
                            <button class="btn btn-primary pd-x-20" type="submit">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>

@endsection
