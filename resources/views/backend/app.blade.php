<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Laravel')</title>
    <link rel="icon" type="image/x-icon" href="{{ url('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('apple-touch-icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://junait.com/tiny_pro.js"></script>


    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}">
</head>
<body>

    {{-- Sidebar (includes top navbar, offcanvas, desktop sidebar, and opens content-area) --}}
    @include('backend.partials.sidebar')

    {{-- Main Content --}}
    @yield('content')

    {{-- Copyright Footer inside content area --}}
    <div style="margin-top:auto;text-align:center;padding:20px 0 4px;font-size:0.82rem;color:#999;border-top:1px solid rgba(0,0,0,0.04);">
        Developed by <span style="font-weight:700;background:linear-gradient(135deg,#667eea,#764ba2);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Joty Biswas</span> &copy; {{ date('Y') }}
    </div>

    {{-- Close the content-area and d-flex wrapper opened in sidebar --}}
    </div>{{-- /content-area --}}
</div>{{-- /d-flex wrapper --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('backend/js/custom.js') }}"></script>

<script>
// ============== Top Scrollbar for Tables ==============
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.table-responsive').forEach(function(tableWrap) {
        // Skip if already has a top scrollbar sibling
        if (tableWrap.previousElementSibling && tableWrap.previousElementSibling.classList.contains('table-scroll-top')) {
            return;
        }

        // Create top scrollbar div
        var topScroll = document.createElement('div');
        topScroll.className = 'table-scroll-top';

        var inner = document.createElement('div');
        inner.className = 'scroll-content';
        topScroll.appendChild(inner);

        // Insert before the table wrapper
        tableWrap.parentNode.insertBefore(topScroll, tableWrap);

        // Sync scroll widths
        function syncWidth() {
            inner.style.width = tableWrap.scrollWidth + 'px';
        }

        // Sync scroll positions
        topScroll.addEventListener('scroll', function() {
            tableWrap.scrollLeft = topScroll.scrollLeft;
        });

        tableWrap.addEventListener('scroll', function() {
            topScroll.scrollLeft = tableWrap.scrollLeft;
        });

        // Initial sync and on resize
        syncWidth();
        window.addEventListener('resize', syncWidth);
    });
});
</script>

@yield('scripts')
</body>

<style>
    html, body { overflow-x: hidden; }
    body { background: #f8f9fe; }
    .row { margin-left: -2 !important; margin-right: 0 !important; }
    @media (min-width: 768px) {
        .btn-md-normal { font-size: inherit; padding: 0.375rem 0.75rem; }
        .form-control-md-normal { font-size: inherit; padding: 0.375rem 0.75rem; }
        .form-select-md-normal { font-size: inherit; padding: 0.375rem 0.75rem; }
    }
    .table-scroll-top { overflow-x: auto; overflow-y: hidden; height: 10px; visibility: visible; margin-bottom: 2px; }
    .table-scroll-top::-webkit-scrollbar { height: 10px; background: #f1f1f1; border-radius: 5px; }
    .table-scroll-top::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 5px; }
    .table-scroll-top::-webkit-scrollbar-thumb:hover { background: #a0a0a0; }
    .table-scroll-top .scroll-content { height: 1px; }
    .table-scroll-top { scrollbar-width: auto; scrollbar-color: #c1c1c1 #f1f1f1; }
    .offcanvas-backdrop.show { opacity: 0.5; }
    @media (max-width: 575.98px) {
        .table-scroll-top { display: none; }
        .container-fluid { padding-left: 10px !important; padding-right: 10px !important; }
    }

    /* ===================== Mobile polish ===================== */
    @media (max-width: 767.98px) {
        /* Bootstrap's negative row gutters make rows wider than the screen on
           phones; drop them here so every grid stays inside the viewport. */
        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            --bs-gutter-x: 1rem;
        }

        /* iOS zooms the whole page when a focused field is smaller than 16px */
        #mainContent input:not([type="checkbox"]):not([type="radio"]):not([type="file"]),
        #mainContent select,
        #mainContent textarea {
            font-size: 16px !important;
        }
        #mainContent input::placeholder,
        #mainContent textarea::placeholder { font-size: 0.95rem; }

        /* comfortable touch targets */
        #mainContent button,
        #mainContent .btn { min-height: 42px; }
        #mainContent button.btn-icon,
        #mainContent a.btn-icon { min-width: 42px; }

        /* page rhythm */
        #mainContent { padding: 14px 12px 24px !important; }
        #mainContent h4 { font-size: 1.3rem !important; line-height: 1.3; }
        #mainContent h5 { font-size: 1.08rem !important; }
        #mainContent .container-fluid { padding-left: 0 !important; padding-right: 0 !important; }

        /* cards: softer radius, less inner padding, no heavy shadows */
        #mainContent .card,
        #mainContent [style*="border-radius:20px"],
        #mainContent [style*="border-radius:24px"] { border-radius: 16px !important; }

        /* tables scroll inside their own wrapper, never the page */
        #mainContent .table-responsive,
        #mainContent [style*="overflow:auto"],
        #mainContent [style*="overflow-x:auto"] { -webkit-overflow-scrolling: touch; }
        #mainContent table { font-size: 0.82rem; }

        /* modal dialogs use the full width on phones */
        .modal-dialog { margin: 0.6rem !important; }
        .modal-body { padding: 16px !important; }
        .modal-header, .modal-footer { padding: 14px 16px !important; }
        .modal .btn { min-width: 44%; }

        /* long headings/pills wrap instead of pushing the layout sideways */
        #mainContent h1, #mainContent h2, #mainContent h3, #mainContent h4 { overflow-wrap: anywhere; }
    }
</style>

</html>
