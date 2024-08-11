<!--   Core JS Files   -->
<script src="{{ asset('admin/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('admin/js/core/popper.min.js') }}"></script>
<script src="{{ asset('admin/js/core/bootstrap.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('admin/js/plugin/chart.js/chart.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('admin/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Chart Circle -->
<script src="{{ asset('admin/js/plugin/chart-circle/circles.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('admin/js/plugin/datatables/datatables.min.js') }}"></script>

<!-- Bootstrap Notify -->
<script src="{{ asset('admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<!-- jQuery Vector Maps -->
<script src="{{ asset('admin/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ asset('admin/js/plugin/jsvectormap/world.js') }}"></script>

<!-- Google Maps Plugin -->
<script src="{{ asset('admin/js/plugin/gmaps/gmaps.js') }}"></script>

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/alert.js') }}"></script>

<script src="{{ asset('admin/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Kaiadmin JS -->
<script src="{{ asset('admin/js/kaiadmin.min.js') }}"></script>

{{-- Preview Image --}}
<script src="{{ asset('js/previewImage.js') }}"></script>

@unless (request()->is('login') || request()->is('register'))
    {{-- Notifikasi --}}
    <script src="{{ asset('js/notifications.js') }}"></script>
@endunless

@yield('custom-footer')
