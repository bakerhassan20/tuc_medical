@extends('layouts.base')

@section('content')


 <!-- Modal-add -->
 <div
 class="modal fade"
 id="modal-add-department"
 data-bs-backdrop="static"
 data-bs-keyboard="false"
 tabindex="-1"
 aria-labelledby="staticBackdropLabel"
 aria-hidden="true"
>
 <div class="modal-dialog">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="staticBackdropLabel">اضافة قسم او كلية</h5>
       <button
         type="button"
         class="btn-close"
         data-bs-dismiss="modal"
         aria-label="Close"
       ></button>
     </div>
     <form action="{{ route('departments.store', "store")  }}" method="post">
               {{ method_field('post') }}
               {{ csrf_field() }}
     <div class="modal-body">
       <input type="hidden" name="department_id" id="department_id" value="">
       <div class="row">
        <div class="col">
            <label class="mb-2">الاسم</label>
            <input class="form-control" name="name" required id="departmentname" type="text">
        </div>
        <div class="col">
            <label class="mb-2">النوع</label>
            <select class="form-control" name="type">
                <option value="قسم">قسم</option>
                <option value="كلية">كلية</option>
            </select>
        </div>
       </div>

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
       <button type="submit" class="btn btn-success">اضافة</button>
     </div>
   </form>
   </div>
 </div>
</div>





 <!-- Modal-delete -->
    <div
      class="modal fade"
      id="modal-delete-department"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">حذف قسم او كلية</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="{{ route('departments.destroy', "delete")  }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
          <div class="modal-body">
            <h6 class="text-center">هل انت متأكد من اجراء عملية الحذف!</h6>
            <input type="hidden" name="department_id" id="department_id" value="">
            <input class="form-control" required name="departmentname" id="departmentname" type="text" readonly>
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

<!-- Modal-edit -->
<div
 class="modal fade"
 id="modal-edit-department"
 data-bs-backdrop="static"
 data-bs-keyboard="false"
 tabindex="-1"
 aria-labelledby="staticBackdropLabel"
 aria-hidden="true"
>
 <div class="modal-dialog">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="staticBackdropLabel">تعديل قسم او كلية</h5>
       <button
         type="button"
         class="btn-close"
         data-bs-dismiss="modal"
         aria-label="Close"
       ></button>
     </div>
     <form action="{{ route('departments.update', "update")  }}" method="post">
               {{ method_field('PUT') }}
               {{ csrf_field() }}
     <div class="modal-body">
       <input type="hidden" name="department_id" id="department_id" value="">
       <div class="row">
        <div class="col">
            <label class="mb-2">الاسم</label>
            <input class="form-control" required name="name" id="departmentname" type="text">
        </div>
        <div class="col">
            <label class="mb-2">النوع</label>
            <select class="form-control" name="type" id="department_type">
                <option value="قسم">قسم</option>
                <option value="كلية">كلية</option>
            </select>
        </div>
       </div>
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
       <button type="submit" class="btn btn-primary">تعديل</button>
     </div>
   </form>
   </div>
 </div>
</div>




<div class="container mb-5">
    <h4 class="main-heading mt-5">الاقسام و الكليات </h4>
</div>

<!-- Collapsible content (Initially hidden) -->
<div class="collapse" id="collapseExample">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('departments.index') }}">
            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div>
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
                </div>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-sm btn-info">تصفية</button>
                    <a href="{{ route('departments.index') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
                </div>
            </div>
        </form>
    </div>
</div>







    <section class="main-section users">
      <div class="container">

        <form class="bg-white p-3 rounded-2 shadow">

    <!--***************************-->
            <div class="d-flex align-items-center flex-wrap justify-content-end mb-3">
                <button   title="فلتر" type="button" style="margin-left: 10px;" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <i class="bx bx-filter-alt"></i>
                </button>
            <button type="button" data-bs-toggle="modal"  data-bs-target="#modal-add-department"
                class="btn btn-success btn-sm" title ="إضافة قسم او كلية جديد">
                <i class="bx bx-plus-circle"></i>
            </button>

            </div>
    <!--***************************-->

          <div class="table-responsive">
            <table class="table main-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>الاسم</th>
                  <th>النوع</th>
                  <th class="text-center">التحكم</th>
                </tr>
              </thead>
              <tbody>

                @foreach ( $departments as $department)
                 <tr>
                    <td>{{ ($departments->currentPage() - 1) * $departments->perPage() + $loop->iteration }}</td>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->type }}</td>

                  <td>
                    <div class="d-flex align-items-center justify-content-center gap-1">

                        <div class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-department_id="{{ $department->id }}"
                        data-departmentname="{{ $department->name }}"
                        data-department_type="{{ $department->type }}"
                        data-bs-target="#modal-edit-department">تعديل
                    </div>

                      <div
                        class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-department_id="{{ $department->id }}" data-departmentname="{{ $department->name }}"
                        data-department_type="{{ $department->type }}"
                        data-bs-target="#modal-delete-department"
                      >
                        حذف
                      </div>
                    </div>
                  </td>
                   </tr>
                @endforeach

              </tbody>
            </table>

            <div class="pagination">
                    {{ $departments->links() }}  <!-- This will render the pagination links -->
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
    $('#modal-edit-department').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);

        var department_id = button.data('department_id');
        var departmentname = button.data('departmentname');
        var department_type = button.data('department_type'); // Get the department type
        var modal = $(this);

        // Set the department_id and departmentname input fields
        modal.find('.modal-body #department_id').val(department_id);
        modal.find('.modal-body #departmentname').val(departmentname);

        // Set the selected option based on the department type
        modal.find('.modal-body #department_type').val(department_type);
    });
});
</script>
<script>
$(document).ready(function() {
    $('#modal-delete-department').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var department_id = button.data('department_id')
        var departmentname = button.data('departmentname')
        var modal = $(this)

        modal.find('.modal-body #department_id').val(department_id);
        modal.find('.modal-body #departmentname').val(departmentname);
    });

});

</script>


<script>
    $(document).ready(function() {
        $('#modal-delete-department').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var department_id = button.data('department_id')
            var departmentname = button.data('departmentname')
            var modal = $(this)

            modal.find('.modal-body #department_id').val(department_id);
            modal.find('.modal-body #departmentname').val(departmentname);
        });

    });

    </script>


@endsection
