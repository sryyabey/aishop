<div class="ticker-container" id="tickerContainer" style="display: none;">
    <div class="ticker-wrapper">
        <span class="horizontal-ticker__item">❤️ %100 İade Garantisi ❤️</span>
        <span class="horizontal-ticker__item">🚚 Ücretsiz Kargo 🚚</span>
        <span class="horizontal-ticker__item">❤️ %100 İade Garantisi ❤️</span>
        <span class="horizontal-ticker__item">🚚 Ücretsiz Kargo 🚚</span> 
    </div>
</div>

<style>
.ticker-container {
    width: 100%;
    max-width: 100%;
    background: #8B4513;
    overflow: hidden;
    padding: 10px 0;
    position: relative;
    z-index: 10;
    box-sizing: border-box;
}

.ticker-wrapper {
    display: flex;
    animation: ticker 20s linear infinite;
    white-space: nowrap;
}

.horizontal-ticker__item {
    color: #fff;
    font-size: 16px;
    padding: 0 30px;
    display: inline-flex;
    align-items: center;
    flex-shrink: 0;
    margin: 0;
}

/* Mobil uyumluluk */
@media screen and (max-width: 768px) {
    .horizontal-ticker__item {
        font-size: 14px;
        padding: 0 20px;
    }
}

/* Animasyon */
@keyframes ticker {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}

/* Tüm elemanların box-sizing ayarı */
.ticker-container,
.ticker-wrapper,
.horizontal-ticker__item {
    box-sizing: border-box;
}

.ticker-container:hover .ticker-wrapper {
    animation-play-state: paused;
}
</style>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // Sayfa yüklenme sayacı
        let pageLoadCount = localStorage.getItem('pageLoadCount') || 0;
        pageLoadCount = parseInt(pageLoadCount) + 1;
        localStorage.setItem('pageLoadCount', pageLoadCount);
        
        // 3 site yüklenme kontrolü
        if (pageLoadCount >= 3) {
            const tickerContainer = document.getElementById('tickerContainer');
            if (tickerContainer) {
                tickerContainer.style.display = 'block';
            }
        }
    });
</script>