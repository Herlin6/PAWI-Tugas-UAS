<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title class="title-color">@yield("title")</title>
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
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  </head>
  <body class="bg-body-tertiary">
    <div class="app-wrapper">
      <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <a class='brand-link' href='/dashboard'>
            <img
              src="{{ asset('assets/img/GDeBookLogo1.png') }}"
              alt="AdminLTE Logo"
              class="brand-image shadow"
              style="width: 150px"
            />
          </a>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown user-menu">
              @php
                  $user = Auth::user();
                  $photoPath = $user->member->photo ? $user->member->photo : asset('images/default.png');
              @endphp

              <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                <span class="d-none d-md-inline">{{ $user->name }}</span>
                <div class="rounded-circle overflow-hidden" style="width: 30px; height: 30px">
                  <img
                      src="{{ $photoPath }}"
                      alt="User Avatar"
                      class="img-fluid"
                      style="object-fit: cover; height: 100%; width: 100%"
                  />
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
        </div>
      </nav>
      <main class="app-main container">
        <div class="app-content">
          <div class="container-fluid">
            @yield('content')
          </div>
        </div>
      </main>
      <footer class="app-footer">
        <strong>
          Copyright &copy; 2025&nbsp;
        </strong>
      </footer>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
  <script type="text/javascript">
      $('.show_confirm').click(function(event) {
          var form = $(this).closest("form");
          var nama = $(this).data("nama");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this ${name} data?`,
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

      @if (session('error'))
      swal({
          title: "Oops!",
          text: "{{ session('error') }}",
          icon: "error",
      });
      @endif

  </script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    window.addEventListener('load', function () {
        AOS.init({
            once: false,
            mirror: true,
            offset: 0,
        });

        setTimeout(() => AOS.refresh(), 100);
    });
</script>
  </body>
</html>
