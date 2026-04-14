@extends('admin.guest')

@section('title', 'PrintPro - Digital Printing & Ecommerce')

@section('content')

    @include('partials.home.hero')

    @include('partials.home.about')

    @include('partials.home.products')

    @include('partials.home.member')

    @include('partials.home.portfolio')

    @include('partials.home.services')

    @include('partials.home.faq')

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Tutup modal dengan Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('modalMember');
            if (modal) modal.classList.add('hidden');
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const faqItems = document.querySelectorAll('.faq-item');
        let activeFaq = null;

        faqItems.forEach(item => {
            const button = item.querySelector('.faq-toggle');
            const content = item.querySelector('.faq-content');
            const arrow = button.querySelector('.faq-arrow');

            button.addEventListener('click', function () {
                const isActive = item === activeFaq;

                if (activeFaq && activeFaq !== item) {
                    const activeButton = activeFaq.querySelector('.faq-toggle');
                    const activeContent = activeFaq.querySelector('.faq-content');
                    const activeArrow = activeButton.querySelector('.faq-arrow');
                    activeButton.setAttribute('aria-expanded', 'false');
                    activeContent.style.maxHeight = '0';
                    activeContent.style.opacity = '0';
                    activeArrow.style.transform = 'rotate(0deg)';
                    setTimeout(() => { activeContent.style.overflow = 'hidden'; }, 150);
                }

                if (isActive) {
                    button.setAttribute('aria-expanded', 'false');
                    content.style.maxHeight = '0';
                    content.style.opacity = '0';
                    arrow.style.transform = 'rotate(0deg)';
                    activeFaq = null;
                    setTimeout(() => { content.style.overflow = 'hidden'; }, 150);
                    return;
                }

                button.setAttribute('aria-expanded', 'true');
                content.style.overflow = 'hidden';
                content.style.opacity = '1';
                const contentHeight = content.scrollHeight + 20;
                content.style.maxHeight = contentHeight + 'px';
                arrow.style.transform = 'rotate(180deg)';
                setTimeout(() => { content.style.overflow = 'visible'; }, 300);
                activeFaq = item;

                if (!isElementInViewport(item)) {
                    item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            });

            button.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
                if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    const currentIndex = Array.from(faqItems).indexOf(item);
                    let nextIndex;
                    if (e.key === 'ArrowDown') {
                        nextIndex = (currentIndex + 1) % faqItems.length;
                    } else {
                        nextIndex = (currentIndex - 1 + faqItems.length) % faqItems.length;
                    }
                    faqItems[nextIndex].querySelector('.faq-toggle').focus();
                }
            });
        });

        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }
    });
</script>

<style>
    .faq-content { transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease; }
    .faq-toggle { cursor: pointer; transition: background-color 0.2s ease; }
    .faq-toggle:hover { background-color: #f8fafc; }
    .faq-toggle:focus { outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    .faq-arrow { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .prose { line-height: 1.6; }
    .prose ul { margin-top: 0.5rem; margin-bottom: 0.5rem; padding-left: 1.5rem; }
    .prose ol { margin-top: 0.5rem; margin-bottom: 0.5rem; padding-left: 1.5rem; }
    .prose li { margin-bottom: 0.25rem; }
    .prose strong { color: #1f2937; font-weight: 600; }
    .prose p { margin-bottom: 0.75rem; }
    .prose p:last-child { margin-bottom: 0; }
</style>
@endpush