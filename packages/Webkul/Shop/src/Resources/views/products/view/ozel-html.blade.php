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
            background: linear-gradient(135deg, #f2e2ce 0%, #ffffff 100%);
            padding: 60px 20px;
            text-align: center;
          }
          
          .ks-hero-title {
            font-size: 36px;
            color: #8B4513;
            margin-bottom: 20px;
          }
          
          .ks-hero-subtitle {
            font-size: 18px;
            max-width: 800px;
            margin: 0 auto 30px;
          }
          
          .ks-btn {
            display: inline-block;
            background-color: #8B4513;
            color: white;
            padding: 12px 30px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            font-size: 16px;
          }
          
          .ks-btn:hover {
            background-color: #5E2F0D;
            transform: translateY(-2px);
          }
          
          /* Benefits section */
          .ks-benefits-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            text-align: center;
          }
          
          .ks-benefits-header {
            margin-bottom: 50px;
          }
          
          .ks-benefits-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 20px;
          }
          
          .ks-benefits-column {
            display: flex;
            flex-direction: column;
            gap: 30px;
            width: 25%;
          }
          
          .ks-benefit-item {
            text-align: center;
          }
          
          .ks-benefit-icon {
            margin-bottom: 15px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
          }
          
          .ks-benefit-item h3 {
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: bold;
          }
          
          .ks-benefit-item p {
            font-size: 16px;
            line-height: 1.4;
          }
          
          .ks-image-container {
            width: 40%;
            padding: 0 20px;
          }
          
          .ks-product-image {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
          }
          
          /* Comparison section */
          .ks-comparison-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
          }
          
          .ks-comparison-left {
            flex: 1;
            min-width: 300px;
          }
          
          .ks-comparison-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #8B4513;
          }
          
          .ks-comparison-description {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
          }
          
          .ks-comparison-right {
            flex: 1;
            min-width: 350px;
          }
          
          .ks-comparison-table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: white;
          }
          
          .ks-table-row {
            display: flex;
          }
          
          .ks-table-header {
            display: flex;
            border: none;
          }
          
          .ks-table-header-cell {
            flex: 1;
            padding: 15px;
            font-weight: 600;
            text-align: center;
          }
          
          .ks-table-feature {
            flex: 1;
            padding: 15px;
            background-color: #5c666f;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-weight: 500;
          }
          
          .ks-table-value {
            flex: 1;
            padding: 15px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
          }
          
          .ks-check-icon {
            color: #27ae60;
            font-size: 24px;
            font-weight: bold;
          }
          
          .ks-x-icon {
            color: black;
            font-size: 24px;
            font-weight: bold;
          }
          
          /* Stats section */
          .ks-stats-container {
            display: flex;
            max-width: 1200px;
            margin: 60px auto;
            gap: 40px;
            padding: 0 20px;
          }
          
          .ks-stats-image {
            flex: 1;
            min-width: 300px;
          }
          
          .ks-stats-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
          }
          
          .ks-stats-content {
            flex: 1;
            min-width: 300px;
            display: flex;
            flex-direction: column;
          }
          
          .ks-stats-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 40px;
            color: #8B4513;
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
            gap: 20px;
          }
          
          .ks-circular-progress {
            position: relative;
            width: 80px;
            height: 80px;
          }
          
          .ks-circle-container {
            position: relative;
            width: 80px;
            height: 80px;
          }
          
          .ks-circle-bg {
            fill: none;
            stroke: #e6e6e6;
            stroke-width: 4;
          }
          
          .ks-circle-fill {
            fill: none;
            stroke: #8B4513;
            stroke-width: 4;
            stroke-linecap: round;
            transform: rotate(-90deg);
            transform-origin: center;
            transition: stroke-dashoffset 1s ease-in-out;
          }
          
          .ks-percentage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18px;
            font-weight: 700;
          }
          
          .ks-stat-description {
            flex: 1;
            font-size: 16px;
            line-height: 1.5;
            margin: 0;
          }
          
          .ks-stat-divider {
            height: 1px;
            background-color: #e5e5e5;
            margin: 15px 0;
          }
          
          /* FAQ section */
          .ks-faq-section {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 20px;
          }
          
          .ks-faq-header {
            text-align: center;
            margin-bottom: 40px;
          }
          
          .ks-faq-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #8B4513;
          }
          
          .ks-faq-subtitle {
            font-size: 18px;
            max-width: 700px;
            margin: 0 auto;
          }
          
          .ks-faq-container {
            margin: 0 auto;
            max-width: 800px;
          }
          
          .ks-faq-item {
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            margin-bottom: 16px;
            overflow: hidden;
          }
          
          .ks-faq-question {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            background: #fff;
            transition: background-color 0.3s;
          }
          
          .ks-faq-question:hover {
            background-color: #f9f9f9;
          }
          
          .ks-faq-question h3 {
            font-size: 18px;
            margin: 0;
          }
          
          .ks-faq-arrow {
            transition: transform 0.3s;
          }
          
          .ks-faq-answer {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
          }
          
          .ks-faq-answer p {
            margin: 0;
            padding: 0 0 20px;
            font-size: 16px;
            line-height: 1.6;
          }
          
          .ks-faq-cta {
            text-align: center;
            margin-top: 40px;
          }
          
          /* Footer */
          .ks-footer {
            background-color: #8B4513;
            color: white;
            padding: 40px 20px;
            text-align: center;
          }
          
          /* Responsive */
          @media (max-width: 768px) {
            .ks-flex-wrap {
              flex-direction: column;
            }
            
            .ks-benefits-column {
              width: 100%;
              flex-direction: row;
              justify-content: center;
              gap: 20px;
            }
            
            .ks-benefit-item {
              width: 45%;
            }
            
            .ks-image-container {
              width: 80%;
              order: 1;
              margin: 30px 0;
            }
            
            .ks-benefits-column:first-of-type {
              order: 0;
            }
            
            .ks-benefits-column:last-of-type {
              order: 2;
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
            
            .ks-comparison-title,
            .ks-stats-title,
            .ks-faq-title {
              font-size: 28px;
            }
          }
          
          @media (max-width: 480px) {
            .ks-benefits-column {
              flex-direction: column;
            }
            
            .ks-benefit-item {
              width: 100%;
            }
            
            .ks-section-title {
              font-size: 26px;
            }
          }
        </style>
        <style>
    .ks-hero {
        background: linear-gradient(45deg, #1a1a2e, #16213e);
        color: white;
    }

    .ks-benefit-icon {
        font-size: 2.5rem;
        background: linear-gradient(135deg, #00f2fe, #4facfe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
@endpush
<div class="ks-reset ks-body"> 
        <!-- Hero Section -->
        <section class="ks-hero">
        <div class="ks-container">
        <h1 class="ks-hero-title">{{ $product->name ?? 'Starlink Gökyüzü Projeksiyon Gece Lambası' }}</h1>
            <p class="ks-hero-subtitle">Hayal gücünüzü gökyüzüne taşıyan benzersiz bir gece lambası! Odanızı adeta bir galaksiye dönüştürerek sizi bambaşka bir atmosferle buluşturur.</p>
            <button class="ks-btn" id="ksHeroButton">Hemen Keşfet</button>
        </div>
    </section>
    
        
        <!-- Benefits Section -->
        <section class="ks-benefits-container">
        <div class="ks-benefits-header">
            <h2 class="ks-section-title">Büyüleyici Özellikler</h2>
            <p class="ks-section-text">Ayarlanabilir ışık modları ve yıldız projeksiyon efektleri sayesinde ister dinlenirken ister meditasyon yaparken size huzurlu bir ortam sunar.</p>
        </div>
        
        <div class="ks-benefits-content">
            <div class="ks-benefits-column">
                <div class="ks-benefit-item">
                    <div class="ks-benefit-icon">🌟</div>
                    <h3>360° Projeksiyon</h3>
                    <p>Tam dönebilen gökyüzü yansıtma özelliği</p>
                </div>
                
                <div class="ks-benefit-item">
                    <div class="ks-benefit-icon">🌙</div>
                    <h3>Galaksi Efektleri</h3>
                    <p>Ay, yıldızlar ve galaksi efekti bir arada</p>
                </div>
            </div>
            
            <div class="ks-image-container">
            <x-shop::media.images.lazy 
                    :src="$productBaseImage['medium_image_url']"
                    :alt="$product->name"
                    class="ks-product-image"
                />
            </div>
            
            <div class="ks-benefits-column">
                <div class="ks-benefit-item">
                    <div class="ks-benefit-icon">🤫</div>
                    <h3>Sessiz Çalışma</h3>
                    <p>Sessiz motor yapısıyla kesintisiz projeksiyon</p>
                </div>
                
                <div class="ks-benefit-item">
                    <div class="ks-benefit-icon">👆</div>
                    <h3>Kolay Kullanım</h3>
                    <p>Dokunmatik kontrol paneli</p>
                </div>
            </div>
        </div>
    </section>
        
        <!-- Comparison Section -->
        <section class="ks-comparison-container">
          <div class="ks-comparison-left">
          <h2 class="ks-comparison-title">Neden Starlink Gece Lambası?</h2>
            <p class="ks-comparison-description">
                Göz yormayan yumuşak ışıklar ve sessiz çalışma özelliğiyle, gece konforunuz için tasarlandı.
            </p>
            <button class="ks-btn" id="ksComparisonButton">Şimdi Satın Al</button>
          </div>
          
          <div class="ks-comparison-right">
            <div class="ks-table-header">
                <div class="ks-table-header-cell"></div>
                <div class="ks-table-header-cell">Starlink Lamba</div>
                <div class="ks-table-header-cell">Diğer Lambalar</div>
            </div>
            <div class="ks-comparison-table">
    <div class="ks-table-row">
        <div class="ks-table-feature">360° Projeksiyon</div>
        <div class="ks-table-value">
            <span class="ks-check-icon">✓</span>
        </div>
        <div class="ks-table-value">
            <span class="ks-x-icon">✕</span>
        </div>
    </div>
              
    <div class="ks-table-row">
        <div class="ks-table-feature">LED Teknolojisi</div>
        <div class="ks-table-value">
            <span class="ks-check-icon">✓</span>
        </div>
        <div class="ks-table-value">
            <span class="ks-x-icon">✕</span>
        </div>
    </div>
              
    <div class="ks-table-row">
        <div class="ks-table-feature">Sessiz Çalışma</div>
        <div class="ks-table-value">
            <span class="ks-check-icon">✓</span>
        </div>
        <div class="ks-table-value">
            <span class="ks-x-icon">✕</span>
        </div>
    </div>
              
    <div class="ks-table-row">
        <div class="ks-table-feature">Uzun Pil Ömrü</div>
        <div class="ks-table-value">
            <span class="ks-check-icon">✓</span>
        </div>
        <div class="ks-table-value">
            <span class="ks-x-icon">✕</span>
        </div>
    </div>
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
            <h2 class="ks-stats-title">Kullanıcı Deneyimleri</h2>
        
            <div class="ks-stats-list">
              <div class="ks-stat-item">
                <div class="ks-circular-progress" data-percentage="97">
                  <div class="ks-circle-container">
                    <svg class="ks-circle-progress" width="80" height="80" viewBox="0 0 80 80">
                      <circle class="ks-circle-bg" cx="40" cy="40" r="36" />
                      <circle class="ks-circle-fill" cx="40" cy="40" r="36" stroke-dasharray="226.2" stroke-dashoffset="226.2" />
                    </svg>
                    <div class="ks-percentage">97%</div>
                  </div>
                </div>
                <p class="ks-stat-description">Uyku kalitesinde artış yaşadı</p>
              </div>
              <div class="ks-stat-divider"></div>
              
              <div class="ks-stat-item">
                <div class="ks-circular-progress" data-percentage="96">
                  <div class="ks-circle-container">
                    <svg class="ks-circle-progress" width="80" height="80" viewBox="0 0 80 80">
                      <circle class="ks-circle-bg" cx="40" cy="40" r="36" />
                      <circle class="ks-circle-fill" cx="40" cy="40" r="36" stroke-dasharray="226.2" stroke-dashoffset="226.2" />
                    </svg>
                    <div class="ks-percentage">96%</div>
                  </div>
                </div>
                <p class="ks-stat-description">Rahatlatıcı etkisinden memnun kaldı</p>
                </div>
              <div class="ks-stat-divider"></div>
              
              <div class="ks-stat-item">
                <div class="ks-circular-progress" data-percentage="98">
                  <div class="ks-circle-container">
                    <svg class="ks-circle-progress" width="80" height="80" viewBox="0 0 80 80">
                      <circle class="ks-circle-bg" cx="40" cy="40" r="36" />
                      <circle class="ks-circle-fill" cx="40" cy="40" r="36" stroke-dasharray="226.2" stroke-dashoffset="226.2" />
                    </svg>
                    <div class="ks-percentage">98%</div>
                  </div>
                </div>
                <p class="ks-stat-description">Tekrar satın almayı düşünüyor</p>
                </div>
            </div>
            
            <button class="ks-btn" id="ksStatsButton">Şimdi Satın Al</button>
          </div>
        </section>
        
        <!-- Second Feature Section -->
        <section class="ks-section">
          <div class="ks-container">
            <div class="ks-flex-wrap">
            <div style="flex: 1 1 300px;">
                <h2 class="ks-section-title">Keyifli Geceler İçin Tasarlandı</h2>
                <p class="ks-section-text">Starlink Gece Lambası, yumuşak ışığı ve göz alıcı efektleriyle yatak odanızı huzurlu bir atmosfere dönüştürür. USB şarj özelliği ve kolay kullanımı ile her yaştan kullanıcı için ideal.</p>
                <button class="ks-btn" id="ksFeatureButton">Hemen Satın Al</button>
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
        <section class="ks-faq-section">
          <div class="ks-faq-header">
            <h2 class="ks-faq-title">Sık Sorulan Sorular</h2>
            <p class="ks-faq-subtitle">Hakkında Bilmek İstedikleriniz</p>
          </div>
          
          <div class="ks-faq-container">
            
          <div class="ks-faq-item">
        <div class="ks-faq-question">
            <h3>Pil ömrü ne kadar?</h3>
            <svg class="ks-faq-arrow" width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor" d="M7 10l5 5 5-5z"/>
            </svg>
        </div>
        <div class="ks-faq-answer">
            <p>Tam şarjla 8 saate kadar kesintisiz kullanım sağlar.</p>
        </div>
    </div>
            
    <div class="ks-faq-item">
        <div class="ks-faq-question">
            <h3>Işık ayarları nasıl yapılır?</h3>
            <svg class="ks-faq-arrow" width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor" d="M7 10l5 5 5-5z"/>
            </svg>
        </div>
        <div class="ks-faq-answer">
            <p>Dokunmatik kontrol paneli üzerinden 7 farklı renk ve 3 farklı parlaklık seviyesi ayarlanabilir.</p>
        </div>
    </div>
            
    <div class="ks-faq-item">
        <div class="ks-faq-question">
            <h3>Garanti süresi nedir?</h3>
            <svg class="ks-faq-arrow" width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor" d="M7 10l5 5 5-5z"/>
            </svg>
        </div>
        <div class="ks-faq-answer">
            <p>2 yıl resmi distribütör garantisi mevcuttur.</p>
        </div>
    </div>
            


          </div>
          
          <div class="ks-faq-cta">
            <button class="ks-btn" id="ksFaqButton">Şimdi Satın Al</button>
          </div>
        </section>
        
        
        </div>   


        <script>
          document.addEventListener('DOMContentLoaded', function() {
            // Handle all buy buttons
            const ksBuyButtons = document.querySelectorAll('.ks-btn');
            ksBuyButtons.forEach(function(button) {
              button.addEventListener('click', function() {
                // In a real Bagisto implementation, you would add to cart here
                // This is just a placeholder
                alert('Ürün sepete ekleniyor...');
                // For Bagisto integration:
                // window.location.href = '/cart/add?id=' + productId + '&quantity=1';
              });
            });
            
            // Animate stats circles
            const ksCircles = document.querySelectorAll('.ks-circular-progress');
            
            ksCircles.forEach(function(circle) {
              const percentage = parseInt(circle.getAttribute('data-percentage'));
              const circleFill = circle.querySelector('.ks-circle-fill');
              const circumference = 2 * Math.PI * 36; // r = 36
              
              // Calculate the dash offset
              const dashOffset = circumference - (percentage / 100) * circumference;
              
              // Initial state (for animation)
              circleFill.style.strokeDasharray = circumference;
              circleFill.style.strokeDashoffset = circumference;
              
              // Animate after a small delay
              setTimeout(() => {
                circleFill.style.transition = 'stroke-dashoffset 1.5s ease-in-out';
                circleFill.style.strokeDashoffset = dashOffset;
              }, 300);
            });
            
            // FAQ Accordion
            const ksFaqQuestions = document.querySelectorAll('.ks-faq-question');
            
            ksFaqQuestions.forEach(function(question) {
              question.addEventListener('click', function() {
                const item = question.parentNode;
                const answer = question.nextElementSibling;
                const arrow = question.querySelector('.ks-faq-arrow');
                
                // Toggle active class
                item.classList.toggle('active');
                
                // Close all other FAQs
                document.querySelectorAll('.ks-faq-item').forEach(function(otherItem) {
                  if (otherItem !== item) {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.ks-faq-answer').style.maxHeight = null;
                    otherItem.querySelector('.ks-faq-answer').style.padding = '0 20px';
                    otherItem.querySelector('.ks-faq-arrow').style.transform = 'rotate(0deg)';
                  }
                });
                
                // Toggle the clicked one
                if (item.classList.contains('active')) {
                  answer.style.maxHeight = answer.scrollHeight + 40 + 'px';
                  answer.style.padding = '20px';
                  arrow.style.transform = 'rotate(180deg)';
                } else {
                  answer.style.maxHeight = null;
                  answer.style.padding = '0 20px';
                  arrow.style.transform = 'rotate(0deg)';
                }
              });
            });
          });
        </script> 