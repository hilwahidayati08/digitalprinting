@extends('admin.guest')

@section('title', 'Hubungi Kami - PrintPro')

@section('content')
{{-- Load FontAwesome Direct Link --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="bg-white">
    <div class="relative bg-blue-900 py-24 px-4 overflow-hidden">
        <div class="relative max-w-7xl mx-auto text-center text-white">
            <h1 class="text-4xl md:text-6xl font-black mb-4 tracking-tight">Kontak Kami</h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto font-medium">
                PrintPro siap memberikan solusi cetak digital terbaik sesuai kebutuhan bisnis dan personal Anda.
            </p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 -mt-20 pb-20 relative z-20">
        <div class="bg-white rounded-[2rem] shadow-2xl flex flex-wrap overflow-hidden border border-gray-100">
            
            <div class="w-full lg:w-5/12 p-10 md:p-14 bg-white">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Get in touch</h2>
                <p class="text-gray-500 mb-12 text-sm leading-relaxed">Kami hadir untuk membantu Anda. Hubungi kami melalui saluran di bawah ini.</p>

                <div class="space-y-10">
<div class="flex items-start gap-5">
    <div class="bg-blue-600 w-12 h-14 flex-shrink-0 flex items-center justify-center rounded-2xl text-white shadow-lg shadow-blue-200">
        <i class="fas fa-map-marker-alt text-xl"></i>
    </div>
    <div>
        <h4 class="font-bold text-gray-900 text-lg leading-tight">Kantor Pusat</h4>
        <p class="text-gray-500 text-sm leading-relaxed mt-1">
            {{ $settings->address ?? 'Jl. Gandaria V No.11E, Jagakarsa, Jakarta Selatan' }}
        </p>
    </div>
</div>

                    <div class="flex items-start gap-5">
                        <div class="bg-blue-600 w-12 h-12 flex items-center justify-center rounded-2xl text-white shadow-lg">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">Email</h4>
                            <p class="text-gray-500 text-sm">{{ $settings->email ?? 'info@printpro.id' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-5">
                        <div class="bg-blue-600 w-12 h-12 flex items-center justify-center rounded-2xl text-white shadow-lg">
                            <i class="fas fa-phone-alt text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">Nomor Telepon</h4>
                            <p class="text-gray-500 text-sm">{{ $settings->whatsapp ?? '08xxx' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-16">
                    <h4 class="font-bold text-gray-900 mb-6 italic">Sosial Media</h4>
                    <div class="flex gap-4">
                        <a href="{{ $settings->facebook_url ?? '#' }}" class="w-12 h-12 flex items-center justify-center rounded-full bg-[#1877F2] text-white hover:scale-110 transition shadow-md">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="{{ $settings->instagram_url ?? '#' }}" class="w-12 h-12 flex items-center justify-center rounded-full bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] text-white hover:scale-110 transition shadow-md">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="{{ $settings->tiktok_url ?? '#' }}" class="w-12 h-12 flex items-center justify-center rounded-full bg-black text-white hover:scale-110 transition shadow-md">
                            <i class="fab fa-tiktok text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-7/12 p-10 md:p-14 bg-gray-50/50 border-l border-gray-100">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-10 text-center lg:text-left">Kirim Pesan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="text-sm font-bold text-gray-700">Nama</label>
                        <input type="text" id="wa_name" placeholder="Nama Panjang" class="w-full px-5 py-4 rounded-2xl border border-gray-200 outline-none focus:border-blue-500 transition shadow-sm">
                    </div>
                    <div class="space-y-3">
                        <label class="text-sm font-bold text-gray-700">Institusi/Perusahan</label>
                        <input type="text" id="wa_company" placeholder="Institusi atau Perusahaan" class="w-full px-5 py-4 rounded-2xl border border-gray-200 outline-none focus:border-blue-500 transition shadow-sm">
                    </div>
                    <div class="md:col-span-2 space-y-3">
                        <label class="text-sm font-bold text-gray-700">Judul</label>
                        <input type="text" id="wa_subject" placeholder="Ketik Judul" class="w-full px-5 py-4 rounded-2xl border border-gray-200 outline-none focus:border-blue-500 transition shadow-sm">
                    </div>
                    <div class="md:col-span-2 space-y-3">
                        <label class="text-sm font-bold text-gray-700">Pesan</label>
                        <textarea id="wa_message" rows="4" placeholder="Tulis pesan Anda..." class="w-full px-5 py-4 rounded-2xl border border-gray-200 outline-none focus:border-blue-500 transition shadow-sm"></textarea>
                    </div>
                    <div class="md:col-span-2 mt-4">
                        <button onclick="sendToWhatsApp()" class="w-full bg-blue-600 text-white font-black py-5 rounded-2xl shadow-xl hover:bg-blue-700 hover:-translate-y-1 transition-all flex items-center justify-center gap-3">
                            <i class="fab fa-whatsapp text-2xl"></i>
                            KIRIM KE WHATSAPP
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full h-[450px] relative mt-10">
        <iframe 
            class="w-full h-full grayscale border-0 hover:grayscale-0 transition-all duration-700"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.733527780005!2d106.81881517586888!3d-6.298782993690466!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f2195f4e1957%3A0xc3f60f640c57d770!2sJl.%20Gandaria%20V%20No.11E%2C%20RT.10%2FRW.2%2C%20Jagakarsa%2C%20Kec.%20Jagakarsa%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2012620!5e0!3m2!1sid!2sid!4v1709400000000!5m2!1sid!2sid" 
            allowfullscreen="" loading="lazy">
        </iframe>
    </div>
</div>

<script>
function sendToWhatsApp() {
    const phoneNumber = "{{ $settings->whatsapp ?? '6285810761209' }}".replace(/[^0-9]/g, '');    
    const name = document.getElementById('wa_name').value;
    const company = document.getElementById('wa_company').value;
    const subject = document.getElementById('wa_subject').value;
    const message = document.getElementById('wa_message').value;

    if(!name || !message) {
        alert("Nama dan Pesan wajib diisi ya!");
        return;
    }

    const text = `*Halo PrintPro!*%0A` +
                 `Saya ingin bertanya tentang layanan Anda:%0A%0A` +
                 `*Nama:* ${name}%0A` +
                 `*Perusahaan:* ${company || '-'}%0A` +
                 `*Subjek:* ${subject}%0A` +
                 `*Pesan:* ${message}`;

    window.open(`https://wa.me/${phoneNumber}?text=${text}`, '_blank');
}
</script>
@endsection