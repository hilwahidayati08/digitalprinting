{{--
    Partial untuk ditambahkan di halaman checkout (checkout/index.blade.php)
    Taruh di bagian ringkasan order / order summary

    Contoh pemakaian:
    @include('frontend.checkout._komisi', ['user' => auth()->user(), 'subtotal' => $subtotal, 'discountMember' => $discountMember, 'commissionEarned' => $commissionEarned])
--}}

@if($user->is_member)
<div class="mt-4 space-y-3">

    {{-- Info diskon member --}}
    <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-crown text-emerald-500 text-sm"></i>
                <span class="text-sm font-semibold text-emerald-700">Harga Member</span>
            </div>
            <span class="text-sm font-bold text-emerald-700">
                - Rp {{ number_format($discountMember, 0, ',', '.') }}
            </span>
        </div>
        <p class="text-xs text-emerald-600 mt-1">
            + Kamu akan dapat komisi <strong>Rp {{ number_format($commissionEarned, 0, ',', '.') }}</strong>
            setelah order selesai dibayar
        </p>
    </div>

    {{-- Opsi pakai saldo komisi --}}
    @if($user->saldo_komisi > 0)
    <div class="p-4 bg-primary-50 border border-primary-100 rounded-xl">
        <label class="flex items-start gap-3 cursor-pointer">
            <input type="checkbox" name="pakai_komisi" value="1"
                   id="pakaiKomisi"
                   {{ old('pakai_komisi') ? 'checked' : '' }}
                   class="mt-0.5 w-4 h-4 text-primary-600 rounded border-gray-300 focus:ring-primary-500">
            <div>
                <p class="text-sm font-semibold text-primary-700">
                    Gunakan Saldo Komisi
                </p>
                <p class="text-xs text-primary-600 mt-0.5">
                    Saldo kamu: <strong>{{ $user->saldo_komisi_formatted }}</strong>
                    — akan dipotong dari total tagihan
                </p>
            </div>
        </label>
    </div>
    @endif

</div>
@endif