@extends('layouts.base')

@section('content')

    <section class="main-section users">
      <div class="container">
        <h4 class="main-heading mt-5">ادارة المستخدمين</h4>
        <form class="bg-white p-3 rounded-2 shadow">
          <div
            class="d-flex align-items-center flex-wrap justify-content-end mb-2"
          >
            <a
              type="button"
              class="btn btn-success"
              href="{{route('users.create')}}"
            >
              أضف مسؤول
              <i class="menu-icon tf-plus bx bx-plus ml-4"></i>
</a>
          </div>

          <div class="table-responsive">
            <table class="table main-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th style="text-align: center;">الصوره</th>
                  <th>اسم المستخدم</th>
                  <th> الصلاحيه</th>
                  <th>رقم الهاتف</th>
                  <th>البريد </th>
                  <th class="text-center">التحكم</th>
                </tr>
              </thead>
              <tbody>

                @foreach ( $data as $user)
                 <tr>

                  <td>{{ $loop->iteration}}</td>
                  <td style="text-align: center;">
                      <img src="{{ asset('storage/' . $user->avatar) }}" alt="User Image" width="90">
                  </td>
                  <td>{{ $user->name }}</td>
                
                                    <td>@if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $v)
                              {{ $v }}
                            @endforeach
                         @endif
                    </td>
                  <td>{{ $user->phone }}</td>
                   <td>{{ $user->email }}</td>
                  <td>
                    <div
                      class="d-flex align-items-center justify-content-center gap-1"
                    >

                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                      <div
                        class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-user_id="{{ $user->id }}" data-username="{{ $user->name }}"
                        data-bs-target="#modal-delete"
                      >
                        حذف
                      </div>
                    </div>
                  </td>
                   </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </form>
      </div>
    </section>


@endsection


@section('script')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"
  type="text/javascript"></script>
  <script>
    $(document).ready(function() {
        $('#modal-delete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); 
            var user_id = button.data('user_id'); 
            var username = button.data('username');
            var modal = $(this);
            modal.find('.modal-body #user_id').val(user_id); 
            modal.find('.modal-body #username').val(username);
        });
    });
</script>

@endsection
