<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" data-bg-class="bg-menu-theme" style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
          <div class="app-brand demo">
            <a href="{{ route('dashboard') }}" class="app-brand-link">
                @php
                $logo = \App\Models\Setting::where('key','logo')->first();
            @endphp

      <img src="{{ asset($logo->value) }}" alt class="h-auto" width="100px" />
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item
        @if(request()->routeIs('dashboard')
            || request()->routeIs('users.index')
            || request()->routeIs('roles.index')
            || request()->routeIs('departments.index')
            || request()->routeIs('engineers.index')
             )active open
        @endif
               ">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Dashboards">لوحه التحكم</div>

              </a>
              <ul class="menu-sub">

            @can('الرئيسية')
              <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                  <a href="{{ route('dashboard') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Analytics">الرئيسية</div>
                  </a>
                </li>
            @endcan
            @can('الاعدادات')
            <li class="menu-item {{ request()->routeIs('get.settings') ? 'active' : '' }}">
              <a href="{{ route('get.settings') }}" class="menu-link">
                <div class="text-truncate" data-i18n="Analytics">الاعدادات</div>
              </a>
            </li>
        @endcan
            @can('المستخدمين')
                <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                  <a href="{{ route('users.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Analytics">المستخدمين</div>
                  </a>
                </li>
            @endcan
            @can('الصلاحيات')
                <li class="menu-item {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                  <a
                    href="{{route('roles.index')}}"
                    class="menu-link">
                    <div class="text-truncate" data-i18n="CRM">الصلاحيات</div>
                  </a>
                </li>
            @endcan
            @can('الاقسام والكليات')
                <li class="menu-item {{ request()->routeIs('departments.index') ? 'active' : '' }}">
                    <a
                      href="{{route('departments.index')}}"
                      class="menu-link">
                      <div class="text-truncate" data-i18n="CRM">الاقسام والكليات</div>
                    </a>
                  </li>
            @endcan
            @can('المهندسين')
                  <li class="menu-item {{ request()->routeIs('engineers.index') ? 'active' : '' }}">
                    <a
                      href="{{route('engineers.index')}}"
                      class="menu-link">
                      <div class="text-truncate" data-i18n="CRM">المهندسين</div>
                    </a>
                  </li>
            @endcan
               </ul>

            <!-- Layouts -->

            @can('الاجهزة الطبية')
            <li class="menu-item {{ request()->routeIs('devices.index') ? 'active' : '' }}">
              <a href="{{ route('devices.index') }}" class="menu-link ">
                <i class="menu-icon tf-icons bx bxs-devices ml-4"></i>
                <div class="text-truncate mr-3" data-i18n="Layouts">الاجهزه الطبية</div>
              </a>
            </li>
            @endcan
            @can('المهام اليومية')
            <!-- Front Pages -->
            <li class="menu-item {{ request()->routeIs('tasks.index') ? 'active' : '' }}">
              <a href="{{ route('tasks.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-task"></i>
                <div class="text-truncate" data-i18n="Front Pages">المهام اليومية</div>
              </a>
            </li>
            @endcan
            @can('اوقات العمل')
            <!-- Layouts -->
            <li class="menu-item {{ request()->routeIs('attendances.index') ? 'active' : '' }}">
              <a href="{{ route('attendances.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-time-five"></i>
                <div class="text-truncate" data-i18n="Layouts">اوقات العمل</div>
              </a>
            </li>
            @endcan
            @can('المخزن')
            <!-- Front Pages -->
            <li class="menu-item {{ request()->routeIs('stores.index') ? 'active' : '' }}">
              <a href="{{ route('stores.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div class="text-truncate" data-i18n="Front Pages">المخزن</div>
              </a>
            </li>

            @endcan
            @can('قطع غيار')
            <li class="menu-item {{ request()->routeIs('spares.index') ? 'active' : '' }}">
              <a href="{{ route('spares.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div class="text-truncate" data-i18n="Layouts">قطع غيار</div>
              </a>
            </li>
            @endcan
            @can('الكادر الهندسي')
            <li class="menu-item {{ request()->routeIs('staff.index') ? 'active' : '' }}">
              <a href="{{ route('staff.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div class="text-truncate" data-i18n="Front Pages">الكادر الهندسي</div>
              </a>
            </li>
            @endcan
            @can('التقارير الشهرية')
            <li class="menu-item {{ request()->routeIs('reports.index') ? 'active' : '' }}">
              <a href="{{ route('reports.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div class="text-truncate" data-i18n="Layouts">التقرير الشهري</div>
              </a>
            </li>

            @endcan
            @can('الكتب')
            <li class="menu-item {{ request()->routeIs('books.index') ? 'active' : '' }}">
              <a href="{{ route('books.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div class="text-truncate" data-i18n="Front Pages">الكتب الرسمية</div>
              </a>
            </li>
            @endcan
            @can('عيادات')
            <li class="menu-item {{ request()->routeIs('clinics.index') ? 'active' : '' }}">
              <a href="{{ route('clinics.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div class="text-truncate" data-i18n="Front Pages">عيادات طب الاسنان</div>
              </a>
            </li>
            @endcan



          </ul>
        </aside>
