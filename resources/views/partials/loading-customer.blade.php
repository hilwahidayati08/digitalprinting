<div id="ck-loader" style="position:fixed;inset:0;z-index:9999;background:#0a0f1e;display:flex;align-items:center;justify-content:center;transition:opacity 0.4s ease,visibility 0.4s ease;">

  <div class="ck-wrap">

    {{-- Logo + Kilat --}}
    <div class="ck-logo-wrap">

      {{-- Ring berputar --}}
      <svg class="ck-ring" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="40" cy="40" r="35" stroke="rgba(59,130,246,0.1)" stroke-width="1.5"/>
        <path d="M40 5a35 35 0 0 1 35 35" stroke="#3b82f6" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M40 5a35 35 0 0 1 20 30" stroke="#60a5fa" stroke-width="1" stroke-linecap="round" opacity=".4"/>
      </svg>

      {{-- Ikon printer --}}
      <div class="ck-icon">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
          <rect x="6" y="12" width="20" height="14" rx="2.5" fill="#1e40af"/>
          <rect x="6" y="6" width="10" height="8" rx="2" fill="#2563eb"/>
          <rect x="10" y="18" width="12" height="2" rx="1" fill="#60a5fa"/>
          <rect x="10" y="22" width="8" height="2" rx="1" fill="#93c5fd"/>
          <rect x="23" y="15" width="3" height="3" rx=".8" fill="#3b82f6"/>
        </svg>
      </div>

      {{-- Kilat kecil muncul-hilang --}}
      <svg class="ck-bolt" width="14" height="18" viewBox="0 0 14 20" fill="none">
        <polygon points="9,0 2,11 7,11 4,20 13,8 8,8" fill="#fbbf24"/>
      </svg>

    </div>

    {{-- Brand name --}}
    <div class="ck-brand">
      <span class="ck-brand-white">Cetak</span><span class="ck-brand-blue">Kilat</span>
    </div>
    <div class="ck-tagline">DIGITAL PRINTING</div>

    {{-- Progress bar --}}
    <div class="ck-bar-track">
      <div id="ck-bar" class="ck-bar-fill"></div>
    </div>

    {{-- Status --}}
    <div id="ck-status" class="ck-status">Memuat halaman...</div>

  </div>
</div>

<style>
  .ck-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;
    animation: ckFadeIn .5s ease both;
  }
  .ck-logo-wrap {
    position: relative;
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .ck-ring {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    animation: ckSpin 2.2s linear infinite;
  }
  .ck-icon {
    animation: ckBob 2.8s ease-in-out infinite;
  }
  .ck-bolt {
    position: absolute;
    top: 6px;
    right: 6px;
    animation: ckFlash 1.8s ease-in-out infinite;
  }
  .ck-brand {
    font-family: 'Plus Jakarta Sans', 'Montserrat', sans-serif;
    font-size: 22px;
    font-weight: 800;
    letter-spacing: -.3px;
  }
  .ck-brand-white { color: #f1f5f9; }
  .ck-brand-blue  { color: #3b82f6; }
  .ck-tagline {
    font-size: 9px;
    letter-spacing: .22em;
    color: #334155;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-weight: 500;
    margin-top: -8px;
  }
  .ck-bar-track {
    width: 160px;
    height: 2px;
    background: rgba(59,130,246,.12);
    border-radius: 99px;
    overflow: hidden;
  }
  .ck-bar-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #1d4ed8, #3b82f6, #60a5fa);
    border-radius: 99px;
    transition: width .18s linear;
  }
  .ck-status {
    font-size: 11px;
    color: #475569;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    transition: opacity .2s;
    animation: ckBlink 2s ease-in-out infinite;
  }

  #ck-loader.ck-hide {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
  }

  @keyframes ckSpin    { to { transform: rotate(360deg); } }
  @keyframes ckBob     { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-5px); } }
  @keyframes ckFlash   { 0%,100%{ opacity: 0; transform: scale(.8); } 40%,60%{ opacity: 1; transform: scale(1); } }
  @keyframes ckFadeIn  { from{ opacity: 0; transform: translateY(8px); } to{ opacity: 1; transform: translateY(0); } }
  @keyframes ckBlink   { 0%,100%{ opacity: .4; } 50%{ opacity: 1; } }
</style>

<script>
(function () {
  var loader  = document.getElementById('ck-loader');
  var bar     = document.getElementById('ck-bar');
  var status  = document.getElementById('ck-status');

  var msgs = [
    'Memuat halaman...',
    'Menyiapkan produk cetak...',
    'Mengambil data terbaru...',
    'Hampir selesai...',
    'Siap mencetak!',
  ];
  var prog = 0, mi = 0;

  var pi = setInterval(function () {
    if (prog < 88) {
      prog = Math.min(88, prog + (prog < 35 ? 3 : prog < 65 ? 1.8 : 0.7));
      bar.style.width = prog + '%';
    }
  }, 180);

  var si = setInterval(function () {
    mi = (mi + 1) % msgs.length;
    status.style.opacity = '0';
    setTimeout(function () {
      status.textContent = msgs[mi];
      status.style.opacity = '1';
    }, 200);
  }, 2400);

  function finish() {
    clearInterval(pi);
    clearInterval(si);
    bar.style.width = '100%';
    status.style.opacity = '0';
    setTimeout(function () { loader.classList.add('ck-hide'); }, 320);
  }

  if (document.readyState === 'complete') {
    setTimeout(finish, 700);
  } else {
    window.addEventListener('load', finish);
  }

  /* Safety 10 detik */
  setTimeout(finish, 10000);

  /* Bfcache — pas tombol back */
  window.addEventListener('pageshow', function (e) {
    if (e.persisted) finish();
  });
})();
</script>