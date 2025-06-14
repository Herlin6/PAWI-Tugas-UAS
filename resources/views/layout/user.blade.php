<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title class="title-color">@yield("title")</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | Unfixed Sidebar" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
    <!--end::Required Plugin(AdminLTE)-->
    <!--begin::GDeBook Theme Override-->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <!--end::GDeBook Theme Override-->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="navbar navbar-expand-lg fixed-top d-flex justify-content-end">
        <div class="container-fluid d-flex">
          <a class='brand-link' href='/dashboard'>
            <img
              src="{{ asset('assets/img/GDeBookLogo1.png') }}"
              alt="AdminLTE Logo"
              class="brand-image shadow"
              style="width: 150px"
            />
          </a>
          <button 
            class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" 
            aria-controls="navbarNav" 
            aria-expanded="false" 
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse justify-content-start ms-lg-5" id="navbarNav">
            <ul class="navbar-nav font-playfair fs-5">
              <li class="nav-item">
                <a class="nav-link title-color" aria-current="page" href="{{ route('dashboard') }}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link title-color" href="{{ route('books.index') }}">Book</a>
              </li>
              @can('viewAny', App\Models\Loan::class)
                <li class="nav-item">
                  <a class="nav-link title-color" href="{{ route('loans.index') }}">Loan</a>
                </li>
              @endcan
              @can('viewAny', App\Models\Member::class)
                <li class="nav-item">
                  <a class="nav-link title-color" href="{{ route('members.profile') }}">Profile</a>
                </li>
              @endcan
              <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                </form>
                <a class="nav-link title-color" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Log Out
                </a>
              </li>
            </ul>
          </div>
        </div>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown user-menu">
            @php
                $user = Auth::user();
                $memberPhoto = optional($user->member)->photo;
                $photoPath = $memberPhoto ? $memberPhoto : asset('images/default.png');
            @endphp

            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
              <div class="d-none d-lg-flex gap-2 align-items-center">
                <span class="d-none d-md-inline">{{ $user->name }}</span>
                <div class="rounded-circle overflow-hidden" style="width: 30px; height: 30px;">
                  <img
                  src="{{ $photoPath }}"
                  alt="User Avatar"
                  class="img-fluid"
                  style="object-fit: cover; height: 100%; width: 100%;"
                  />
                </div>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <li class="user-header main-bg-body main-color">
                <img
                  src="{{ $photoPath }}"
                  class="rounded-circle shadow"
                  alt="User Image"
                  style="object-fit: cover; aspect-ratio: 1/1;"
                />
                <p>
                  {{ Auth::user()->name }} - {{ ucfirst(Auth::user()->role) }}
                </p>
              </li>
              <li class="user-footer">
                  <div class="d-flex justify-content-center w-100">
                      <form method="POST" action="{{ route('logout') }}">
                          @csrf
                          <x-dark-button type="submit">
                              {{ __('Log Out') }}
                          </x-dark-button>
                      </form>
                  </div>
              </li>
            </ul>
          </li>
        </ul>
      </nav>

      <!--end::Header-->
      <!--begin::App Main-->
      <main class="app-main" style="padding-top: 84px;">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6 font-playfair"><h3 class="mb-3 title-color">@yield("title")</h3></div>
              <div class="col-sm-6">
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            @yield('content')
            <!--end::Row-->
          </div>
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2025&nbsp;
        </strong>
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

  <script type="text/javascript">
      $('.show_confirm').click(function(event) {
          var form = $(this).closest("form");
          var nama = $(this).data("nama");
          event.preventDefault();
          swal({
              title: `Apakah Anda yakin ingin menghapus data ${nama} ini?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          }).then((willDelete) => {
              if (willDelete) {
                  form.submit();
              }
          });
      });

      @if (session('success'))
          swal({
              title: "Good Job!",
              text: "{{ session('success') }}",
              icon: "success",
          });
      @endif
  </script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
