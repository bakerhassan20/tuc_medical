@extends('layouts.base')

@section('content')

<!-- Modal-add -->
<div
    class="modal fade"
    id="modal-add-engineer"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">إضافة مهندس</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <form action="{{ route('engineers.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <label>اسم المهندس</label>
                    <input class="form-control" name="name" required id="engineername" type="text">
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        style="font-size: 12px"
                        data-bs-dismiss="modal"
                    >
                        إلغاء
                    </button>
                    <button type="submit" class="btn btn-success">إضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal-delete -->
<div
    class="modal fade"
    id="modal-delete-engineer"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">حذف مهندس</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <form action="{{ route('engineers.destroy', 'delete') }}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <h6 class="text-center">هل انت متأكد من إجراء عملية الحذف؟</h6>
                    <input type="hidden" name="engineer_id" id="engineer_id" value="">
                    <input class="form-control" required name="engineername" id="engineername" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        style="font-size: 12px"
                        data-bs-dismiss="modal"
                    >
                        إلغاء
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
    id="modal-edit-engineer"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">تعديل مهندس</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <form action="{{ route('engineers.update', 'update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="engineer_id" id="engineer_id" value="">
                    <label>اسم المهندس</label>
                    <input class="form-control" required name="name" id="engineername" type="text">
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        style="font-size: 12px"
                        data-bs-dismiss="modal"
                    >
                        إلغاء
                    </button>
                    <button type="submit" class="btn btn-primary">تعديل</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container mb-5">
    <h4 class="main-heading mt-5">المهندسين</h4>

    <div class="row">
        <div class="d-flex align-items-center gap-3 mt-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                الفلتر
            </button>
        </div>
    </div>
</div>

<div class="collapse" id="collapseExample">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('engineers.index') }}">
            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div>
                    <label for="name" class="form-label">اسم المهندس</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
                </div>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-sm btn-info">تصفية</button>
                    <a href="{{ route('engineers.index') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
                </div>
            </div>
        </form>
    </div>
</div>

<section class="main-section users">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow">
            <div class="d-flex align-items-center flex-wrap justify-content-end mb-2">
                <button
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#modal-add-engineer"
                    class="btn btn-success"
                >
                    أضف مهندس جديد
                    <i class="menu-icon tf-plus bx bx-plus ml-4"></i>
                </button>
            </div>

            <div class="table-responsive">
                <table class="table main-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المهندس</th>
                            <th class="text-center">التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($engineers as $engineer)
                            <tr>
                                <td>{{ ($engineers->currentPage() - 1) * $engineers->perPage() + $loop->iteration }}</td>
                                <td>{{ $engineer->name }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <div
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-engineer_id="{{ $engineer->id }}"
                                            data-engineername="{{ $engineer->name }}"
                                            data-bs-target="#modal-edit-engineer"
                                        >
                                            تعديل
                                        </div>
                                        <div
                                            class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-engineer_id="{{ $engineer->id }}"
                                            data-engineername="{{ $engineer->name }}"
                                            data-bs-target="#modal-delete-engineer"
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
                    {{ $engineers->links() }}
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#modal-edit-engineer').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var engineer_id = button.data('engineer_id');
            var engineername = button.data('engineername');
            var modal = $(this);
            modal.find('.modal-body #engineer_id').val(engineer_id);
            modal.find('.modal-body #engineername').val(engineername);
        });

        $('#modal-delete-engineer').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var engineer_id = button.data('engineer_id');
            var engineername = button.data('engineername');
            var modal = $(this);
            modal.find('.modal-body #engineer_id').val(engineer_id);
            modal.find('.modal-body #engineername').val(engineername);
        });
    });
</script>
@endsection
