<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'SIPEKA') - Sistem Skrining Preeklampsia</title>
  
  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <!-- SIPEKA Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/sipeka.css') }}">
  @stack('styles')
</head>
<body>
<div class="sipeka-layout">
  @include('layouts.partials.sidebar')
  
  <main class="sipeka-main">
    @include('layouts.partials.topbar')
    
    <div class="sipeka-content">
      @if(session('success'))
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: '{{ session('success') }}',
              confirmButtonColor: '#1A6B6B',
              timer: 3000,
              timerProgressBar: true
            });
          });
        </script>
      @endif
      
      @if(session('error'))
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Gagal!',
              text: '{{ session('error') }}',
              confirmButtonColor: '#EF4444'
            });
          });
        </script>
      @endif
      
      @if(session('risk_alert'))
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            @php $risk = session('risk_alert'); @endphp
            Swal.fire({
              icon: 'warning',
              title: '🚨 Terdeteksi Risiko Tinggi!',
              html: `
                <div style="text-align:left; font-size:14px;">
                  <p style="font-weight:600; color:#991B1B; margin-bottom:12px;">Peringatan Sistem:</p>
                  <ul style="padding-left:16px; color:#374151;">
                    @foreach($risk['peringatan'] as $warn)
                    <li><strong>{{ $warn }}</strong></li>
                    @endforeach
                  </ul>
                  <p style="margin-top:12px; font-weight:600; color:#92400E;">
                    Pertimbangkan pembuatan surat rujukan segera.
                  </p>
                </div>
              `,
              confirmButtonText: '<i class="fas fa-file-medical"></i> Buat Rujukan',
              showCancelButton: true,
              cancelButtonText: 'Pantau Dulu',
              confirmButtonColor: '#DC2626',
              cancelButtonColor: '#64748B',
              width: 480,
              customClass: {
                popup: 'swal-risk-high'
              }
            });
          });
        </script>
      @endif

      @yield('content')
    </div>
  </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<!-- SIPEKA Custom JS -->
<script src="{{ asset('js/sipeka.js') }}"></script>
@stack('scripts')
</body>
</html>