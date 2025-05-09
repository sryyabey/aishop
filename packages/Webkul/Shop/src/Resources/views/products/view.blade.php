@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')
@inject ('productViewHelper', 'Webkul\Product\Helpers\View')

@php
    $avgRatings = $reviewHelper->getAverageRating($product);

    $percentageRatings = $reviewHelper->getPercentageRating($product);

    $customAttributeValues = $productViewHelper->getAdditionalData($product);

    $attributeData = collect($customAttributeValues)->filter(fn ($item) => ! empty($item['value']));
@endphp

<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="{{ trim($product->meta_description) != "" ? $product->meta_description : \Illuminate\Support\Str::limit(strip_tags($product->description), 120, '') }}"/>

    <meta name="keywords" content="{{ $product->meta_keywords }}"/>

    @if (core()->getConfigData('catalog.rich_snippets.products.enable'))
        <script type="application/ld+json">
            {!! app('Webkul\Product\Helpers\SEO')->getProductJsonLd($product) !!}
        </script>
    @endif

    <?php $productBaseImage = product_image()->getProductBaseImage($product); ?>

    <meta name="twitter:card" content="summary_large_image" />

    <meta name="twitter:title" content="{{ $product->name }}" />

    <meta name="twitter:description" content="{!! htmlspecialchars(trim(strip_tags($product->description))) !!}" />

    <meta name="twitter:image:alt" content="" />

    <meta name="twitter:image" content="{{ $productBaseImage['medium_image_url'] }}" />

    <meta property="og:type" content="og:product" />

    <meta property="og:title" content="{{ $product->name }}" />

    <meta property="og:image" content="{{ $productBaseImage['medium_image_url'] }}" />

    <meta property="og:description" content="{!! htmlspecialchars(trim(strip_tags($product->description))) !!}" />

    <meta property="og:url" content="{{ route('shop.product_or_category.index', $product->url_key) }}" />
@endPush


@include('shop::home.header-ticker', [])   

