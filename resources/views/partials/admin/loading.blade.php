<div id="page-loader" style="position:fixed;inset:0;z-index:9999;background:#0f172a;display:flex;align-items:center;justify-content:center;transition:opacity .4s,visibility .4s;">
  <div class="ldr-inner">

    <div class="ldr-ring">
      <svg viewBox="0 0 64 64" fill="none">
        <circle cx="32" cy="32" r="28" stroke="rgba(255,255,255,.06)" stroke-width="2"/>
        <path d="M32 4a28 28 0 0 1 28 28" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round"/>
      </svg>
      <svg class="ldr-bolt" width="22" height="28" viewBox="0 0 22 30" fill="none">
        <polygon points="13,1 4,16 10,16 6,29 19,12 13,12 18,1" fill="#fbbf24"/>
      </svg>
    </div>

    <div class="ldr-brand">
      <div class="ldr-title">Digital Printing</div>
      <div class="ldr-sub">Admin Panel</div>
    </div>

    <div class="ldr-bar-wrap"><div id="ldr-bar" class="ldr-bar"></div></div>
    <div id="ldr-status" class="ldr-status">Memuat sistem percetakan...</div>

  </div>
</div>

<style>
.ldr-inner { display:flex; flex-direction:column; align-items:center; gap:18px; animation:ldrFadeIn .5s ease both; }
.ldr-ring { width:64px; height:64px; position:relative; display:flex; align-items:center; justify-content:center; }
.ldr-ring svg:first-child { position:absolute; inset:0; animation:ldrSpin 2s linear infinite; }
.ldr-bolt { animation:ldrBob 2.5s ease-in-out infinite; }
.ldr-brand { text-align:center; }
.ldr-title { font-size:14px; font-weight:600; letter-spacing:.08em; color:#e2e8f0; font-family:'Inter',sans-serif; }
.ldr-sub { font-size:10px; letter-spacing:.18em; text-transform:uppercase; color:#475569; margin-top:3px; font-family:'Inter',sans-serif; }
.ldr-bar-wrap { width:160px; height:2px; background:rgba(255,255,255,.08); border-radius:99px; overflow:hidden; }
.ldr-bar { height:100%; width:0%; background:linear-gradient(90deg,#3b82f6,#06b6d4); border-radius:99px; transition:width .2s linear; }
.ldr-status { font-size:11px; color:#475569; font-family:'Inter',sans-serif; transition:opacity .2s; animation:ldrBlink 2s ease-in-out infinite; }
#page-loader.loader-hide { opacity:0 !important; visibility:hidden !important; pointer-events:none !important; }

@keyframes ldrSpin { to { transform:rotate(360deg); } }
@keyframes ldrBob { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-4px); } }
@keyframes ldrFadeIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }
@keyframes ldrBlink { 0%,100% { opacity:.4; } 50% { opacity:1; } }
</style>

<script>
(function(){
  var loader = document.getElementById('page-loader');
  var bar    = document.getElementById('ldr-bar');
  var status = document.getElementById('ldr-status');
  var msgs   = ['Memuat sistem percetakan...','Menginisialisasi warna CMYK...','Menyiapkan mesin cetak digital...','Kalibrasi warna selesai...','Sistem siap mencetak...'];
  var prog = 0, msgIdx = 0;

  var progInt = setInterval(function(){
    if (prog < 88) {
      prog = Math.min(88, prog + (prog < 30 ? 2.5 : prog < 65 ? 1.5 : 0.6));
      bar.style.width = prog + '%';
    }
  }, 200);

  var msgInt = setInterval(function(){
    msgIdx = (msgIdx + 1) % msgs.length;
    status.style.opacity = '0';
    setTimeout(function(){ status.textContent = msgs[msgIdx]; status.style.opacity = '1'; }, 200);
  }, 2600);

  function finish(){
    clearInterval(progInt); clearInterval(msgInt);
    bar.style.width = '100%';
    setTimeout(function(){ loader.classList.add('loader-hide'); }, 350);
  }

  document.readyState === 'complete' ? setTimeout(finish, 800) : window.addEventListener('load', finish);
  setTimeout(finish, 12000);

  function showLoader(){
    prog = 0; bar.style.width = '0%';
    loader.classList.remove('loader-hide');
    clearInterval(progInt);
    progInt = setInterval(function(){
      if (prog < 88) {
        prog = Math.min(88, prog + (prog < 30 ? 2.5 : prog < 65 ? 1.5 : 0.6));
        bar.style.width = prog + '%';
      }
    }, 200);
  }

  document.addEventListener('click', function(e){
    var link = e.target.closest('a[href]');
    if (!link) return;
    var href = link.getAttribute('href');
    if (!href || href[0]==='#' || href.startsWith('javascript') || link.target==='_blank' || link.hasAttribute('download')) return;
    try { if (new URL(href, location.href).origin !== location.origin) return; } catch(_){}
    showLoader();
  });

  document.addEventListener('submit', function(e){ if (e.target.dataset.noLoader!=='true') showLoader(); });
  window.addEventListener('pageshow', function(e){ if (e.persisted) finish(); });
})();
</script>