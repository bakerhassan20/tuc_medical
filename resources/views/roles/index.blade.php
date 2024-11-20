@extends('layouts.base')

@section('content')

    <section class="main-section users">
      <div class="container">
        <h4 class="main-heading mt-5">الصلاحيات</h4>

          <div
            class="d-flex align-items-center flex-wrap justify-content-end mb-2"
          >
           <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}"><i class="icon fa-solid fa-plus"></i> اضافة صلاحيه</a>


          </div>

          <div class="table-responsive">
            <table class="table main-table">
              <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>العمليات</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                   @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>

                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('roles.show', $role->id) }}">عرض</a>



                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('roles.edit', $role->id) }}">تعديل</a>


                                        @if ($role->name !== 'سوبر ادمن')

                                                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                                                $role->id], 'style' => 'display:inline']) !!}
                                                {!! Form::submit('حذف', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}



                                        @endif


                                    </td>
                                </tr>
                            @endforeach
                </tr>
              </tbody>
            </table>
          </div>

      </div>
    </section>




@endsection
