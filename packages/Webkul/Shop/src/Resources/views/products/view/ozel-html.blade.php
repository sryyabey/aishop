@push('styles')
<style>
    .ks-reset * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
    }
    
    .ks-body {
        background-color: #fcf7f2;
        color: #333;
        line-height: 1.6;
    }
    
    .ks-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .ks-section {
        padding: 60px 20px;
    }
    
    .ks-section-title {
        font-size: 32px;
        font-weight: bold;
        color: #8B4513;
        margin-bottom: 20px;
    }
    
    .ks-section-text {
        font-size: 18px;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    
    .ks-flex-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 40px;
        align-items: center;
    }
    
    /* Hero section */
    .ks-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 80px 20px;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
        border-radius: 0 0 30px 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    
    .ks-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="10" cy="10" r="1" fill="white" opacity="0.3"/><circle cx="30" cy="40" r="0.5" fill="white" opacity="0.3"/><circle cx="50" cy="20" r="0.8" fill="white" opacity="0.3"/><circle cx="70" cy="50" r="0.4" fill="white" opacity="0.3"/><circle cx="90" cy="30" r="0.6" fill="white" opacity="0.3"/></svg>');
        opacity: 0.4;
    }
    
    .ks-hero-content {
        position: relative;
        z-index: 2;
    }
    
    .ks-hero-title {
        font-size: 42px;
        color: white;
        margin-bottom: 20px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        animation: fadeInUp 0.8s ease-out;
    }
    
    .ks-hero-subtitle {
        font-size: 20px;
        max-width: 800px;
        margin: 0 auto 40px;
        line-height: 1.6;
        animation: fadeInUp 1s ease-out;
    }
    
    .ks-btn {
        display: inline-block;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 14px 36px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        font-size: 18px;
        box-shadow: 0 4px 15px rgba(0, 242, 254, 0.3);
        animation: pulse 2s infinite;
    }
    
    .ks-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 242, 254, 0.4);
    }
    
    /* Benefits section */
    .ks-benefits-container {
        max-width: 1200px;
        margin: 80px auto;
        padding: 40px 20px;
        text-align: center;
        position: relative;
    }
    
    .ks-benefits-header {
        margin-bottom: 60px;
        animation: fadeInUp 0.8s ease-out;
    }
    
    .ks-benefits-content {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: stretch;
        gap: 30px;
    }
    
    .ks-benefits-column {
        display: flex;
        flex-direction: column;
        gap: 30px;
        width: 25%;
    }
    
    .ks-benefit-item {
        text-align: center;
        background-color: white;
        padding: 30px 20px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .ks-benefit-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .ks-benefit-icon {
        margin-bottom: 20px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        background: linear-gradient(135deg, #00f2fe, #4facfe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .ks-benefit-item h3 {
        font-size: 22px;
        margin-bottom: 15px;
        font-weight: bold;
        color: #1a1a2e;
    }
    
    .ks-benefit-item p {
        font-size: 16px;
        line-height: 1.5;
        color: #666;
    }
    
    .ks-image-container {
        width: 40%;
        padding: 0 20px;
        position: relative;
    }
    
    .ks-product-image {
        width: 100%;
        max-width: 400px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transition: all 0.5s ease;
    }
    
    .ks-image-container:hover .ks-product-image {
        transform: translateY(-10px) rotate(5deg);
    }
    
    /* Comparison section */
    .ks-comparison-container {
        max-width: 1200px;
        margin: 80px auto;
        padding: 0 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 50px;
        align-items: center;
    }
    
    .ks-comparison-left {
        flex: 1;
        min-width: 300px;
        animation: fadeInLeft 1s ease-out;
    }
    
    .ks-comparison-title {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #1a1a2e;
        position: relative;
        padding-bottom: 15px;
    }
    
    .ks-comparison-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        width: 80px;
        background: linear-gradient(135deg, #00f2fe, #4facfe);
        border-radius: 2px;
    }
    
    .ks-comparison-description {
        font-size: 18px;
        line-height: 1.8;
        margin-bottom: 40px;
        color: #444;
    }
    
    .ks-comparison-right {
        flex: 1;
        min-width: 350px;
        animation: fadeInRight 1s ease-out;
    }
    
    .ks-comparison-table {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        background-color: white;
    }
    
    .ks-table-row {
        display: flex;
    }
    
    .ks-table-header {
        display: flex;
        border: none;
        color: white;
    }
    
    .ks-table-header-cell {
        flex: 1;
        padding: 18px;
        font-weight: 600;
        text-align: center;
        font-size: 18px;
        color:black;
    }
    
    .ks-table-feature {
        flex: 1;
        padding: 18px;
        background-color: #f8f9fa;
        color: #1a1a2e;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-weight: 600;
        font-size: 16px;
        border-bottom: 1px solid #eee;
    }
    
    .ks-table-value {
        flex: 1;
        padding: 18px;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fff;
        border-bottom: 1px solid #eee;
    }
    
    .ks-check-icon {
        color: #4facfe;
        font-size: 28px;
        font-weight: bold;
    }
    
    .ks-x-icon {
        color: #f44336;
        font-size: 24px;
        font-weight: bold;
    }
    
    /* Stats section */
    .ks-stats-container {
        display: flex;
        max-width: 1200px;
        margin: 80px auto;
        gap: 60px;
        padding: 0 20px;
        align-items: center;
    }
    
    .ks-stats-image {
        flex: 1;
        min-width: 300px;
        position: relative;
        animation: fadeInLeft 1s ease-out;
    }
    
    .ks-stats-image img {
        width: 100%;
        height: auto;
        border-radius: 20px;
        object-fit: cover;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transition: all 0.5s ease;
    }
    
    .ks-stats-image:hover img {
        transform: scale(1.03);
    }
    
    .ks-stats-content {
        flex: 1;
        min-width: 300px;
        display: flex;
        flex-direction: column;
        animation: fadeInRight 1s ease-out;
    }
    
    .ks-stats-title {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 40px;
        color: #1a1a2e;
        position: relative;
        padding-bottom: 15px;
    }
    
    .ks-stats-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        width: 80px;
        background: linear-gradient(135deg, #00f2fe, #4facfe);
        border-radius: 2px;
    }
    
    .ks-stats-list {
        display: flex;
        flex-direction: column;
        gap: 30px;
        margin-bottom: 40px;
    }
    
    .ks-stat-item {
        display: flex;
        align-items: center;
        gap: 25px;
        padding: 5px 0;
    }
    
    .ks-circular-progress {
        position: relative;
        width: 90px;
        height: 90px;
    }
    
    .ks-circle-container {
        position: relative;
        width: 90px;
        height: 90px;
    }
    
    .ks-circle-bg {
        fill: none;
        stroke: #e6e6e6;
        stroke-width: 6;
    }
    
    .ks-circle-fill {
        fill: none;
        stroke: url(#gradient);
        stroke-width: 6;
        stroke-linecap: round;
        transform: rotate(-90deg);
        transform-origin: center;
        transition: stroke-dashoffset 1.5s ease-in-out;
    }
    
    .ks-percentage {
        position: absolute;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
    }
    
    .ks-stat-description {
        flex: 1;
        font-size: 18px;
        line-height: 1.5;
        margin: 0;
        color: #444;
    }
    
    .ks-stat-divider {
        height: 1px;
        background: linear-gradient(90deg, rgba(0,242,254,0.2), rgba(79,172,254,0.2), rgba(0,242,254,0.2));
        margin: 5px 0;
    }
    
    /* FAQ section */
    .ks-faq-section {
        max-width: 1200px;
        margin: 80px auto;
        padding: 0 20px;
        background-color: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .ks-faq-header {
        text-align: center;
        margin-bottom: 50px;
        padding: 40px;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: white;
        position: relative;
        overflow: hidden;
        border-radius: 0 0 20px 20px;
    }
    
    .ks-faq-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="10" cy="10" r="1" fill="white" opacity="0.3"/><circle cx="30" cy="40" r="0.5" fill="white" opacity="0.3"/><circle cx="50" cy="20" r="0.8" fill="white" opacity="0.3"/><circle cx="70" cy="50" r="0.4" fill="white" opacity="0.3"/><circle cx="90" cy="30" r="0.6" fill="white" opacity="0.3"/></svg>');
        opacity: 0.2;
    }
    
    .ks-faq-title {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 20px;
        color: white;
        position: relative;
        z-index: 1;
    }
    
    .ks-faq-subtitle {
        font-size: 18px;
        max-width: 700px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }
    
    .ks-faq-container {
        margin: 0 auto;
        max-width: 800px;
        padding: 0 20px 40px;
    }
    
    .ks-faq-item {
        background: #fff;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        border: 1px solid #eee;
        overflow: hidden;
    }
    
    .ks-faq-question {
        padding: 22px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        user-select: none;
        transition: all 0.3s ease;
    }
    
    .ks-faq-question:hover {
        background-color: rgba(79, 172, 254, 0.05);
    }
    
    .ks-faq-question h3 {
        font-size: 18px;
        margin: 0;
        color: #1a1a2e;
        transition: color 0.3s ease;
    }
    
    .ks-faq-item.active .ks-faq-question h3 {
        color: #4facfe;
    }
    
    .ks-faq-answer {
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        opacity: 0;
        background-color: #f9f9f9;
    }
    
    .ks-faq-item.active .ks-faq-answer {
        padding: 20px 25px;
        max-height: 500px;
        opacity: 1;
    }
    
    .ks-faq-arrow {
        transition: transform 0.4s ease;
        fill: #1a1a2e;
    }
    
    .ks-faq-item.active .ks-faq-arrow {
        transform: rotate(180deg);
        fill: #4facfe;
    }
    
    .ks-faq-answer p {
        margin: 0;
        padding: 0;
        font-size: 16px;
        line-height: 1.8;
        color: #555;
    }
    
    .ks-faq-cta {
        text-align: center;
        margin: 50px 0;
    }
    
    /* Footer */
    .ks-footer {
        background-color: #1a1a2e;
        color: white;
        padding: 60px 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .ks-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="10" cy="10" r="1" fill="white" opacity="0.3"/><circle cx="30" cy="40" r="0.5" fill="white" opacity="0.3"/><circle cx="50" cy="20" r="0.8" fill="white" opacity="0.3"/><circle cx="70" cy="50" r="0.4" fill="white" opacity="0.3"/><circle cx="90" cy="30" r="0.6" fill="white" opacity="0.3"/></svg>');
        opacity: 0.1;
    }
    
    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(79, 172, 254, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(79, 172, 254, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(79, 172, 254, 0);
        }
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .ks-hero-title {
            font-size: 36px;
        }
        
        .ks-hero-subtitle {
            font-size: 18px;
        }
        
        
        .ks-image-container {
            width: 50%;
        }
    }
    
    @media (max-width: 768px) {
        .ks-hero {
            padding: 60px 15px;
        }
        
        .ks-hero-title {
            font-size: 30px;
        }
        
        .ks-section-title, 
        .ks-comparison-title,
        .ks-stats-title,
        .ks-faq-title {
            font-size: 28px;
        }
        
        .ks-flex-wrap {
            flex-direction: column;
        }
        
        
        .ks-image-container {
            width: 90%;
            order: 1;
            margin: 30px 0;
        }
        
        .ks-comparison-container,
        .ks-stats-container {
            flex-direction: column;
        }
        
        .ks-comparison-left,
        .ks-comparison-right,
        .ks-stats-image,
        .ks-stats-content {
            width: 100%;
        }
        
        .ks-table-header-cell,
        .ks-table-feature,
        .ks-table-value {
            padding: 12px;
            font-size: 14px;
        }
        
        .ks-btn {
            padding: 12px 25px;
            font-size: 16px;
        }
    }
    
    @media (max-width: 576px) {
        .ks-hero-title {
            font-size: 26px;
        }
        
        .ks-hero-subtitle {
            font-size: 16px;
        }
        
        
        .ks-section-title, 
        .ks-comparison-title,
        .ks-stats-title,
        .ks-faq-title {
            font-size: 24px;
        }
        
        
        .ks-btn {
            width: 100%;
        }
        
        .ks-stat-item {
            flex-direction: column;
            text-align: center;
        }
        
        .ks-stat-description {
            text-align: center;
        }
    }
    
    @media (max-width: 375px) {
        .ks-hero-title {
            font-size: 24px;
        }
        
        .ks-section-title, 
        .ks-comparison-title,
        .ks-stats-title,
        .ks-faq-title {
            font-size: 22px;
        }
        
        .ks-table-header-cell,
        .ks-table-feature,
        .ks-table-value {
            padding: 10px;
            font-size: 13px;
        }
    }

        /* Benefits section için mobil düzenlemeler */
    @media (max-width: 768px) {
        .ks-benefits-content {
            flex-direction: column;
            gap: 20px;
        }
        
        .ks-benefits-column {
            width: 100%;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .ks-benefit-item {
            width: calc(50% - 8px);
            margin: 0;
            min-height: 200px;
            padding: 20px 15px;
        }
        
        .ks-benefit-icon {
            font-size: 32px;
            height: 50px;
            margin-bottom: 15px;
        }
        
        .ks-benefit-item h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .ks-benefit-item p {
            font-size: 14px;
        }
    }
    
    @media (max-width: 576px) {
        .ks-benefits-column {
            flex-direction: column;
        }
        
        .ks-benefit-item {
            width: 100%;
            min-height: auto;
            padding: 25px 20px;
        }
        
        .ks-benefit-icon {
            margin-bottom: 12px;
        }
        
        .ks-benefit-item:hover {
            transform: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
    }
    
    @media (max-width: 375px) {
        .ks-benefit-item {
            padding: 20px 15px;
        }
        
        .ks-benefit-icon {
            font-size: 28px;
            height: 40px;
        }
        
        .ks-benefit-item h3 {
            font-size: 16px;
        }
        
        .ks-benefit-item p {
            font-size: 13px;
            line-height: 1.4;
        }
    }
</style>

@endpush
<div class="ks-reset ks-body" style="margin-top: 50px;"> 
        <!-- Hero Section -->
        <section class="ks-hero">
        <div class="ks-container">
        <h2 class="ks-hero-title">{{ $product->name ?? '' }}</h2>
            <p class="ks-hero-subtitle">{{ $product_detail["hero-subtitle"] }}</p>
            <button class="ks-btn" id="ksHeroButton">{{ $product_detail["buy-now_second"] }}</button>
        </div>
    </section>
    
        
        <!-- Benefits Section -->
        <section class="ks-benefits-container">
        <div class="ks-benefits-header">
            <h2 class="ks-section-title">{{ $product_detail["features-title"] }}</h2>
            <p class="ks-section-text">{{ $product_detail["features-description"] }}</p>
        </div>
        
        <div class="ks-benefits-content">
            <div class="ks-benefits-column">
            @foreach ($product_detail["benefits"] as $key => $benefitItem)
                @if ($key < 2)
                    <div class="ks-benefit-item">
                        <div class="ks-benefit-icon">{{ $benefitItem["icon"]}}</div>
                        <h3>{{ $benefitItem["title"]}}</h3>
                        <p>{{ $benefitItem["desc"]}}</p>
                    </div>
                @endif
            @endforeach
            </div>
            
            <div class="ks-image-container">
            <x-shop::media.images.lazy 
                    :src="$productBaseImage['medium_image_url']"
                    :alt="$product->name"
                    class="ks-product-image"
                />
            </div>
            
            <div class="ks-benefits-column">
                @foreach ($product_detail["benefits"] as $key => $benefitItem)
                    @if ($key > 1)
                        <div class="ks-benefit-item">
                            <div class="ks-benefit-icon">{{ $benefitItem["icon"]}}</div>
                            <h3>{{ $benefitItem["title"]}}</h3>
                            <p>{{ $benefitItem["desc"]}}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
        
        <!-- Comparison Section -->
        <section class="ks-comparison-container">
          <div class="ks-comparison-left">
          <h2 class="ks-comparison-title">{{ $product_detail["why-choose"] }}</h2>
            <p class="ks-comparison-description">
            {{ $product_detail["why-description"] }}
           </p>
            <button class="ks-btn" id="ksComparisonButton">{{ $product_detail["buy-now"] }}</button>
          </div>
          
          <div class="ks-comparison-right">
            <div class="ks-table-header">
                <div class="ks-table-header-cell"></div>
                <div class="ks-table-header-cell">{{ $product_detail["features-product"] }}</div>
                <div class="ks-table-header-cell">{{ $product_detail["features-other"] }}</div>
            </div>
            <div class="ks-comparison-table">

                @foreach ($product_detail["features"] as $key => $featuresItem)
                  <div class="ks-table-row">
                      <div class="ks-table-feature">{{ $featuresItem["title"] }}</div>
                      <div class="ks-table-value">
                          <span class="ks-check-icon">{{ $featuresItem["icon1"] }}</span>
                      </div>
                      <div class="ks-table-value">
                          <span class="ks-x-icon">{{ $featuresItem["icon2"] }}</span>
                      </div>
                  </div>
                @endforeach
              
            </div>
          </div>
        </section>
        
        <!-- Stats Section -->
        <section class="ks-stats-container">
          <div class="ks-stats-image">
            <x-shop::media.images.lazy 
                    :src="$productBaseImage['large_image_url']"
                    :alt="$product->name"
                    class="ks-product-image"
                />
          </div>
          
          <div class="ks-stats-content">
            <h2 class="ks-stats-title">{{$product_detail["percentages_title"]}}</h2>
        
            <div class="ks-stats-list">


            @foreach ($product_detail["percentages"] as $percentagesItem)
              <div class="ks-stat-item">
                <div class="ks-circular-progress" data-percentage="{{$percentagesItem["oran"]}}">
                  <div class="ks-circle-container">
                    <svg class="ks-circle-progress" width="80" height="80" viewBox="0 0 80 80">
                      <circle class="ks-circle-bg" cx="40" cy="40" r="36" />
                      <circle class="ks-circle-fill" cx="40" cy="40" r="36" stroke-dasharray="226.2" stroke-dashoffset="226.2" />
                    </svg>
                    <div class="ks-percentage">{{$percentagesItem["oran"]}}%</div>
                  </div>
                </div>
                <p class="ks-stat-description">{{$percentagesItem["title"]}}</p>
              </div>
              <div class="ks-stat-divider"></div>
            @endforeach


            </div>
            
            <button class="ks-btn" id="ksStatsButton">{{ $product_detail["buy-now"] }}</button>
          </div>
        </section>
        
        <!-- Second Feature Section -->
        <section class="ks-section">
          <div class="ks-container">
            <div class="ks-flex-wrap">
            <div style="flex: 1 1 300px;">
                <h2 class="ks-section-title">{{ $product_detail["section-title"] }}</h2>
                <p class="ks-section-text">{{ $product_detail["section-desc"] }}</p>
                <button class="ks-btn" id="ksFeatureButton">{{ $product_detail["buy-now"] }}</button>
            </div>
              <div style="flex: 1 1 300px;">
              <x-shop::media.images.lazy 
                    :src="$productBaseImage['large_image_url']"
                    :alt="$product->name"
                    class="ks-product-image"
                />
              </div>
            </div>
          </div>
        </section>
        
        <!-- FAQ Section -->
        <section class="ks-faq-section" > 
          <div class="ks-faq-header">
            <h2 class="ks-faq-title">{{ $product_detail["faq-title"] }}</h2>
            <p class="ks-faq-subtitle">{{ $product_detail["faq-subtitle"] }}</p>
          </div>
          
          <div class="ks-faq-container" >
              @foreach ($product_detail["faqs"] as $faq)
              <div class="ks-faq-item">
                  <div class="ks-faq-question">
                      <h3 class="text-lg font-medium">{{ $faq['question'] }}</h3>
                      <span class="ks-faq-arrow"> 
                          
                          <svg class="ks-faq-arrow" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M7 10l5 5 5-5z"/>
                        </svg>
                      </span>
                  </div>
                  <div class="ks-faq-answer">
                      <p>{{ $faq['answer'] }}</p>
                  </div>
              </div>
              @endforeach
          </div>
          
          <div class="ks-faq-cta" >
            <button  class="ks-btn" id="ksFaqButton">{{ $product_detail["buy-now"] }}</button>
          </div>
        </section>
        
        
    </div>   

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let faqItems = document.querySelectorAll('.ks-faq-item');
    let touchStartY = 0;
    
    faqItems.forEach(function(item) {
        let question = item.querySelector('.ks-faq-question');
        let answer = item.querySelector('.ks-faq-answer');
        
        // Dokunmatik olayları
        question.addEventListener('touchstart', function(e) {
            touchStartY = e.touches[0].clientY;
        }, { passive: true });

        question.addEventListener('touchmove', function(e) {
            e.preventDefault();
        });

        question.addEventListener('click', function(e) {
            e.preventDefault();
            
            let isActive = item.classList.contains('active');
            
            // Diğer tüm FAQ öğelerini kapat
            faqItems.forEach(function(otherItem) {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                    let otherAnswer = otherItem.querySelector('.ks-faq-answer');
                    otherAnswer.style.maxHeight = '0';
                }
            });
            
            // Tıklanan öğeyi aç/kapat
            item.classList.toggle('active');
            
            if (!isActive) {
                answer.style.maxHeight = answer.scrollHeight + 'px';
            } else {
                answer.style.maxHeight = '0';
            }
        });
    });

    // Sayfa yüklendiğinde smooth scroll için
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });



    const circles = document.querySelectorAll('.ks-circular-progress');
    
    circles.forEach(circle => {
        const percentage = circle.getAttribute('data-percentage');
        const circleFill = circle.querySelector('.ks-circle-fill');
        const circumference = 2 * Math.PI * 36; // r=36 olan daire için çevre uzunluğu
        
        // Başlangıçta gizli
        circleFill.style.strokeDasharray = circumference;
        circleFill.style.strokeDashoffset = circumference;
        
        // IntersectionObserver ile görünür olduğunda animasyon başlat
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Yüzdeye göre stroke-dashoffset hesapla
                    const offset = circumference - (percentage / 100 * circumference);
                    circleFill.style.strokeDashoffset = offset;
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(circle);
    });
});
</script>
@endpush