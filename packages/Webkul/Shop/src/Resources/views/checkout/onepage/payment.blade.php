{!! view_render_event('bagisto.shop.checkout.onepage.payment_methods.before') !!}

<v-payment-methods
    :methods="paymentMethods"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <x-shop::shimmer.checkout.onepage.payment-method />
</v-payment-methods>

{!! view_render_event('bagisto.shop.checkout.onepage.payment_methods.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-payment-methods-template"
    >
        <div class="mb-7 max-md:last:!mb-0">
            <template v-if="! methods">
                <!-- Payment Method shimmer Effect -->
                <x-shop::shimmer.checkout.onepage.payment-method />
            </template>
    
            <template v-else>
                {!! view_render_event('bagisto.shop.checkout.onepage.payment_method.accordion.before') !!}

                <!-- Accordion Blade Component -->
                <x-shop::accordion class="overflow-hidden !border-b-0 max-md:rounded-lg max-md:!border-none max-md:!bg-gray-100">
                    <!-- Accordion Blade Component Header -->
                    <x-slot:header class="px-0 py-4 max-md:p-3 max-md:text-sm max-md:font-medium max-sm:p-2">
                        
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-medium max-md:text-base">
                                @lang('shop::app.checkout.onepage.payment.payment-method')
                            </h2>
                        </div>
                    </x-slot>
    
                    <!-- Accordion Blade Component Content -->
                    <x-slot:content class="mt-8 !p-0 max-md:mt-0 max-md:rounded-t-none max-md:border max-md:border-t-0 max-md:!p-4">
                        <div class="flex flex-wrap gap-7 max-md:gap-4 max-sm:gap-2.5">
                            <div 
                                class="relative cursor-pointer max-md:max-w-full max-md:flex-auto"
                                v-for="(payment, index) in methods"
                            >
                                {!! view_render_event('bagisto.shop.checkout.payment-method.before') !!}

                                <input 
                                    type="radio" 
                                    name="payment[method]" 
                                    :value="payment.payment"
                                    :id="payment.method"
                                    class="peer hidden"
                                    @change="store(payment)"
                                >
    
                                <label 
                                    :for="payment.method" 
                                    class="icon-radio-unselect peer-checked:icon-radio-select absolute top-5 cursor-pointer text-2xl text-navyBlue ltr:right-5 rtl:left-5"
                                >
                                </label>

                                <label 
                                    :for="payment.method" 
                                    class="block w-[190px] cursor-pointer rounded-xl border border-zinc-200 p-5 max-md:flex max-md:w-full max-md:gap-5 max-md:rounded-lg max-sm:gap-4 max-sm:px-4 max-sm:py-2.5"
                                >
                                    {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.image.before') !!}

                                    <img
                                        class="max-h-11 max-w-14"
                                        :src="payment.image"
                                        width="55"
                                        height="55"
                                        :alt="payment.method_title"
                                        :title="payment.method_title"
                                    />

                                    {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.image.after') !!}

                                    <div>
                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.title.before') !!}

                                        <p class="mt-1.5 text-sm font-semibold max-md:mt-1 max-sm:mt-0">
                                            @{{ payment.method_title }}
                                        </p>
                                        
                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.title.after') !!}

                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.description.before') !!}

                                        <p class="mt-2.5 text-xs font-medium text-zinc-500 max-md:mt-1 max-sm:mt-0">
                                            @{{ payment.description }}
                                        </p> 

                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.description.after') !!}
    
                                    </div>
                                </label>

                                {!! view_render_event('bagisto.shop.checkout.payment-method.after') !!}

                                <!-- Todo implement the additionalDetails -->
                                {{-- \Webkul\Payment\Payment::getAdditionalDetails($payment['method'] --}}
                            </div>
                        </div>
                    </x-slot>
                </x-shop::accordion>

                {!! view_render_event('bagisto.shop.checkout.onepage.payment_method.accordion.after') !!}
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-payment-methods', {
            template: '#v-payment-methods-template',

            props: {
                methods: {
                    type: Object,
                    required: true,
                    default: () => null,
                },
            },

            emits: ['processing', 'processed'],

            methods: {
                store(selectedMethod) {
                    this.$emit('processing', 'review');

                    this.$axios.post("{{ route('shop.checkout.onepage.payment_methods.store') }}", {
                            payment: selectedMethod
                        })
                        .then(response => {
                            this.$emit('processed', response.data.cart);

                            // Used in mobile view. 
                            if (window.innerWidth <= 768) {
                                window.scrollTo({
                                    top: document.body.scrollHeight,
                                    behavior: 'smooth'
                                });
                            }
                        })
                        .catch(error => {
                            this.$emit('processing', 'payment');

                            if (error.response.data.redirect_url) {
                                window.location.href = error.response.data.redirect_url;
                            }
                        });
                },
            },
        });
    </script>
    <style>
        .payment-methods-area,
.flex.flex-wrap.gap-7,
.flex.flex-wrap.max-md\:gap-4.max-sm\:gap-2\.5 {
    background: linear-gradient(90deg, #fbeee6 0%, #ffe0b2 100%);
    border: 2.5px solid #ff9800;
    border-radius: 18px;
    padding: 24px 12px;
    box-shadow: 0 2px 12px 0 rgba(255,183,77,0.10);
    margin-bottom: 18px;
}
.payment-methods-area label.block,
.flex.flex-wrap.gap-7 label.block,
.flex.flex-wrap.max-md\:gap-4.max-sm\:gap-2\.5 label.block {
    background: #fffbe7;
    border: 2px solid #ffb74d !important;
    box-shadow: 0 2px 8px 0 rgba(255,183,77,0.08);
    font-weight: bold;
    transition: box-shadow 0.2s, border 0.2s;
}
.payment-methods-area label.block:hover,
.payment-methods-area label.block:focus,
.flex.flex-wrap.gap-7 label.block:hover,
.flex.flex-wrap.gap-7 label.block:focus,
.flex.flex-wrap.max-md\:gap-4.max-sm\:gap-2\.5 label.block:hover,
.flex.flex-wrap.max-md\:gap-4.max-sm\:gap-2\.5 label.block:focus {
    border-color: #ff6f00 !important;
    box-shadow: 0 8px 32px 0 rgba(255,152,0,0.18);
    background: #fff3e0;
}
/* Uyarı popup'ı */
.payment-warning-popup {
    position: relative;
    margin-bottom: 16px;
    background: linear-gradient(90deg, #ffb74d 60%, #ff6b6b 100%);
    color: #fff;
    padding: 14px 28px;
    border-radius: 12px;
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    box-shadow: 0 4px 24px 0 rgba(255,107,107,0.12);
    animation: popup-fadein 0.4s;
}
@keyframes popup-fadein {
    from { opacity: 0; transform: translateY(-20px);}
    to { opacity: 1; transform: translateY(0);}
}
    </style> 
@endPushOnce
