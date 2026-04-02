{{-- resources/views/partials/faq.blade.php --}}
<section id="faq" class="py-16 bg-gradient-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-animate>
            <span class="inline-block px-4 py-2 bg-primary-50 text-primary-700 rounded-full text-sm font-semibold tracking-wide mb-4">
                ❓ BANTUAN & PERTANYAAN
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-neutral-800 mb-4">
                Pertanyaan yang Sering Diajukan
            </h2>
            <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                Temukan jawaban untuk pertanyaan umum seputar layanan digital printing kami.
            </p>
        </div>

        <div class="max-w-3xl mx-auto">
            <!-- FAQ Accordion -->
            <div class="space-y-4" id="faq-accordion">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-xl border border-neutral-200 shadow-soft overflow-hidden" data-animate>
                    <button class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-neutral-50 transition-colors duration-200"
                            data-faq="1">
                        <span class="text-lg font-semibold text-neutral-800">
                            Berapa lama waktu pengerjaan untuk printing standar?
                        </span>
                        <svg class="faq-icon w-6 h-6 text-primary-600 transform transition-transform duration-300"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer px-6 pb-4 hidden" id="faq-answer-1">
                        <div class="pt-2 border-t border-neutral-100">
                            <p class="text-neutral-600 mb-3">
                                Waktu pengerjaan bervariasi tergantung jenis produk dan kuantitas:
                            </p>
                            <ul class="space-y-2 text-neutral-600">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-success-500 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Stiker & Brosur:</strong> 1-2 hari kerja</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-success-500 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Spanduk & Banner:</strong> 2-3 hari kerja</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-success-500 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Buku & Majalah:</strong> 3-5 hari kerja</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-success-500 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Custom Packaging:</strong> 5-7 hari kerja</span>
                                </li>
                            </ul>
                            <p class="mt-4 text-neutral-600">
                                <strong>Note:</strong> Waktu di atas sudah termasuk proses proofing dan approval.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-xl border border-neutral-200 shadow-soft overflow-hidden" data-animate>
                    <button class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-neutral-50 transition-colors duration-200"
                            data-faq="2">
                        <span class="text-lg font-semibold text-neutral-800">
                            Apa saja metode pembayaran yang tersedia?
                        </span>
                        <svg class="faq-icon w-6 h-6 text-primary-600 transform transition-transform duration-300"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer px-6 pb-4 hidden" id="faq-answer-2">
                        <div class="pt-2 border-t border-neutral-100">
                            <p class="text-neutral-600 mb-4">
                                Kami menerima berbagai metode pembayaran untuk kemudahan Anda:
                            </p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                                <div class="bg-neutral-50 rounded-lg p-3 text-center">
                                    <div class="text-2xl mb-1">🏦</div>
                                    <span class="text-sm font-medium text-neutral-700">Transfer Bank</span>
                                </div>
                                <div class="bg-neutral-50 rounded-lg p-3 text-center">
                                    <div class="text-2xl mb-1">💳</div>
                                    <span class="text-sm font-medium text-neutral-700">Credit Card</span>
                                </div>
                                <div class="bg-neutral-50 rounded-lg p-3 text-center">
                                    <div class="text-2xl mb-1">📱</div>
                                    <span class="text-sm font-medium text-neutral-700">E-Wallet</span>
                                </div>
                                <div class="bg-neutral-50 rounded-lg p-3 text-center">
                                    <div class="text-2xl mb-1">🤝</div>
                                    <span class="text-sm font-medium text-neutral-700">COD</span>
                                </div>
                                <div class="bg-neutral-50 rounded-lg p-3 text-center">
                                    <div class="text-2xl mb-1">🏪</div>
                                    <span class="text-sm font-medium text-neutral-700">Minimarket</span>
                                </div>
                                <div class="bg-neutral-50 rounded-lg p-3 text-center">
                                    <div class="text-2xl mb-1">⚡</div>
                                    <span class="text-sm font-medium text-neutral-700">Instant Payment</span>
                                </div>
                            </div>
                            <p class="text-sm text-neutral-500">
                                *COD tersedia untuk area tertentu dengan minimum order tertentu
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-xl border border-neutral-200 shadow-soft overflow-hidden" data-animate>
                    <button class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-neutral-50 transition-colors duration-200"
                            data-faq="3">
                        <span class="text-lg font-semibold text-neutral-800">
                            Bagaimana dengan kualitas dan bahan yang digunakan?
                        </span>
                        <svg class="faq-icon w-6 h-6 text-primary-600 transform transition-transform duration-300"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer px-6 pb-4 hidden" id="faq-answer-3">
                        <div class="pt-2 border-t border-neutral-100">
                            <p class="text-neutral-600 mb-4">
                                Kami hanya menggunakan bahan-bahan premium dengan kualitas terbaik:
                            </p>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="bg-primary-50 rounded-lg p-2 mr-3">
                                        <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-neutral-800">Ink Technology</h4>
                                        <p class="text-sm text-neutral-600">Menggunakan tinta UV dan eco-solvent dengan ketahanan hingga 5 tahun outdoor</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="bg-primary-50 rounded-lg p-2 mr-3">
                                        <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-neutral-800">Paper Quality</h4>
                                        <p class="text-sm text-neutral-600">Berkisar dari Art Paper 120gsm hingga Ivory Board 400gsm sesuai kebutuhan</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="bg-primary-50 rounded-lg p-2 mr-3">
                                        <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-neutral-800">Quality Control</h4>
                                        <p class="text-sm text-neutral-600">Setiap produk melalui 3 tahap quality check sebelum dikirim</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-xl border border-neutral-200 shadow-soft overflow-hidden" data-animate>
                    <button class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-neutral-50 transition-colors duration-200"
                            data-faq="4">
                        <span class="text-lg font-semibold text-neutral-800">
                            Apakah tersedia layanan desain jika saya belum punya desain?
                        </span>
                        <svg class="faq-icon w-6 h-6 text-primary-600 transform transition-transform duration-300"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer px-6 pb-4 hidden" id="faq-answer-4">
                        <div class="pt-2 border-t border-neutral-100">
                            <p class="text-neutral-600 mb-4">
                                Ya! Kami menyediakan layanan desain profesional dengan tim desainer berpengalaman:
                            </p>
                            <div class="grid md:grid-cols-2 gap-6 mb-4">
                                <div class="bg-gradient-to-br from-primary-50 to-white p-5 rounded-xl">
                                    <h4 class="font-bold text-lg text-neutral-800 mb-2">💡 Paket Desain Basic</h4>
                                    <ul class="space-y-2 text-neutral-600">
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-success-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Konsultasi konsep gratis
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-success-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            2x revisi desain
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-success-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            File siap cetak
                                        </li>
                                    </ul>
                                </div>
                                <div class="bg-gradient-to-br from-secondary-50 to-white p-5 rounded-xl">
                                    <h4 class="font-bold text-lg text-neutral-800 mb-2">🎨 Paket Desain Premium</h4>
                                    <ul class="space-y-2 text-neutral-600">
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-success-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Unlimited revisi
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-success-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Desain custom kompleks
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-success-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Source file + copyright
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <a href="" class="inline-flex items-center text-primary-600 font-semibold hover:text-primary-700">
                                Lihat detail layanan desain
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white rounded-xl border border-neutral-200 shadow-soft overflow-hidden" data-animate>
                    <button class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-neutral-50 transition-colors duration-200"
                            data-faq="5">
                        <span class="text-lg font-semibold text-neutral-800">
                            Bagaimana cara melakukan order dan berapa minimum order?
                        </span>
                        <svg class="faq-icon w-6 h-6 text-primary-600 transform transition-transform duration-300"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer px-6 pb-4 hidden" id="faq-answer-5">
                        <div class="pt-2 border-t border-neutral-100">
                            <div class="grid md:grid-cols-2 gap-8">
                                <div>
                                    <h4 class="font-bold text-lg text-neutral-800 mb-3">📋 Cara Order:</h4>
                                    <ol class="space-y-3 text-neutral-600">
                                        <li class="flex items-start">
                                            <span class="bg-primary-100 text-primary-800 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">1</span>
                                            Pilih produk & konfigurasi spesifikasi
                                        </li>
                                        <li class="flex items-start">
                                            <span class="bg-primary-100 text-primary-800 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">2</span>
                                            Upload file desain atau gunakan jasa desain kami
                                        </li>
                                        <li class="flex items-start">
                                            <span class="bg-primary-100 text-primary-800 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">3</span>
                                            Konfirmasi proofing digital
                                        </li>
                                        <li class="flex items-start">
                                            <span class="bg-primary-100 text-primary-800 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">4</span>
                                            Lakukan pembayaran
                                        </li>
                                        <li class="flex items-start">
                                            <span class="bg-primary-100 text-primary-800 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">5</span>
                                            Produk diproses & dikirim
                                        </li>
                                    </ol>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-neutral-800 mb-3">📦 Minimum Order:</h4>
                                    <div class="space-y-3">
                                        <div class="bg-neutral-50 rounded-lg p-4">
                                            <p class="font-medium text-neutral-800">Stiker & Label</p>
                                            <p class="text-neutral-600">Minimum 25 pcs / desain</p>
                                        </div>
                                        <div class="bg-neutral-50 rounded-lg p-4">
                                            <p class="font-medium text-neutral-800">Brosur & Flyer</p>
                                            <p class="text-neutral-600">Minimum 100 pcs / desain</p>
                                        </div>
                                        <div class="bg-neutral-50 rounded-lg p-4">
                                            <p class="font-medium text-neutral-800">Buku & Majalah</p>
                                            <p class="text-neutral-600">Minimum 25 eksemplar</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ CTA -->
            <div class="mt-12 text-center" data-animate>
                <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-2xl p-8 border border-primary-100">
                    <h3 class="text-2xl font-bold text-neutral-800 mb-3">
                        Masih ada pertanyaan?
                    </h3>
                    <p class="text-neutral-600 mb-6 max-w-xl mx-auto">
                        Tim customer service kami siap membantu Anda 7x24 jam melalui berbagai channel.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="https://wa.me/6281234567890?text=Halo%20PrintPro,%20saya%20ada%20pertanyaan%20tentang%20layanan%20printing"
                           target="_blank"
                           class="inline-flex items-center justify-center bg-success-600 hover:bg-success-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-300 shadow-soft hover:shadow-dp">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm.01 1.67c2.33 0 4.52.91 6.17 2.56a8.676 8.676 0 012.58 6.14c0 4.84-3.94 8.78-8.78 8.78-1.48 0-2.93-.37-4.2-1.07l-.3-.17-3.12.82.83-3.04-.2-.32a8.5 8.5 0 01-1.26-4.55c0-2.4.93-4.65 2.62-6.35a8.88 8.88 0 016.36-2.63z"/>
                            </svg>
                            Chat WhatsApp
                        </a>
                        <a href="mailto:info@printpro.com"
                           class="inline-flex items-center justify-center bg-white hover:bg-neutral-50 text-neutral-800 font-semibold px-6 py-3 rounded-lg border border-neutral-300 transition-colors duration-300 shadow-soft hover:shadow-dp">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Email Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // FAQ Accordion functionality
        const faqQuestions = document.querySelectorAll('.faq-question');
        
        faqQuestions.forEach(question => {
            question.addEventListener('click', function() {
                const faqId = this.getAttribute('data-faq');
                const answer = document.getElementById(`faq-answer-${faqId}`);
                const icon = this.querySelector('.faq-icon');
                
                // Toggle current FAQ
                answer.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
                
                // Optional: Close other FAQs
                // faqQuestions.forEach(otherQuestion => {
                //     if (otherQuestion !== this) {
                //         const otherFaqId = otherQuestion.getAttribute('data-faq');
                //         const otherAnswer = document.getElementById(`faq-answer-${otherFaqId}`);
                //         const otherIcon = otherQuestion.querySelector('.faq-icon');
                //         
                //         otherAnswer.classList.add('hidden');
                //         otherIcon.classList.remove('rotate-180');
                //     }
                // });
            });
        });
        
        // FAQ Search functionality (optional enhancement)
        const faqSearch = document.createElement('div');
        faqSearch.innerHTML = `
            <div class="max-w-md mx-auto mb-8" data-animate>
                <div class="relative">
                    <input type="text" 
                           id="faq-search" 
                           placeholder="Cari pertanyaan..." 
                           class="w-full px-4 py-3 pl-12 rounded-xl border border-neutral-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all duration-300 shadow-soft">
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-neutral-400" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        `;
        
        // Insert search after FAQ title
        const faqTitle = document.querySelector('#faq .text-center');
        if (faqTitle) {
            faqTitle.parentNode.insertBefore(faqSearch, faqTitle.nextSibling);
            
            // Add search functionality
            const searchInput = document.getElementById('faq-search');
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const faqItems = document.querySelectorAll('[data-animate]');
                
                faqItems.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        item.style.display = '';
                        // Trigger animation
                        item.classList.add('animate-fade-in-up');
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>

<style>
    .faq-question {
        cursor: pointer;
        outline: none;
    }
    
    .faq-question:focus {
        outline: 2px solid var(--primary-500);
        outline-offset: 2px;
    }
    
    .faq-answer {
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .rotate-180 {
        transform: rotate(180deg);
    }
</style>