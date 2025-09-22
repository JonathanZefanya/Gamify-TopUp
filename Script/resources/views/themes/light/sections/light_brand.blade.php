<!-- Brands sections start -->
@if(isset($light_brand))
    <section class="brands-section pt-20 pb-20">
        <div class="container">
            <div class="row">
                <div class="marquee-section">
                    @php
                        $iteration = 2;
                    @endphp
                    <div class="marquee marquee-left">
                        @for($i = 1; $i <= $iteration; $i++)
                            <div class="marquee-item-wrapper">
                                <div class="marquee-item-box">
                                    @foreach($light_brand['multiple'] as $item)
                                        <div class="brand-item">{{ $item['item'] ?? ' ' }}</div>
                                        <div class="brand-item"><i class="{{ $item['media']->icon ?? ' ' }}"></i></div>
                                    @endforeach
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!-- Brands sections end -->
