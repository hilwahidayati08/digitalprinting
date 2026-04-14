{{-- resources/views/frontend/contact.blade.php --}}
@extends('admin.guest')

@section('title', 'Hubungi Kami - CetakKilat')

@section('content')
{{-- Load FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    /* Reset & Base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Custom Input */
    .custom-input {
        transition: all 0.2s ease;
    }
    .custom-input:focus {
        border-color: #2563eb;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }
    
    .btn-primary-gradient {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
    }
    
    /* Contact Card */
    .contact-card {
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
    }
    
    /* Info Item */
    .info-item {
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        transform: translateX(5px);
    }
    
    .info-icon {
        transition: all 0.3s ease;
    }
    
    .info-item:hover .info-icon {
        transform: scale(1.1);
        background: #2563eb;
    }
    
    .info-item:hover .info-icon i {
        color: white;
    }
    
    /* Social Media Buttons */
    .social-btn {
        transition: all 0.3s ease;
    }
    
    .social-btn:hover {
        transform: translateY(-3px);
    }
    
    /* Map Section */
    .map-container {
        transition: all 0.5s ease;
    }
    
    .map-container:hover {
        filter: grayscale(0%);
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .contact-card {
            border-radius: 1rem;
            margin: 0 8px;
        }
        
        .info-item {
            padding: 12px;
        }
        
        .info-icon {
            width: 40px;
            height: 40px;
        }
        
        .social-btn {
            width: 36px;
            height: 36px;
        }
        
        .map-container {
            height: 250px;
        }
    }
    
    @media (max-width: 480px) {
        .contact-card {
            margin: 0 4px;
        }
        
        .info-icon {
            width: 36px;
            height: 36px;
        }
        
        .info-icon i {
            font-size: 14px;
        }
        
        .social-btn {
            width: 32px;
            height: 32px;
        }
        
        .social-btn i {
            font-size: 12px;
        }
    }
</style>

<div class="bg-slate-50 min-h-screen">
    {{-- HERO SECTION --}}
    <div class="bg-gradient-to-br from-primary-600 to-secondary-600 py-10 md:py-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 md:w-40 md:h-40 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-20 h-20 bg-black/5 rounded-full translate-y-10 -translate-x-8"></div>
        
        <div class="container mx-auto px-4 max-w-6xl relative z-10">
            <h1 class="text-white text-2xl md:text-3xl font-black tracking-tight">
                Hubungi <span class="font-normal opacity-80">Kami</span>
            </h1>
            <p class="text-blue-100 text-sm mt-2 max-w-lg">
                CetakKilat siap memberikan solusi cetak digital terbaik sesuai kebutuhan bisnis dan personal Anda.
            </p>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="-mt-6 md:-mt-8 relative z-30 pb-16 md:pb-20">
        <div class="container mx-auto px-3 md:px-4 max-w-6xl">
            <div class="bg-white contact-card flex flex-wrap border border-slate-100 shadow-xl shadow-blue-900/5">
                
                {{-- Sisi Kiri: Informasi Kontak --}}
                <div class="w-full lg:w-5/12 p-6 md:p-10 lg:p-12 bg-white">
                    <h2 class="text-xl md:text-2xl font-black text-slate-800 mb-2">Get in touch</h2>
                    <p class="text-slate-500 text-sm mb-8 md:mb-10">Kami hadir untuk membantu Anda. Hubungi kami melalui saluran di bawah ini.</p>

                    <div class="space-y-6 md:space-y-8">
                        {{-- Alamat --}}
                        <div class="info-item flex items-start gap-3 md:gap-4">
                            <div class="info-icon bg-blue-50 w-10 h-10 md:w-12 md:h-12 flex-shrink-0 flex items-center justify-center rounded-xl text-blue-600 transition-all">
                                <i class="fas fa-map-marker-alt text-base md:text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm md:text-base">Kantor Pusat</h4>
                                <p class="text-slate-500 text-xs md:text-sm leading-relaxed mt-1">
                                    {{ $settings->address ?? 'Jl. Gandaria V No.11E, Jagakarsa, Jakarta Selatan' }}
                                </p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="info-item flex items-start gap-3 md:gap-4">
                            <div class="info-icon bg-blue-50 w-10 h-10 md:w-12 md:h-12 flex-shrink-0 flex items-center justify-center rounded-xl text-blue-600 transition-all">
                                <i class="fas fa-envelope text-base md:text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm md:text-base">Email</h4>
                                <a href="mailto:{{ $settings->email ?? 'info@CetakKilat.id' }}" class="text-slate-500 text-xs md:text-sm mt-1 hover:text-blue-600 transition-colors block">
                                    {{ $settings->email ?? 'info@CetakKilat.id' }}
                                </a>
                            </div>
                        </div>

                        {{-- Telepon --}}
                        <div class="info-item flex items-start gap-3 md:gap-4">
                            <div class="info-icon bg-blue-50 w-10 h-10 md:w-12 md:h-12 flex-shrink-0 flex items-center justify-center rounded-xl text-blue-600 transition-all">
                                <i class="fas fa-phone-alt text-base md:text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm md:text-base">Nomor Telepon</h4>
                                <a href="tel:{{ $settings->whatsapp ?? '08xxx' }}" class="text-slate-500 text-xs md:text-sm mt-1 hover:text-blue-600 transition-colors block">
                                    {{ $settings->whatsapp ?? '08xxx' }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Media Sosial --}}
                    <div class="mt-10 md:mt-12 pt-6 md:pt-8 border-t border-slate-100">
                        <h4 class="font-bold text-slate-400 text-xs uppercase tracking-widest mb-4 md:mb-5">Media Sosial</h4>
                        <div class="flex gap-3">
                            <a href="{{ $settings->facebook_url ?? '#' }}" 
                               class="social-btn w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg bg-slate-100 text-slate-500 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                <i class="fab fa-facebook-f text-xs md:text-sm"></i>
                            </a>
                            <a href="{{ $settings->instagram_url ?? '#' }}" 
                               class="social-btn w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg bg-slate-100 text-slate-500 hover:bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] hover:text-white transition-all shadow-sm">
                                <i class="fab fa-instagram text-xs md:text-sm"></i>
                            </a>
                            <a href="{{ $settings->tiktok_url ?? '#' }}" 
                               class="social-btn w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg bg-slate-100 text-slate-500 hover:bg-black hover:text-white transition-all shadow-sm">
                                <i class="fab fa-tiktok text-xs md:text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Sisi Kanan: Form WhatsApp --}}
                <div class="w-full lg:w-7/12 p-6 md:p-10 lg:p-12 bg-slate-50/50 border-l border-slate-100">
                    <h2 class="text-xl md:text-2xl font-black text-slate-800 mb-6 md:mb-8">Kirim Pesan</h2>
                    
                    <div class="space-y-4 md:space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-700 ml-1">Nama <span class="text-red-500">*</span></label>
                                <input type="text" id="wa_name" placeholder="Nama Lengkap" 
                                       class="custom-input w-full px-4 py-2.5 md:py-3 rounded-xl border border-slate-200 outline-none text-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-700 ml-1">Institusi/Perusahaan</label>
                                <input type="text" id="wa_company" placeholder="Nama Perusahaan" 
                                       class="custom-input w-full px-4 py-2.5 md:py-3 rounded-xl border border-slate-200 outline-none text-sm">
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-700 ml-1">Subjek</label>
                            <input type="text" id="wa_subject" placeholder="Keperluan apa?" 
                                   class="custom-input w-full px-4 py-2.5 md:py-3 rounded-xl border border-slate-200 outline-none text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-700 ml-1">Pesan <span class="text-red-500">*</span></label>
                            <textarea id="wa_message" rows="4" placeholder="Tulis pesan detail Anda..." 
                                      class="custom-input w-full px-4 py-2.5 md:py-3 rounded-xl border border-slate-200 outline-none text-sm resize-none"></textarea>
                        </div>
                        
                        <div class="pt-2 md:pt-4">
                            <button onclick="sendToWhatsApp()" 
                                    class="w-full btn-primary-gradient text-white font-bold py-3 md:py-4 rounded-xl shadow-lg hover:opacity-90 transition-all flex items-center justify-center gap-3 text-sm md:text-base">
                                <i class="fab fa-whatsapp text-lg md:text-xl"></i>
                                KIRIM KE WHATSAPP
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Map Section --}}
    <div class="map-container w-full h-[250px] md:h-[400px] grayscale hover:grayscale-0 transition-all duration-700 border-t border-slate-200">
        <iframe 
            class="w-full h-full"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.82343274384!2d106.8184852!3d-6.3314545!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ee2f3c3a9d9d%3A0xc3f3a6a9b4070a25!2sJl.%20Gandaria%20V%20No.11E%2C%20Jagakarsa%2C%20Jakarta%20Selatan!5e0!3m2!1sid!2sid!4v1700000000000" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>
</div>

<script>
function sendToWhatsApp() {
    let phoneNumber = "{{ $settings->whatsapp ?? '6285810761209' }}".replace(/[^0-9]/g, '');
    
    // Ubah 0 di depan jadi 62
    if (phoneNumber.startsWith('0')) {
        phoneNumber = '62' + phoneNumber.substring(1);
    }

    const name = document.getElementById('wa_name').value;
    const company = document.getElementById('wa_company').value;
    const subject = document.getElementById('wa_subject').value;
    const message = document.getElementById('wa_message').value;

    if(!name || !message) {
        alert("⚠️ Nama dan Pesan wajib diisi ya!");
        return;
    }

    const text = `*Halo CetakKilat!*%0A` +
                 `Saya ingin bertanya tentang layanan Anda:%0A%0A` +
                 `*Nama:* ${name}%0A` +
                 `*Perusahaan:* ${company || '-'}%0A` +
                 `*Subjek:* ${subject || '-'}%0A` +
                 `*Pesan:* ${message}`;

    window.open(`https://api.whatsapp.com/send?phone=${phoneNumber}&text=${text}`, '_blank');
}
</script>
@endsection