@extends('layouts.base')

@section('content')

<!-- Modal-delete -->
<div class="modal fade" id="modal-delete-store" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">حذف المخزن</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('stores.destroy', 'delete') }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <h6 class="text-center">هل أنت متأكد من إجراء عملية الحذف؟</h6>
                    <input type="hidden" name="store_id" id="store_id" value="">
                    <input class="form-control" required name="store_name" id="store_name" type="text" readonly>
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
    <h4 class="main-heading mt-5">المخزن</h4>
</div>

<!-- Collapsible content (Initially hidden) -->
<div class="collapse" id="filterCollapse">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('stores.index') }}">
            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div>
                    <label for="name" class="form-label">اسم المادة</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                </div>
                <div>
                    <label for="location" class="form-label">الموقع</label>
                    <input type="text" class="form-control" name="location" value="{{ old('location') }}">
                </div>
                <div>
                    <label for="date" class="form-label">التاريخ</label>
                    <input type="date" class="form-control" name="date" value="{{ old('date') }}">
                </div>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-sm btn-info">تصفية</button>
                    <a href="{{ route('stores.index') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
                </div>
            </div>
        </form>
    </div>
</div>

<section class="main-section store">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow">

 <!--***************************-->
                 <div class="d-flex align-items-center flex-wrap justify-content-end mb-3">
                    <button   title="فلتر" type="button" style="margin-left: 10px;" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                <i class="bx bx-filter-alt"></i>
                    </button>
                    <a href="{{ route('stores.create') }}" class="btn btn-success btn-sm" title ="إضافة متجر جديد">
                    <i class="bx bx-plus-circle"></i>
                    </a>
                    </div>
    <!--***************************-->

            <div class="table-responsive">
                <table class="table main-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المادة</th>
                            <th>الوصف</th>
                            <th>الكمية</th>
                            <th>الموقع</th>
                            <th>التاريخ</th>
                            <th>الملاحظات</th>
                            <th class="text-center">التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stores as $store)
                            <tr>
                                <td>{{ ($stores->currentPage() - 1) * $stores->perPage() + $loop->iteration }}</td>
                                <td>{{ $store->name }}</td>
                                <td>{{ $store->description }}</td>
                                <td>{{ $store->quantity }}</td>
                                <td>{{ $store->location }}</td>
                                <td>{{ \Carbon\Carbon::parse($store->date)->format('Y/m/d') }}</td>
                                <td>{{ $store->notes }}</td>

                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                     {{--    <a class="btn btn-sm btn-info" href="{{ route('stores.show', $store->id) }}">عرض</a> --}}
                                        <a class="btn btn-sm btn-primary" href="{{ route('stores.edit', $store->id) }}">تعديل</a>
                                        <div class="btn btn-sm btn-danger" data-bs-toggle="modal" data-store_id="{{ $store->id }}" data-store_name="{{ $store->name }}" data-bs-target="#modal-delete-store">
                                            حذف
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $stores->links() }} <!-- This will render the pagination links -->
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#modal-delete-store').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var store_id = button.data('store_id')
            var store_name = button.data('store_name')
            var modal = $(this)

            modal.find('.modal-body #store_id').val(store_id);
            modal.find('.modal-body #store_name').val(store_name);
        });
    });
</script>

@endsection
