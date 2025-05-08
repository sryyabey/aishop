<style>
.sticky-cart-animate {
    position: fixed;
    bottom: -100px;
    left: 0;
    right: 0;
    background-color: rgba(255, 255, 255, 0.98);
    padding: 12px 20px;
    z-index: 9999;
    box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.08);
    backdrop-filter: blur(8px);
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    animation: slideUp 0.5s forwards ease-in-out;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
}

.sticky-cart-animate .product-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.sticky-cart-animate .product-image {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    object-fit: cover;
}

.sticky-cart-animate .product-details {
    flex: 1;
}

.sticky-cart-animate .product-name {
    font-size: 14px;
    font-weight: 500;
    color: #222;
    margin-bottom: 2px;
}

.sticky-cart-animate .product-price {
    font-size: 13px;
    color: #FF6B6B;
    font-weight: 600;
}

.sticky-cart-animate button {
    background: linear-gradient(45deg, #FF6B6B, #FF8E53);
    color: white;
    padding: 12px 24px;
    font-size: 15px;
    font-weight: 500;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.2);
}

.sticky-cart-animate button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.25);
}

.sticky-cart-animate button:active {
    transform: translateY(0);
}

@keyframes slideUp {
    from {
        bottom: -100px;
        opacity: 0;
    }
    to {
        bottom: 0;
        opacity: 1;
    }
}

@media (min-width: 768px) {
    .sticky-cart-animate {
        display: none;
    }
}
</style>
<style>
/* Buton Tasarımı */
.sticky-cart-button {
    @apply w-full px-6 py-3 text-sm font-medium text-white 
           bg-gradient-to-r from-indigo-600 to-purple-600
           hover:from-indigo-700 hover:to-purple-700
           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
           disabled:opacity-50 disabled:cursor-not-allowed
           rounded-xl shadow-lg hover:shadow-xl
           transition-all duration-300 ease-in-out
           transform hover:-translate-y-0.5 active:translate-y-0;

    min-width: 120px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    float:right;
}

.sticky-cart-button:disabled {
    @apply opacity-50 cursor-not-allowed;
}
@media (max-width: 768px) {
    .sticky-cart-button {
        padding: 10px 16px;
        font-size: 14px;
    }
}
/* Loading Durumu için Animasyon */
.loading-spin {
    @apply inline-block w-4 h-4 mr-2 
           border-2 border-white border-t-transparent 
           rounded-full animate-spin;
}

</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stickyCart = document.querySelector('.sticky-cart-animate');
        stickyCart.style.display = 'none';

        window.addEventListener('scroll', function () {
            if (window.scrollY > 300) {
                stickyCart.style.display = 'block';
            } else {
                stickyCart.style.display = 'none'; 
            }
        });
    });
</script>

<!--<div class="sticky-cart-animate block md:hidden" v-scope>
    
    <div class="sticky-cart-button-container ml-auto" style="width: 100%;">
        <div class="product-info flex-1">
            <img 
                src="{{ $productBaseImage['medium_image_url'] }}" 
                alt="{{ $product->name }}"
                class="product-image"
            >
            <div class="product-details">
                <div class="product-name line-clamp-1">{{ $product->name }}</div>
                <div class="product-price">{!! $product->getTypeInstance()->getPriceHtml() !!}</div>
            </div>
        </div>
        <form
            method="POST" 
            action="{{ route('shop.api.checkout.cart.store') }}"
            @submit.prevent="onSubmit($event)"
            >
                @csrf
                
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="is_buy_now" :value="is_buy_now">

                <button 
                    type="submit"
                    class="secondary-button w-full max-w-full max-md:py-3 max-sm:rounded-lg max-sm:py-1.5"
                    :disabled="isStoring.addToCart || ! {{ $product->isSaleable(1) ? 'true' : 'false' }}"
                    button-type="secondary-button"
                    :loading="false"
                    :title="trans('shop::app.products.view.add-to-cart')"
                    :disabled="! $product->isSaleable(1)"
                    ::loading="isStoring.addToCart"
                    ::disabled="isStoring.addToCart"
                    @click="is_buy_now=0;"
                >
                    <span 
                        class="loading-spin"
                        v-show="isStoring.addToCart"
                    ></span>
                    <span class="icon-cart text-lg mr-2"></span>
                    @lang('shop::app.products.view.add-to-cart')
                </button>
            </form>
    </div>
</div>-->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stickyCart = document.querySelector('.sticky-cart-animate');
        
        if (stickyCart) {
            stickyCart.style.display = 'none';
            
            let isAddingToCart = false;
            
            // Add click event to form submit
            const form = stickyCart.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    if (isAddingToCart) return;
                    isAddingToCart = true;
                    
                    const button = form.querySelector('button');
                    const loadingSpin = form.querySelector('.loading-spin');
                    
                    if (loadingSpin) loadingSpin.style.display = 'inline-block';
                    if (button) button.disabled = true;
                    
                    // Create form data and submit
                    const formData = new FormData(form);
                    
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update mini cart (trigger event)
                        if (typeof app !== 'undefined') {
                            app.config.globalProperties.$emitter.emit('update-mini-cart', data.data);
                            app.config.globalProperties.$emitter.emit('add-flash', { 
                                type: 'success', 
                                message: data.message || 'Product added to cart' 
                            });
                        }
                        
                        isAddingToCart = false;
                        if (loadingSpin) loadingSpin.style.display = 'none';
                        if (button) button.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error adding to cart:', error);
                        isAddingToCart = false;
                        if (loadingSpin) loadingSpin.style.display = 'none';
                        if (button) button.disabled = false;
                        
                        if (typeof app !== 'undefined') {
                            app.config.globalProperties.$emitter.emit('add-flash', { 
                                type: 'error', 
                                message: 'Error adding product to cart'
                            });
                        }
                    });
                });
            }

            window.addEventListener('scroll', function () {
                if (window.scrollY > 300) {
                    stickyCart.style.display = 'flex';
                } else {
                    stickyCart.style.display = 'none'; 
                }
            });
        }
    });
</script>