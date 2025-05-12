<style>
.ticker-container {
    width: 100%;
    background: #8B4513;
    overflow: hidden;
    padding: 10px 0;
    position: relative;
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
}

/* Mobil uyumluluk: Yazı boyutu ve padding ayarı */
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

/* Hover durumunda animasyonu durdur */
.ticker-container:hover .ticker-wrapper {
    animation-play-state: paused;
}
</style>

<!-- Header altına eklenecek HTML -->
<div class="ticker-container">
    <div class="ticker-wrapper">
        <p class="horizontal-ticker__item">❤️ %100 İade Garantisi ❤️</p>
        <p class="horizontal-ticker__item">🚚 Ücretsiz Kargo 🚚</p>
        <p class="horizontal-ticker__item">❤️ %100 İade Garantisi ❤️</p>
        <p class="horizontal-ticker__item">🚚 Ücretsiz Kargo 🚚</p> 
    </div>
</div>
