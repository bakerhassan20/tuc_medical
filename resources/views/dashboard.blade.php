
@extends('layouts.base')

@section('content')


            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row home">

                <div class="col-lg-12  order-1">
                  <div class="row">

                    <div class="col mb-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="../assets/img/icons/unicons/chart-success.png"
                                alt="chart success"
                                class="rounded" />
                            </div>

                          </div>
                          <p class="mb-1">الاجهزة الطبية الداخلة في الخدمه</p>
                          <h4 class="card-title mb-3">{{ App\Models\Device::where('status','يعمل')->count() }}</h4>
                        </div>
                      </div>
                    </div>

                    <div class="col mb-6">
                        <div class="card h-100">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                              <div class="avatar flex-shrink-0">
                                <img
                                  src="../assets/img/icons/unicons/chart-success.png"
                                  alt="chart success"
                                  class="rounded" />
                              </div>

                            </div>
                            <p class="mb-1">الاجهزة الطبية قيد الاصلاح</p>
                            <h4 class="card-title mb-3">{{ App\Models\Device::where('status','قيد الاصلاح')->count() }}</h4>
                          </div>
                        </div>
                      </div>


                      <div class="col mb-6">
                        <div class="card h-100">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                              <div class="avatar flex-shrink-0">
                                <img
                                  src="../assets/img/icons/unicons/chart-success.png"
                                  alt="chart success"
                                  class="rounded" />
                              </div>

                            </div>
                            <p class="mb-1">الاجهزة الطبية خارجه عن الخدمة</p>
                            <h4 class="card-title mb-3">{{ App\Models\Device::where('status','لا يعمل')->count() }}</h4>
                          </div>
                        </div>
                      </div>


                      <div class="col mb-6">
                        <div class="card h-100">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                              <div class="avatar flex-shrink-0">
                                <img
                                  src="../assets/img/icons/unicons/chart-success.png"
                                  alt="chart success"
                                  class="rounded" />
                              </div>

                            </div>
                            <p class="mb-1">الكليات والاقسام</p>
                            <h4 class="card-title mb-3">{{ App\Models\Department::count() }}</h4>
                          </div>
                        </div>
                      </div>


                      <div class="col mb-6">
                        <div class="card h-100">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                              <div class="avatar flex-shrink-0">
                                <img
                                  src="../assets/img/icons/unicons/chart-success.png"
                                  alt="chart success"
                                  class="rounded" />
                              </div>

                            </div>
                            <p class="mb-1">الكادر الهندسي</p>
                            <h4 class="card-title mb-3">{{ App\Models\Staff::count() }}</h4>
                          </div>
                        </div>
                      </div>


                      <div class="col mb-6">
                        <div class="card h-100">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                              <div class="avatar flex-shrink-0">
                                <img
                                  src="../assets/img/icons/unicons/chart-success.png"
                                  alt="chart success"
                                  class="rounded" />
                              </div>

                            </div>
                            <p class="mb-1">الجدول اليومي</p>
                            <h4 class="card-title mb-3">{{ App\Models\Task::count() }}</h4>
                          </div>
                        </div>
                      </div>




                </div>


            </div>


        </div>


    </div>
            <!-- / Content col-lg-4 col-sm-6 mb-6-->


@endsection





