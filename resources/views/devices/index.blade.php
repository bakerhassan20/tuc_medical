@extends('layouts.base')

@section('content')



 <!-- Modal-delete -->
    <div
      class="modal fade"
      id="modal-delete-device"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">حذف جهاز</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="{{ route('devices.destroy', "delete")  }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
          <div class="modal-body">
            <h6 class="text-center">هل انت متأكد من اجراء عملية الحذف!</h6>
            <input type="hidden" name="device_id" id="device_id" value="">
            <input class="form-control" required name="devicename" id="devicename" type="text" readonly>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              style="font-size: 12px"
              data-bs-dismiss="modal"
            >
              الغاء
            </button>
            <button type="submit" class="btn btn-danger">نعم</button>
          </div>
        </form>
        </div>
      </div>
    </div>




<div class="container mb-5">
    <h4 class="main-heading mt-5">الجهزة الطبية</h4>

    <div class="row">
        <div class="d-flex align-items-center gap-3 mt-3">
            <!-- Button to toggle collapse -->
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                الفلتر
            </button>
        </div>
    </div>
</div>

<!-- Collapsible content (Initially hidden) -->
<div class="collapse" id="collapseExample">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('devices.index') }}">
            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div>
                    <label for="name" class="form-label">اسم الجهاز</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
                </div>
                <div>
                    <label for="name" class="form-label">القسم</label>
                    <select style="width:150px" class="form-control" name="department_id">
                        <option value="all">اختر القسم</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>                </div>
                <div>
                    <label for="name" class="form-label">الصيانه الدورية</label>
                    <select style="width:150px" class="form-control" name="periodic_maintenance">
                        <option value="all">اختر المدة</option>
                        <option value="يوميا" {{ old('periodic_maintenance') == 'يوميا' ? 'selected' : '' }}>يوميا</option>
                        <option value="اسبوعيا" {{ old('periodic_maintenance') == 'اسبوعيا' ? 'selected' : '' }}>اسبوعيا</option>
                        <option value="شهريا" {{ old('periodic_maintenance') == 'شهريا' ? 'selected' : '' }}>شهريا</option>
                        <option value="سنويا" {{ old('periodic_maintenance') == 'سنويا' ? 'selected' : '' }}>سنويا</option>
                    </select>                </div>
                <div>
                    <label for="name" class="form-label">الحالة</label>
                    <label> حاله الجهاز </label>
                    <select style="width:150px" class="form-control" name="status">
                        <option  value="all">اختر الحالة</option>
                        <option value="يعمل" {{ old('status') == 'يعمل' ? 'selected' : '' }}>يعمل</option>
                        <option value="لا يعمل" {{ old('status') == 'لا يعمل' ? 'selected' : '' }}>لا يعمل</option>
                        <option value="قيد الاصلاح" {{ old('status') == 'قيد الاصلاح' ? 'selected' : '' }}>قيد الاصلاح</option>
                    </select>                </div>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-sm btn-info">تصفية</button>
                    <a href="{{ route('devices.index') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
                </div>
            </div>
        </form>
    </div>
</div>

    <section class="main-section users">
      <div class="container">

        <form class="bg-white p-3 rounded-2 shadow">
          <div
            class="d-flex align-items-center flex-wrap justify-content-end mb-2"
          >
          <a
          href="{{ route('devices.create') }}"
          class="btn btn-success btn-sm"
        >
          أضف جهاز جديد
          <i class="menu-icon tf-plus bx bx-plus ml-4"></i>
        </a>
          </div>

          <div class="table-responsive">
            <table class="table main-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>الاسم</th>
                  <th>القسم</th>
                  <th>الصيانه الدورية</th>
         {{--          <th>بلد المنشأ</th>
                  <th>الشركه المصنعة</th>
                  <th>موقع </th> --}}
                  <th>الحالة</th>
           {{--        <th>  تاريخ </th> --}}
                  <th class="text-center">التحكم</th>
                </tr>
              </thead>
              <tbody>

                @foreach ( $devices as $device)
                 <tr>
                    <td>{{ ($devices->currentPage() - 1) * $devices->perPage() + $loop->iteration }}</td>
          <td>{{ $device->name }}</td>
          <td>{{ $device->department->name }}</td>

          <td>{{ $device->periodic_maintenance }}</td>
     {{--      <td>{{ $device->country }}</td>
          <td>{{ $device->company }}</td>
          <td>{{ $device->location }}</td> --}}
          <td>
            @if($device->status == 'يعمل')
            <span class="text-success">{{ $device->status }}</span>
            @elseif ($device->status == 'لا يعمل')
            <span class="text-danger">{{ $device->status }}</span>
            @else
            <span class="text-warning">{{ $device->status }}</span>
            @endif
          </td>
{{--           <td>{{ \Carbon\Carbon::parse($device->date)->format('d/m/Y') }}</td>  --}}
       <td class="text-center">

        <div class="d-flex align-items-center justify-content-center gap-1">
            <div class=""><a class="btn btn-sm btn-info" href="{{ route('devices.show',$device->id) }}">
              عرض
            </a></div>
            <div class="d-flex align-items-center justify-content-center gap-1">
              <div class=""><a class="btn btn-sm btn-primary" href="{{ route('devices.edit',$device->id) }}">
                تعديل
              </a></div>

              <div class="btn btn-sm btn-danger"
                   data-bs-toggle="modal"
                   data-device_id="{{ $device->id }}"
                   data-devicename="{{ $device->name }}"
                   data-device_type="{{ $device->type }}"
                   data-bs-target="#modal-delete-device">
                حذف
              </div>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>


            <div class="pagination">
                    {{ $devices->links() }}  <!-- This will render the pagination links -->
            </div>
          </div>
        </form>
      </div>
    </section>
<!-- Pagination Links -->
@endsection


@section('script')

<script>
$(document).ready(function() {
    $('#modal-delete-device').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var device_id = button.data('device_id')
        var devicename = button.data('devicename')
        var modal = $(this)

        modal.find('.modal-body #device_id').val(device_id);
        modal.find('.modal-body #devicename').val(devicename);
    });

});

</script>

@endsection
