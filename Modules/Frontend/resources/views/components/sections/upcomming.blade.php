@foreach($moviescategories as $category)
<div class="upcomimg-block">
    <div class="container-fluid">
        <section class="overflow-hidden">
            <div class="d-flex align-items-center justify-content-between px-3 my-4">
                <h5 class="main-title text-capitalize mb-0">{{ $category->name }}</h5>
                <a href="{{ route('frontend.view_all') }}"
                    class="text-primary iq-view-all text-decoration-none flex-none">{{__('otthome.view_all')}}</a>
            </div>
            <div class="card-style-slider">
                <div class="position-relative swiper swiper-card" data-slide="6" data-laptop="6" data-tab="3"
                    data-mobile="2" data-mobile-sm="2" data-autoplay="false" data-loop="true" data-navigation="true"
                    data-pagination="true">
                    <ul class="p-0 swiper-wrapper m-0  list-inline">
                    @foreach($category->categoryname as $data)
                    <li class="swiper-slide video-popup-open"  data-movie-id="{{ Crypt::encrypt($data->movie->id) }}">
                            @include('frontend::components.cards.card-style', [
                                'cardImage' => asset($data->movie->bgsm_image),
                                'cardTitle' => $data->movie->title,
                                'movieTime' => '2hr : 12mins',
                                'videoUrl' => asset($data->movie->triallerurl),
                                'movieId' =>  Crypt::encrypt($data->movie->id),
                            ])
                        </li>
                    @endforeach
                   

                    </ul>
                    <div class="swiper-button swiper-button-next"></div>
                    <div class="swiper-button swiper-button-prev"></div>
                </div>
            </div>
        </section>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    




</body>


@endforeach
