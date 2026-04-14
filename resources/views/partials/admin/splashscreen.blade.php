{{-- Splash screen minimalis - hilang dalam 200ms --}}
<div id="splash-screen" 
     class="fixed inset-0 z-[9999] flex items-center justify-center bg-[#0f172a]"
     style="transition: opacity 0.2s ease-out;">
    <div class="text-center">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3"
             style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
            <i class="fas fa-print text-white text-2xl"></i>
        </div>
        <div class="text-white text-sm font-bold tracking-wide">CetakKilat</div>
        <div class="text-slate-400 text-[10px] mt-1">Digital Printing</div>
    </div>
</div>

<script>
    (function() {
        // Hilangkan splash screen secepat mungkin
        const removeSplash = () => {
            const splash = document.getElementById('splash-screen');
            if (splash) {
                splash.style.opacity = '0';
                setTimeout(() => splash.remove(), 200);
            }
        };
        
        // Coba hilangkan setelah DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', removeSplash);
        } else {
            removeSplash();
        }
        
        // Force remove after 1 second
        setTimeout(removeSplash, 1000);
    })();
</script>