@include('shop::products.view.sticky-bottom-cart', [])  
<!-- Page Layout -->
<x-shop::layouts>
    <!-- Page Title -->
    
    <x-slot:title>
        {{ trim($product->meta_title) != "" ? $product->meta_title : $product->name }}
    </x-slot>

    {!! view_render_event('bagisto.shop.products.view.before', ['product' => $product]) !!}

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        <div class="flex justify-center px-7 max-lg:hidden">
            <x-shop::breadcrumbs
                name="product"
                :entity="$product"
            />
        </div>
    @endif

    <!-- Product Information Vue Component -->
    <v-product>
        <x-shop::shimmer.products.view />
    </v-product>

    <!-- Information Section -->
    <div class="1180:mt-20">
        <div class="max-1180:hidden">
            <x-shop::tabs
                position="center"
                ref="productTabs"
            >
                <!-- Description Tab -->
                {!! view_render_event('bagisto.shop.products.view.description.before', ['product' => $product]) !!}

                <x-shop::tabs.item
                    id="descritpion-tab"
                    class="container mt-[60px] !p-0"
                    :title="trans('shop::app.products.view.description')"
                    :is-selected="true"
                >
                    <div class="container mt-[60px] max-1180:px-5">
                        <p class="text-lg text-zinc-500 max-1180:text-sm">
                            {!! $product->description !!}
                        </p>
                    </div>
                </x-shop::tabs.item>

                {!! view_render_event('bagisto.shop.products.view.description.after', ['product' => $product]) !!}

                <!-- Additional Information Tab -->
                @if(count($attributeData))
                    <x-shop::tabs.item
                        id="information-tab"
                        class="container mt-[60px] !p-0"
                        :title="trans('shop::app.products.view.additional-information')"
                        :is-selected="false"
                    >
                        <div class="container mt-[60px] max-1180:px-5">
                            <div class="mt-8 grid max-w-max grid-cols-[auto_1fr] gap-4">
                                @foreach ($customAttributeValues as $customAttributeValue)
                                    @if (! empty($customAttributeValue['value']))
                                        <div class="grid">
                                            <p class="text-base text-black">
                                                {!! $customAttributeValue['label'] !!}
                                            </p>
                                        </div>

                                        @if ($customAttributeValue['type'] == 'file')
                                            <a
                                                href="{{ Storage::url($product[$customAttributeValue['code']]) }}"
                                                download="{{ $customAttributeValue['label'] }}"
                                            >
                                                <span class="icon-download text-2xl"></span>
                                            </a>
                                        @elseif ($customAttributeValue['type'] == 'image')
                                            <a
                                                href="{{ Storage::url($product[$customAttributeValue['code']]) }}"
                                                download="{{ $customAttributeValue['label'] }}"
                                            >
                                                <img
                                                    class="h-5 min-h-5 w-5 min-w-5"
                                                    src="{{ Storage::url($customAttributeValue['value']) }}"
                                                />
                                            </a>
                                        @else
                                            <div class="grid">
                                                <p class="text-base text-zinc-500">
                                                    {!! $customAttributeValue['value'] !!}
                                                </p>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </x-shop::tabs.item>
                @endif

                <!-- Reviews Tab -->
                <x-shop::tabs.item
                    id="review-tab"
                    class="container mt-[60px] !p-0"
                    :title="trans('shop::app.products.view.review')"
                    :is-selected="false"
                >
                    @include('shop::products.view.reviews')
                </x-shop::tabs.item>
            </x-shop::tabs>


        </div>

        
    </div>

    <!-- Information Section -->
    <div class="container mt-6 grid gap-3 !p-0 max-1180:px-5 1180:hidden">
        <!-- Description Accordion -->
        <x-shop::accordion
            class="max-md:border-none"
            :is-active="true"
        >
            <x-slot:header class="bg-gray-100 max-md:!py-3 max-sm:!py-2">
                <p class="text-base font-medium 1180:hidden">
                    @lang('shop::app.products.view.description')
                </p>
            </x-slot>

            <x-slot:content class="max-sm:px-0">
                <div class="mb-5 text-lg text-zinc-500 max-1180:text-sm max-md:mb-1 max-md:px-4">
                    {!! $product->description !!}
                </div>
            </x-slot>
        </x-shop::accordion>

        <!-- Additional Information Accordion -->
        @if (count($attributeData))
            <x-shop::accordion
                class="max-md:border-none"
                :is-active="false"
            >
                <x-slot:header class="bg-gray-100 max-md:!py-3 max-sm:!py-2">
                    <p class="text-base font-medium 1180:hidden">
                        @lang('shop::app.products.view.additional-information')
                    </p>
                </x-slot>

                <x-slot:content class="max-sm:px-0">
                    <div class="container max-1180:px-5">
                        <div class="grid max-w-max grid-cols-[auto_1fr] gap-4 text-lg text-zinc-500 max-1180:text-sm">
                            @foreach ($customAttributeValues as $customAttributeValue)
                                @if (! empty($customAttributeValue['value']))
                                    <div class="grid">
                                        <p class="text-base text-black">
                                            {{ $customAttributeValue['label'] }}
                                        </p>
                                    </div>

                                    @if ($customAttributeValue['type'] == 'file')
                                        <a
                                            href="{{ Storage::url($product[$customAttributeValue['code']]) }}"
                                            download="{{ $customAttributeValue['label'] }}"
                                        >
                                            <span class="icon-download text-2xl"></span>
                                        </a>
                                    @elseif ($customAttributeValue['type'] == 'image')
                                        <a
                                            href="{{ Storage::url($product[$customAttributeValue['code']]) }}"
                                            download="{{ $customAttributeValue['label'] }}"
                                        >
                                            <img
                                                class="h-5 min-h-5 w-5 min-w-5"
                                                src="{{ Storage::url($customAttributeValue['value']) }}"
                                                alt="Product Image"
                                            />
                                        </a>
                                    @else
                                        <div class="grid">
                                            <p class="text-base text-zinc-500">
                                                {{ $customAttributeValue['value'] ?? '-' }}
                                            </p>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </x-slot>
            </x-shop::accordion>
        @endif

        <!-- Reviews Accordion -->
        <x-shop::accordion
            class="max-md:border-none"
            :is-active="false"
        >
            <x-slot:header
                class="bg-gray-100 max-md:!py-3 max-sm:!py-2"
                id="review-accordian-button"
            >
                <p class="text-base font-medium">
                    @lang('shop::app.products.view.review')
                </p>
            </x-slot>

            <x-slot:content>
                @include('shop::products.view.reviews')
            </x-slot>
        </x-shop::accordion>
    </div>
        <!-- filepath: /Users/tolgaege/Desktop/html/Webapps/trendyx_eticaret/packages/Webkul/Shop/src/Resources/views/products/view.blade.php -->
    
     
    <!-- Related Products bölümünden önce ekleyin -->
    
        <!-- Özel HTML içeriği -->
        
        @include('shop::products.view.ozel-html', [
            'product' => $product,
            "product_detail" => $product->categories->first()->slug === "taki-ve-aksesuar" ?  [
    'buy-now'             => 'Hemen Satın Al',
    'buy-now_second'      => 'Hemen Keşfet',
    'hero-subtitle'       => 'Sofistike tasarımıyla stilinize zarafet katan altın renkli çelik . Günlük ve özel kombinlerinizin vazgeçilmezi.',
    'features-title'      => 'Öne Çıkan Özellikler',
    'features-description'=> 'Yüksek kaliteli 316L paslanmaz çelikten üretilmiş, özel altın kaplamasıyla solmaya ve kararmaya karşı dayanıklı .' ,
    'why-choose'          => 'Neden Çelik Gold ?',
    'why-description'     => 'Hipoalerjenik yapısı ve uzun ömürlü kullanımıyla konfor ve şıklığı bir arada sunar.',
    'user-experiences'    => 'Kullanıcı Deneyimleri',
    'faq-title'           => 'Sık Sorulan Sorular',
    'faq-subtitle'        => 'Ürün Hakkında Merak Ettikleriniz',

    'features-product'    => 'Çelik Gold ',
    'features-other'      => 'Diğer',


    'percentages_title'   => 'Kullanıcı Yorumları',

    'section-title'       => 'Her Kombinin Vazgeçilmezi',
    'section-desc'        => 'Altın kaplama yüzeyi ve kalın tasarımıyla gün boyu şıklık sağlayan bu çelik , farklı stillerle kolayca uyum sağlar. Paslanmaz malzemesi sayesinde uzun süre yeni gibi kalır.',

    'benefits' => [
        [
            'icon'  => '💛',
            'title' => 'Altın Kaplama',
            'desc'  => 'Solmaya ve kararmaya karşı dayanıklı', 
        ],
        [
            'icon'  => '💪',
            'title' => 'Sağlam Çelik',
            'desc'  => 'Dayanıklı 316L paslanmaz çelik malzeme', 
        ],
        [
            'icon'  => '👌',
            'title' => 'Hipoalerjenik',
            'desc'  => 'Cilt dostu ve alerji yapmaz',
        ],
        [
            'icon'  => '📏',
            'title' => 'Mükemmel Boyut',
            'desc'  => 'Yaklaşık 6.5 cm çap, 21 cm iç çevre',
        ],
    ],

    'features' => [
        [
            'title' => 'Altın Kaplama',
            'icon1' => '✓',
            'icon2' => '✕',
        ],
        [
            'title' => 'Paslanmaz Çelik',
            'icon1' => '✓',
            'icon2' => '✕',
        ],
        [
            'title' => 'Hipoalerjenik',
            'icon1' => '✓',
            'icon2' => '✕',
        ],
        [
            'title' => 'Günlük Kullanıma Uygun',
            'icon1' => '✓',
            'icon2' => '✕',
        ],
    ],

    'percentages' => [
        [
            'title' => 'Şıklığından memnun kaldı',
            'oran'  => '96',
        ],
        [
            'title' => 'Uzun ömürlü kullandı',
            'oran'  => '94',
        ],
        [
            'title' => 'Tekrar satın almayı düşünüyor',
            'oran'  => '92',
        ],
    ],

    'faqs' => [
        [
            'question' => 'Bileziğin çapı nedir?',
            'answer'   => 'Yaklaşık 6.5 cm çapında olup 21 cm iç çevreye sahiptir.', 
        ],
        [
            'question' => 'Malzemesi nedir?',
            'answer'   => '316L paslanmaz çelik, özel altın kaplamalıdır.', 
        ],
        [
            'question' => 'Alerji yapar mı?',
            'answer'   => 'Hipoalerjenik özelliği sayesinde hassas ciltler için uygundur.',
        ],
        [
            'question' => 'Nasıl temizlenir?',
            'answer'   => 'Nemli bezle silerek nazikçe temizleyebilirsiniz.',
        ],
    ],
] : ($product->categories->first()->slug === "canta" ? [
        'buy-now' => 'Hemen Satın Al',
        'buy-now_second' => 'Hemen Keşfet',
        'hero-subtitle' => 'Modern tasarımı ve kullanışlı yapısıyla günlük hayatınızı kolaylaştıran şık çanta.',
        'features-title' => 'Öne Çıkan Özellikler',
        'features-description' => 'Yüksek kaliteli deri ve dayanıklı metal aksesuarlarla üretilmiş, her tarza uyum sağlayan çanta.',
        'why-choose' => 'Neden Bu Çantayı Seçmelisiniz?',
        'why-description' => 'Geniş iç hacmi ve çoklu bölmeleriyle eşyalarınızı düzenli tutmanızı sağlar.',
        'user-experiences' => 'Kullanıcı Deneyimleri',
        'faq-title' => 'Sık Sorulan Sorular',
        'faq-subtitle' => 'Ürün Hakkında Merak Ettikleriniz',

        'features-product' => 'Premium Çanta',
        'features-other' => 'Diğer Çantalar',

        'percentages_title' => 'Kullanıcı Yorumları',

        'section-title' => 'Her Stile Uygun Tasarım',
        'section-desc' => 'Dayanıklı malzemesi ve şık tasarımıyla günlük kullanım için ideal. Çoklu bölmeleri sayesinde eşyalarınızı düzenli tutmanızı sağlar.',

        'benefits' => [
            [
                'icon' => '💼',
                'title' => 'Geniş Hacim',
                'desc' => 'Tüm eşyalarınız için yeterli alan'
            ],
            [
                'icon' => '🛡️',
                'title' => 'Dayanıklı Yapı',
                'desc' => 'Uzun ömürlü kullanım için tasarlandı'
            ],
            [
                'icon' => '✨',
                'title' => 'Premium Kalite',
                'desc' => 'Yüksek kaliteli malzemeler'
            ],
            [
                'icon' => '🎨',
                'title' => 'Şık Tasarım',
                'desc' => 'Her kombine uyum sağlar'
            ]
        ],

        'features' => [
            [
                'title' => 'Premium Kalite',
                'icon1' => '✓',
                'icon2' => '✕'
            ],
            [
                'title' => 'Çoklu Bölme',
                'icon1' => '✓',
                'icon2' => '✕'
            ],
            [
                'title' => 'Su Geçirmez',
                'icon1' => '✓',
                'icon2' => '✕'
            ],
            [
                'title' => 'Ayarlanabilir Askı',
                'icon1' => '✓',
                'icon2' => '✕'
            ]
        ],

        'percentages' => [
            [
                'title' => 'Kalitesinden memnun kaldı',
                'oran' => '95'
            ],
            [
                'title' => 'Kullanışlı buldu',
                'oran' => '93'
            ],
            [
                'title' => 'Başkalarına önerdi',
                'oran' => '91'
            ]
        ],

        'faqs' => [
            [
                'question' => 'Çantanın boyutları nedir?',
                'answer' => '30cm x 40cm x 15cm (En x Boy x Derinlik)'
            ],
            [
                'question' => 'Malzemesi nedir?',
                'answer' => 'Yüksek kaliteli suni deri ve metal aksesuarlar'
            ],
            [
                'question' => 'Kaç bölmesi var?',
                'answer' => '1 ana bölme, 2 yan cep ve 1 iç fermuarlı cep'
            ],
            [
                'question' => 'Nasıl temizlenir?',
                'answer' => 'Nemli bezle silinebilir, kuru temizleme önerilir'
            ]
        ]
    ]:[
                'buy-now' => 'Hemen Satın Al',
                'buy-now_second' => 'Hemen Keşfet',
                'hero-subtitle' => 'Hayal gücünüzü gökyüzüne taşıyan benzersiz bir gece lambası! Odanızı adeta bir galaksiye dönüştürerek sizi bambaşka bir atmosferle buluşturur.',
                'features-title' => 'Büyüleyici Özellikler',
                'features-description' => 'Ayarlanabilir ışık modları ve yıldız projeksiyon efektleri ile size huzurlu bir ortam sunar.',
                'why-choose' => 'Neden Starlink Gece Lambası?',
                'why-description' => 'Göz yormayan yumuşak ışıklar ve sessiz çalışma özelliğiyle, gece konforunuz için tasarlandı.',
                'user-experiences' => 'Kullanıcı Deneyimleri',
                'faq-title' => 'Sık Sorulan Sorular',
                'faq-subtitle' => 'Hakkında Bilmek İstedikleriniz',

                'features-product' => 'Starlink Lamba',
                'features-other' => 'Diğer Lambalar',


                "percentages_title" => "Kullanıcı Deneyimleri",

                'section-title' => 'Keyifli Geceler İçin Tasarlandı',
                'section-desc' => 'Starlink Gece Lambası, yumuşak ışığı ve göz alıcı efektleriyle yatak odanızı huzurlu bir atmosfere dönüştürür. USB şarj özelliği ve kolay kullanımı ile her yaştan kullanıcı için ideal.',

                "benefits" => [ 
                    [
                        'icon' => '🌟',
                        'title' => '360° Projeksiyon',
                        'desc' => 'Tam dönebilen gökyüzü yansıtma özelliği',
                    ],
                    [
                        'icon' => '🌙',
                        'title' => 'Galaksi Efektleri',
                        'desc' => 'Ay, yıldızlar ve galaksi efekti bir arada',
                    ],
                    [
                        'icon' => '🔋',
                        'title' => 'Uzun Pil Ömrü',
                        'desc' => 'Tam şarjla 8 saate kadar kesintisiz kullanım',
                    ],
                    [
                        'icon' => '🛠️',
                        'title' => 'Kolay Kurulum',
                        'desc' => 'Hızlı ve pratik montaj için tasarlandı',
                    ]
                ],
                "features" => [ 
                    [
                        'title' => '360° Projeksiyon',
                        'icon1' => '✓',
                        'icon2' => '✕',
                    ],
                    [
                        'title' => 'LED Teknolojisi',
                        'icon1' => '✓',
                        'icon2' => '✕',
                    ],
                    [
                        'title' => 'Sessiz Çalışma',
                        'icon1' => '✓',
                        'icon2' => '✕',
                    ],
                    [
                        'title' => 'Uzun Pil Ömrü',
                        'icon1' => '✓',
                        'icon2' => '✕',
                    ],
                ],
                "percentages" => [ 
                    [
                        'title' => 'Uyku kalitesinde artış yaşadı',
                        'oran' => '97',
                    ], 
                    [
                        'title' => 'Rahatlatıcı etkisinden memnun kaldı',
                        'oran' => '96',
                    ],
                    [
                        'title' => 'Tekrar satın almayı düşünüyor',
                        'oran' => '98',
                    ],

                ],
                "faqs"=>[
                    [
                        'question' => 'Pil ömrü ne kadar?',
                        'answer' => 'Tam şarjla 8 saate kadar kesintisiz kullanım sağlar.'
                    ],
                    [
                        'question' => 'Işık ayarları nasıl yapılır?',
                        'answer' => 'Dokunmatik kontrol paneli üzerinden 7 farklı renk ve 3 farklı parlaklık seviyesi ayarlanabilir.'
                    ],
                    [
                        'question' => 'Garanti süresi nedir?',
                        'answer' => '2 yıl resmi distribütör garantisi mevcuttur.'
                    ],
                ],
        
            ])
            
            ])
    
        
    
    <!-- Featured Products -->
    <x-shop::products.carousel
        :title="trans('shop::app.products.view.related-product-title')"
        :src="route('shop.api.products.related.index', ['id' => $product->id])"
    />

    <!-- Up-sell Products -->
    <x-shop::products.carousel
        :title="trans('shop::app.products.view.up-sell-title')"
        :src="route('shop.api.products.up-sell.index', ['id' => $product->id])"
    />

    {!! view_render_event('bagisto.shop.products.view.after', ['product' => $product]) !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-product-template"
        >
            <x-shop::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
            >
                <form
                    ref="formData"
                    @submit="handleSubmit($event, addToCart)"
                >
                    <input
                        type="hidden"
                        name="product_id"
                        value="{{ $product->id }}"
                    >

                    <input
                        type="hidden"
                        name="is_buy_now"
                        v-model="is_buy_now"
                    >

                    <div class="container px-[60px] max-1180:px-0">
                        <div class="mt-12 flex gap-9 max-1180:flex-wrap max-lg:mt-0 max-sm:gap-y-4">
                            <!-- Gallery Blade Inclusion -->
                            @include('shop::products.view.gallery')

                            <!-- Details -->
                            <div class="relative max-w-[590px] max-1180:w-full max-1180:max-w-full max-1180:px-5 max-sm:px-4">
                                {!! view_render_event('bagisto.shop.products.name.before', ['product' => $product]) !!}

                                <div class="flex justify-between gap-4">
                                    <h1 class="break-all text-3xl font-medium max-sm:text-xl">
                                        {{ $product->name }}
                                    </h1>

                                    @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                                        <div
                                            class="flex max-h-[46px] min-h-[46px] min-w-[46px] cursor-pointer items-center justify-center rounded-full border bg-white text-2xl transition-all hover:opacity-[0.8] max-sm:max-h-7 max-sm:min-h-7 max-sm:min-w-7 max-sm:text-base"
                                            role="button"
                                            aria-label="@lang('shop::app.products.view.add-to-wishlist')"
                                            tabindex="0"
                                            :class="isWishlist ? 'icon-heart-fill text-red-600' : 'icon-heart'"
                                            @click="addToWishlist"
                                        >
                                        </div>
                                    @endif
                                </div>

                                {!! view_render_event('bagisto.shop.products.name.after', ['product' => $product]) !!}

                                <!-- Rating -->
                                {!! view_render_event('bagisto.shop.products.rating.before', ['product' => $product]) !!}

                                @if ($totalRatings = $reviewHelper->getTotalFeedback($product))
                                    <!-- Scroll To Reviews Section and Activate Reviews Tab -->
                                    <div
                                        class="mt-1 w-max cursor-pointer max-sm:mt-1.5"
                                        role="button"
                                        tabindex="0"
                                        @click="scrollToReview"
                                    >
                                        <x-shop::products.ratings
                                            class="transition-all hover:border-gray-400 max-sm:px-3 max-sm:py-1"
                                            :average="$avgRatings"
                                            :total="$totalRatings"
                                            ::rating="true"
                                        />
                                    </div>
                                @endif

                                {!! view_render_event('bagisto.shop.products.rating.after', ['product' => $product]) !!}

                                <!-- Pricing -->
                                {!! view_render_event('bagisto.shop.products.price.before', ['product' => $product]) !!}

                                <p class="mt-[22px] flex items-center gap-2.5 text-2xl !font-medium max-sm:mt-2 max-sm:gap-x-2.5 max-sm:gap-y-0 max-sm:text-lg">
                                    {!! $product->getTypeInstance()->getPriceHtml() !!}
                                </p>

                                @if (\Webkul\Tax\Facades\Tax::isInclusiveTaxProductPrices())
                                    <span class="text-sm font-normal text-zinc-500 max-sm:text-xs">
                                        (@lang('shop::app.products.view.tax-inclusive'))
                                    </span>
                                @endif

                                @if (count($product->getTypeInstance()->getCustomerGroupPricingOffers()))
                                    <div class="mt-2.5 grid gap-1.5">
                                        @foreach ($product->getTypeInstance()->getCustomerGroupPricingOffers() as $offer)
                                            <p class="text-zinc-500 [&>*]:text-black">
                                                {!! $offer !!}
                                            </p>
                                        @endforeach
                                    </div>
                                @endif

                                {!! view_render_event('bagisto.shop.products.price.after', ['product' => $product]) !!}

                                {!! view_render_event('bagisto.shop.products.short_description.before', ['product' => $product]) !!}

                                <p class="mt-6 text-lg text-zinc-500 max-sm:mt-1.5 max-sm:text-sm">
                                    {!! $product->short_description !!}
                                </p>

                                {!! view_render_event('bagisto.shop.products.short_description.after', ['product' => $product]) !!}

                                @include('shop::products.view.types.simple')

                                @include('shop::products.view.types.configurable')

                                @include('shop::products.view.types.grouped')

                                @include('shop::products.view.types.bundle')

                                @include('shop::products.view.types.downloadable')

                                @include('shop::products.view.types.booking')

                                <!-- Product Actions and Quantity Box -->
                                <div class="mt-8 flex max-w-[470px] gap-4 max-sm:mt-4">

                                    {!! view_render_event('bagisto.shop.products.view.quantity.before', ['product' => $product]) !!}

                                    @if ($product->getTypeInstance()->showQuantityBox())
                                        <x-shop::quantity-changer
                                            name="quantity"
                                            value="1"
                                            class="gap-x-4 rounded-xl px-7 py-4 max-md:py-3 max-sm:gap-x-5 max-sm:rounded-lg max-sm:px-4 max-sm:py-1.5"
                                        />
                                    @endif

                                    {!! view_render_event('bagisto.shop.products.view.quantity.after', ['product' => $product]) !!}

                                    @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                                        <!-- Add To Cart Button -->
                                        {!! view_render_event('bagisto.shop.products.view.add_to_cart.before', ['product' => $product]) !!}

                                        <x-shop::button
                                            type="submit"
                                            class="secondary-button w-full max-w-full max-md:py-3 max-sm:rounded-lg max-sm:py-1.5"
                                            button-type="secondary-button"
                                            :loading="false"
                                            :title="trans('shop::app.products.view.add-to-cart')"
                                            :disabled="! $product->isSaleable(1)"
                                            ::loading="isStoring.addToCart"
                                            ::disabled="isStoring.addToCart"
                                            @click="is_buy_now=0;"
                                        />

                                        {!! view_render_event('bagisto.shop.products.view.add_to_cart.after', ['product' => $product]) !!}
                                    @endif
                                </div>

                                <!-- Buy Now Button -->
                                @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                                    {!! view_render_event('bagisto.shop.products.view.buy_now.before', ['product' => $product]) !!}

                                    @if (core()->getConfigData('catalog.products.storefront.buy_now_button_display'))
                                        <x-shop::button
                                            type="submit"
                                            class="primary-button mt-5 w-full max-w-[470px] max-md:py-3 max-sm:mt-3 max-sm:rounded-lg max-sm:py-1.5"
                                            button-type="primary-button"
                                            :title="trans('shop::app.products.view.buy-now')"
                                            :disabled="! $product->isSaleable(1)"
                                            ::loading="isStoring.buyNow"
                                            @click="is_buy_now=1;"
                                            ::disabled="isStoring.buyNow"
                                        />
                                    @endif

                                    {!! view_render_event('bagisto.shop.products.view.buy_now.after', ['product' => $product]) !!}
                                @endif

                                {!! view_render_event('bagisto.shop.products.view.additional_actions.before', ['product' => $product]) !!}

                                <!-- Share Buttons -->
                                <div class="mt-10 flex gap-9 max-md:mt-4 max-md:flex-wrap max-sm:justify-center max-sm:gap-3">
                                    {!! view_render_event('bagisto.shop.products.view.compare.before', ['product' => $product]) !!}

                                    <div
                                        class="flex cursor-pointer items-center justify-center gap-2.5 max-sm:gap-1.5 max-sm:text-base"
                                        role="button"
                                        tabindex="0"
                                        @click="is_buy_now=0; addToCompare({{ $product->id }})"
                                    >
                                        @if (core()->getConfigData('catalog.products.settings.compare_option'))
                                            <span
                                                class="icon-compare text-2xl"
                                                role="presentation"
                                            ></span>

                                            @lang('shop::app.products.view.compare')
                                        @endif
                                    </div>

                                    {!! view_render_event('bagisto.shop.products.view.compare.after', ['product' => $product]) !!}
                                </div>

                                {!! view_render_event('bagisto.shop.products.view.additional_actions.after', ['product' => $product]) !!}
                            </div>
                        </div>
                    </div>
                </form>
            </x-shop::form>
        </script>

        <script type="module">
            app.component('v-product', {
                template: '#v-product-template',

                data() {
                    return {
                        isWishlist: Boolean("{{ (boolean) auth()->guard()->user()?->wishlist_items->where('channel_id', core()->getCurrentChannel()->id)->where('product_id', $product->id)->count() }}"),

                        isCustomer: '{{ auth()->guard('customer')->check() }}',

                        is_buy_now: 0,

                        isStoring: {
                            addToCart: false,

                            buyNow: false,
                        },
                    }
                },

                methods: {
                    addToCart(params) {
                        const operation = this.is_buy_now ? 'buyNow' : 'addToCart';

                        this.isStoring[operation] = true;

                        let formData = new FormData(this.$refs.formData);

                        this.ensureQuantity(formData);

                        this.$axios.post('{{ route("shop.api.checkout.cart.store") }}', formData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                            .then(response => {
                                if (response.data.message) {
                                    this.$emitter.emit('update-mini-cart', response.data.data);

                                    this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                    if (response.data.redirect) {
                                        window.location.href= response.data.redirect;
                                    }
                                } else {
                                    this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                                }

                                this.isStoring[operation] = false;
                            })
                            .catch(error => {
                                this.isStoring[operation] = false;

                                this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                            });
                    },

                    addToWishlist() {
                        if (this.isCustomer) {
                            this.$axios.post('{{ route('shop.api.customers.account.wishlist.store') }}', {
                                    product_id: "{{ $product->id }}"
                                })
                                .then(response => {
                                    this.isWishlist = ! this.isWishlist;

                                    this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                                })
                                .catch(error => {});
                        } else {
                            window.location.href = "{{ route('shop.customer.session.index')}}";
                        }
                    },

                    addToCompare(productId) {
                        /**
                         * This will handle for customers.
                         */
                        if (this.isCustomer) {
                            this.$axios.post('{{ route("shop.api.compare.store") }}', {
                                    'product_id': productId
                                })
                                .then(response => {
                                    this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                                })
                                .catch(error => {
                                    if ([400, 422].includes(error.response.status)) {
                                        this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.data.message });

                                        return;
                                    }

                                    this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message});
                                });

                            return;
                        }

                        /**
                         * This will handle for guests.
                         */
                        let existingItems = this.getStorageValue(this.getCompareItemsStorageKey()) ?? [];

                        if (existingItems.length) {
                            if (! existingItems.includes(productId)) {
                                existingItems.push(productId);

                                this.setStorageValue(this.getCompareItemsStorageKey(), existingItems);

                                this.$emitter.emit('add-flash', { type: 'success', message: "@lang('shop::app.products.view.add-to-compare')" });
                            } else {
                                this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('shop::app.products.view.already-in-compare')" });
                            }
                        } else {
                            this.setStorageValue(this.getCompareItemsStorageKey(), [productId]);

                            this.$emitter.emit('add-flash', { type: 'success', message: "@lang('shop::app.products.view.add-to-compare')" });
                        }
                    },

                    updateQty(quantity, id) {
                        this.isLoading = true;

                        let qty = {};

                        qty[id] = quantity;

                        this.$axios.put('{{ route('shop.api.checkout.cart.update') }}', { qty })
                            .then(response => {
                                if (response.data.message) {
                                    this.cart = response.data.data;
                                } else {
                                    this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                                }

                                this.isLoading = false;
                            }).catch(error => this.isLoading = false);
                    },

                    getCompareItemsStorageKey() {
                        return 'compare_items';
                    },

                    setStorageValue(key, value) {
                        localStorage.setItem(key, JSON.stringify(value));
                    },

                    getStorageValue(key) {
                        let value = localStorage.getItem(key);

                        if (value) {
                            value = JSON.parse(value);
                        }

                        return value;
                    },

                    scrollToReview() {
                        let accordianElement = document.querySelector('#review-accordian-button');

                        if (accordianElement) {
                            accordianElement.click();

                            accordianElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }

                        let tabElement = document.querySelector('#review-tab-button');

                        if (tabElement) {
                            tabElement.click();

                            tabElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                    },

                    ensureQuantity(formData) {
                        if (! formData.has('quantity')) {
                            formData.append('quantity', 1);
                        }
                    },
                },
            });
        </script>
    @endPushOnce
</x-shop::layouts>
