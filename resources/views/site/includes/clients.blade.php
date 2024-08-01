<!-- start clinet-index  -->
<section class="clinet-index mr-section">
    <div class="main-container">
        <div class="title-center">
            <span></span>
            <h2>{{ __('models.clients') }}</h2>
            <span></span>
        </div>

        <div class="main-clinet-index">
            <div class="owl-carousel owl-theme maincarousel" id="slider-clinet">

                @foreach ($clients as $client)
                    <div class="item">
                        <a href="{{ $client->link }}">
                            <div class="img-clinet-index">
                                <img src="{{ asset('storage/' . $client->image) }}" alt="">
                            </div>
                        </a>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
</section>
<!-- end  clinet-index  -->
