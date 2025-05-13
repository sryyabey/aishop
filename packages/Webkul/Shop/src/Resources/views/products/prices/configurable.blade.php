<div class="flex items-center gap-3">
    @php
        // Normal fiyatı alın
        $regularPrice = isset($prices['regular']['price']) ? $prices['regular']['price'] : 0;
        
        // %40 fazlasını hesaplayın (normal fiyatın 1.4 katı)
        $oldPrice = $regularPrice * 1.4;
        
        // Para birimi formatını alın
        $currencySymbol = isset($prices['regular']['formatted_price']) 
            ? preg_replace('/[0-9\., ]+/', '', $prices['regular']['formatted_price']) 
            : '₺';
        
        // Sayı formatını belirleyin (varsayılan olarak iki ondalık)
        $formattedOldPrice = $currencySymbol . number_format($oldPrice, 2, ',', '.');
    @endphp

    <!-- Sol tarafta %40 fazla fiyat (üstü çizili) -->
    <p class="old-price text-lg font-semibold text-gray-500 line-through">
        {{ $formattedOldPrice }}
    </p>

    <!-- Sağ tarafta normal fiyat -->
    <p class="final-price font-semibold text-red-500">
        {{ $prices['regular']['formatted_price'] ?? '' }}
    </p>
    
    <!-- İsteğe bağlı indirim rozeti -->
    <span class="discount-badge inline-block bg-red-100 text-red-700 text-xs font-medium rounded px-2 py-1">
        %40 İndirim
    </span>
</div>

<!--<p class="price-label text-sm text-zinc-500 max-sm:text-xs mt-1">
    @lang('shop::app.products.prices.configurable.as-low-as')
</p>-->