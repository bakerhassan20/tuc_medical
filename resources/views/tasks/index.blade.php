@extends('layouts.base')

@section('content')

 <!-- Modal-delete -->
<div class="modal fade" id="modal-delete-task" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">حذف مهام</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tasks.destroy', "delete") }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <h6 class="text-center">هل انت متأكد من اجراء عملية الحذف!</h6>
                    <input type="hidden" name="task_id" id="task_id" value="">
                    <input class="form-control" required name="taskname" id="taskname" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" style="font-size: 12px" data-bs-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">نعم</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container mb-5">
    <h4 class="main-heading mt-5">المهام اليومية</h4>

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
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('tasks.index') }}">
            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div>
                    <label for="name" class="form-label">اسم المهندس</label>
                    <select style="width:150px" class="form-control" name="engineer_id">
                        <option value="all">اختر المهندس</option>
                        @foreach ($engineers as $engineer)
                            <option value="{{ $engineer->id }}" {{ old('engineer_id') == $engineer->id ? 'selected' : '' }}>
                                {{ $engineer->name }}
                            </option>
                        @endforeach
                    </select>                </div>
                <div>
                    <label for="name" class="form-label">القسم</label>
                    <select style="width:150px" class="form-control" name="department_id">
                        <option value="all">اختر القسم</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="priority" class="form-label">الأولوية</label>
                    <select style="width:150px" class="form-control" name="priority">
                        <option value="all">اختر الاولوية</option>
                        <option value="عالية" {{ old('priority') == 'عالية' ? 'selected' : '' }}>عالية</option>
                        <option value="متوسطة" {{ old('priority') == 'متوسطة' ? 'selected' : '' }}>متوسطة</option>
                        <option value="منخفضة" {{ old('priority') == 'منخفضة' ? 'selected' : '' }}>منخفضة</option>
                    </select>
                </div>
                <div>
                    <label for="status" class="form-label">الحالة</label>
                    <select style="width:150px" class="form-control" name="status">
                        <option value="all">اختر الحالة</option>
                        <option value="مكتملة" {{ old('status') == 'مكتملة' ? 'selected' : '' }}>مكتملة</option>
                        <option value="غير مكتملة" {{ old('status') == 'غير مكتملة' ? 'selected' : '' }}>غير مكتملة</option>
                        <option value="قيد العمل" {{ old('status') == 'قيد العمل' ? 'selected' : '' }}>قيد العمل</option>
                    </select>
                </div>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-sm btn-info">تصفية</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
                </div>
            </div>
        </form>
    </div>
</div>

<section class="main-section users">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow">
            <div class="d-flex align-items-center flex-wrap justify-content-end mb-2">
                <a href="{{ route('tasks.create') }}" class="btn btn-success btn-sm">
                    أضف مهام جديدة
                    <i class="menu-icon tf-plus bx bx-plus ml-4"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table main-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المهندس</th>
                            <th>القسم</th>
                            <th>المهام الموكلة الية</th>
                            <th>الحالة</th>
                            <th>الاولوية</th>
                            <th>التاريخ</th>
                            <th class="text-center">التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ ($tasks->currentPage() - 1) * $tasks->perPage() + $loop->iteration }}</td>
                                <td>{{ $task->engineer ? $task->engineer->name : 'غير محدد' }}</td>
                                <td>{{ $task->department->name }}</td>
                                <td>{{ $task->errands }}</td>
                                <td>
                                    @if($task->status == 'مكتملة')
                                        <span class="text-success">{{ $task->status }}</span>
                                    @elseif ($task->status == 'غير مكتملة')
                                        <span class="text-danger">{{ $task->status }}</span>
                                    @else
                                        <span class="text-warning">{{ $task->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($task->priority == 'عالية')
                                        <span class="text-success">{{ $task->priority }}</span>
                                    @elseif ($task->priority == 'منخفضة')
                                        <span class="text-danger">{{ $task->priority }}</span>
                                    @else
                                        <span class="text-warning">{{ $task->priority }}</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($task->date)->format('Y/m/d') }}</td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <a class="btn btn-sm btn-info" href="{{ route('tasks.show', $task->id) }}">عرض</a>
                                        <a class="btn btn-sm btn-primary" href="{{ route('tasks.edit', $task->id) }}">تعديل</a>
                                        <div class="btn btn-sm btn-danger" data-bs-toggle="modal" data-task_id="{{ $task->id }}" data-taskname="{{ $task->name }}" data-task_type="{{ $task->type }}" data-bs-target="#modal-delete-task">
                                            حذف
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $tasks->links() }} <!-- This will render the pagination links -->
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#modal-delete-task').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var task_id = button.data('task_id')
            var taskname = button.data('taskname')
            var modal = $(this)

            modal.find('.modal-body #task_id').val(task_id);
            modal.find('.modal-body #taskname').val(taskname);
        });
    });
</script>

@endsection
