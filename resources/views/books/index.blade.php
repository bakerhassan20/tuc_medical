@extends('layouts.base')

@section('content')

<!-- Modal-delete -->
<div class="modal fade" id="modal-delete-book" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">حذف الكتاب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('books.destroy', 'delete') }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <h6 class="text-center">هل أنت متأكد من إجراء عملية الحذف؟</h6>
                    <input type="hidden" name="book_id" id="book_id" value="">
                    <input class="form-control" required name="book_title" id="book_title" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" style="font-size: 12px" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">نعم</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container mb-5">
    <h4 class="main-heading mt-5">الكتب</h4>
</div>

<!-- Collapsible content (Initially hidden) -->
<div class="collapse" id="filterCollapse">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('books.index') }}">
            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div class="col-3">
                    <label for="department_id" class="form-label">القسم</label>
                    <select style="width:180px" class="form-control" name="department_id">
                        <option value="all">اختر القسم</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <label for="engineer_id" class="form-label">المهندس</label>
                    <select style="width:180px" class="form-control" name="engineer_id">
                        <option value="all">اختر المهندس</option>
                        @foreach ($engineers as $engineer)
                            <option value="{{ $engineer->id }}" {{ old('engineer_id') == $engineer->id ? 'selected' : '' }}>
                                {{ $engineer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <label for="status" class="form-label">الحالة</label>
                    <select style="width:180px" class="form-control" name="status">
                        <option value="">اختر الحالة</option>
                        <option value="مستلم" {{ old('status') == 'مستلم' ? 'selected' : '' }}>مستلم</option>
                        <option value="قيد المراجعة" {{ old('status') == 'قيد المراجعة' ? 'selected' : '' }}>قيد المراجعة</option>
                        <option value="غير مستلم" {{ old('status') == 'غير مستلم' ? 'selected' : '' }}>غير مستلم</option>
                    </select>
                </div>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-sm btn-info">تصفية</button>
                    <a href="{{ route('books.index') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
                </div>
            </div>
        </form>
    </div>
</div>

<section class="main-section book">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow">

            <!--***************************-->
            <div class="d-flex align-items-center flex-wrap justify-content-end mb-3">
                <button   title="فلتر" type="button" style="margin-left: 10px;" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
            <i class="bx bx-filter-alt"></i>
                </button>
                <a href="{{ route('books.create') }}" class="btn btn-success btn-sm" title ="إضافة كتاب جديد">
                <i class="bx bx-plus-circle"></i>
                </a>
                </div>
<!--***************************-->

            <div class="table-responsive">
                <table class="table main-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>القسم</th>
                            <th>المهندس</th>
                            <th>النوع</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th class="text-center">التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}</td>
                                <td>{{ $book->department->name }}</td>
                                <td>{{ $book->engineer->name }}</td>
                                <td>{{ $book->type }}</td>
                                <td>
                                    @if($book->status == 'مستلم')
                                        <span class="text-success">{{ $book->status }}</span>
                                    @elseif($book->status == 'قيد المراجعة')
                                        <span class="text-warning">{{ $book->status }}</span>
                                    @else
                                        <span class="text-danger">{{ $book->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $book->date }}</td>

                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                           {{--     <a class="btn btn-sm btn-info" href="{{ route('books.show',$book->id) }}">
                                            عرض
                                          </a> --}}
                                        <a class="btn btn-sm btn-primary" href="{{ route('books.edit', $book->id) }}">تعديل</a>
                                        <div class="btn btn-sm btn-danger" data-bs-toggle="modal" data-book_id="{{ $book->id }}" data-book_title="{{ $book->type }}" data-bs-target="#modal-delete-book">
                                            حذف
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $books->links() }} <!-- This will render the pagination links -->
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#modal-delete-book').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var book_id = button.data('book_id')
            var book_title = button.data('book_title')
            var modal = $(this)

            modal.find('.modal-body #book_id').val(book_id);
            modal.find('.modal-body #book_title').val(book_title);
        });
    });
</script>

@endsection
