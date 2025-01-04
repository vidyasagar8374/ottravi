@extends('frontend::layouts.master', ['isSwiperSlider' => true ,'bodyClass'=>"custom-header-relative","isSelect2"=>true])
@section('content')
<section id="home-banner-slider" class="iq-main-slider p-0 swiper banner-home-swiper overflow-hidden"
    data-swiper="home-banner-slider">
    <div class="slider m-0 p-0 swiper-wrapper home-slider">
        @foreach($banners as $banner)
        @php
        $movieId =  Crypt::encrypt($banner->movie_id);
        @endphp
        <div class="swiper-slide slide s-bg-1 p-0" data-autoplay="true" data-loop="true">
            <div class="banner-home-swiper-image">
                <img src="{{ asset($banner->banner_image) }}" alt="banner-home-swiper-image"
                    loading="lazy" />
            </div>
            <div class="container-fluid position-relative h-100">
                <div class="slider-inner h-100">
                    <div class="row align-items-center iq-ltr-direction h-100 pl-3">
                        <div class="col-lg-7 col-md-12 ">
                            <h1 style="background-image: url('{{ asset('frontend/images/pages/texure.webp') }}');"
                                class="texture-text big-font letter-spacing-1 line-count-1 text-uppercase mb-0 RightAnimate">
                                <!-- {{__('frontendhome.another_danger')}} -->{{ $banner->title}}
                            </h1>
                            <div class="d-flex flex-wrap align-items-center r-mb-23 RightAnimate-two">
                                <div class="slider-ratting d-flex align-items-center">
                                    <ul
                                        class="ratting-start p-0 m-0 list-inline text-warning d-flex align-items-center justify-content-left">
                                        <!-- <li>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </li>
                                        <li>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </li>
                                        <li>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </li>
                                        <li>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </li>
                                        <li>
                                            <i class="fa fa-star-half" aria-hidden="true"></i>
                                        </li> -->
                                    </ul>
                                    <!-- <span class="text-white ms-2 font-size-14 fw-500">4.3/5</span> -->
                                    <!-- <span class="ms-2">
                                        <img src="{{ asset('frontend/images/movies/imdb-logo.svg') }} " alt="imdb logo"
                                            class="img-fluid" loading="lazy">
                                    </span> -->
                                </div>
                                <span
                                    class="badge rounded-0 text-white text-uppercase p-2 mx-3 bg-secondary">{{__('frontendhome.action')}}</span>
                                <span class="font-size-14 fw-500 time">{{ $banner->duration }} Hr : 6 Mins</span>
                            </div>
                            <p class="line-count-3 RightAnimate-two"> 
                                <!-- {{__('frontendhome.piracy_robbery')}} -->
                                {{ $banner->subtitle }}

                            </p>
                            <div class="trending-list RightAnimate-three">
                                <div class="text-primary genres fw-500"> Genres:
                                    <!-- <a href="{{ route('frontend.view_all') }}"
                                        class="fw-normal text-white text-decoration-none ms-2">
                                        {{__('frontendhome.action')}} </a> -->

                                        {{ $banner->genres }}
                                </div>
                                <div class="text-primary tag fw-500"> Tag:
                                    <!-- <a href="{{ route('frontend.view_all') }}"
                                        class="fw-normal text-white text-decoration-none ms-2">
                                        {{__('frontendhome.action')}}, </a>
                                    <a href="{{ route('frontend.view_all') }}"
                                        class="fw-normal text-white text-decoration-none ms-2">
                                        {{__('frontendhome.adventure')}}, </a>
                                    <a href="{{ route('frontend.view_all') }}"
                                        class="fw-normal text-white text-decoration-none ms-2">
                                        {{__('frontendhome.horror')}} </a> -->
                                        @php 
                                            $tags = explode(';', $banner->tags);
                                        @endphp

                                        @foreach($tags as $index => $tag)
                                            <span>{{ $tag }}</span>@if($index < count($tags) - 1), @endif
                                        @endforeach

                                </div>
                            </div>
                            @php
                                $movieIds = '';
                            @endphp

                            @foreach($moviescategories as $category)
                                @foreach($category->categoryname as $data)
                                    @php
                                        $movieIds = $data->movie->id;
                                    @endphp
                                @endforeach
                            @endforeach

                            <div class="RightAnimate-four">
                                @include('frontend::components.cards.custom-button', [
                                'buttonUrl' => route('frontend.movie_detail',['id' => $movieId ?? '']),
                                'buttonTitle' => __('otthome.play_now'),
                                ])
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12 trailor-video iq-slider d-none d-lg-block" >
                            <a 
                                class="video-open playbtn text-decoration-none"  data-bs-toggle="modal" data-bs-target="#videoModal" data-url="{{ $banner->trailer }}">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px"
                                    height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7"
                                    xml:space="preserve">
                                    <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-miterlimit="10"
                                        points="73.5,62.5 148.5,105.8 73.5,149.1 "></polygon>
                                    <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3">
                                    </circle>
                                </svg>
                                <span class="w-trailor text-uppercase"> {{__('frontendhome.watch_trailer')}} </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>      
        <!-- model -->
                <!-- Modal -->

        <!-- model -->
        @endforeach
        <!-- carousel trailer model -->
     
        <!-- carousel trailer model -->
        
    </div>
    <div class="swiper-banner-button-prev swiper-nav" id="home-banner-slider-prev">
        <i></i>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44" height="44" fill="none"
            stroke="currentColor">
            <circle r="20" cy="22" cx="22"></circle>
        </svg>
    </div>
    <div class="swiper-banner-button-next swiper-nav" id="home-banner-slider-next">
        <i></i>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44" height="44" fill="none"
            stroke="currentColor">
            <circle r="20" cy="22" cx="22"></circle>
        </svg>
    </div>
    <div class="swiper-pagination"></div>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44px" height="44px" id="circle"
            fill="none" stroke="currentColor">
            <circle r="20" cy="22" cx="22" id="test"></circle>
        </symbol>
    </svg>
</section>

<section>
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Trailer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                    <iframe width="560" height="315"  id="youtubeVideo"  src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@auth
    @include('frontend::components.sections.continue-watching', ['value' => '4'])
@endauth

@include('frontend::components.sections.upcomming')
@include('frontend::components.sections.parallax')



<script>
    
    document.getElementById('videoModal').addEventListener('show.bs.modal', function (event) {
    // Get the button that triggered the modal
    const button = event.relatedTarget;
    
    // Extract video URL from data-url attribute
    const youtubeID = button.getAttribute('data-url');
    const youtubeURL = 'https://www.youtube.com/embed/' + youtubeID;
    
    // Set the iframe src to the video URL
    document.getElementById('youtubeVideo').src = youtubeURL;

    // Stop the carousel (pause Swiper autoplay)
    if (window.homeBannerSlider && homeBannerSlider.autoplay) {
        console.log("Stopping Swiper autoplay"); // Debugging
        homeBannerSlider.autoplay.stop();
    } else {
        console.warn("Swiper instance not found or autoplay is not enabled");
    }
});

document.getElementById('videoModal').addEventListener('hide.bs.modal', function () {
    // Clear the video URL from iframe
    document.getElementById('youtubeVideo').src = "";

    // Resume the carousel (start Swiper autoplay)
    if (window.homeBannerSlider && homeBannerSlider.autoplay) {
        console.log("Starting Swiper autoplay"); // Debugging
        homeBannerSlider.autoplay.start();
    } else {
        console.warn("Swiper instance not found or autoplay is not enabled");
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Initialize the Swiper
    window.homeBannerSlider = new Swiper('.banner-home-swiper', {
        loop: true,
        autoplay: {
            delay: 4000, // 4 seconds
            disableOnInteraction: false,
        },
    });

    console.log("Swiper initialized:", homeBannerSlider); // Debugging
});




// $(document).ready(function () {
//     let activeRequest = null;
//     let hoverTimeout = null;

//     $('.swiper-slide.video-popup-open').each(function () {
//         const $this = $(this);

//         $this.on('mouseenter', function () {
//             const movieId = $this.data('movie-id');

//             // Abort any ongoing AJAX request
//             if (activeRequest) activeRequest.abort();

//             hoverTimeout = setTimeout(function () {
//                 activeRequest = $.ajax({
//                     url: "{{ route('get.video') }}",
//                     type: 'GET',
//                     data: { movieId: movieId },
//                     success: function (response) {
//                         console.log("Video URL:", response.videoUrl);

//                         if ($this.is(':hover') && response.videoUrl) {
//                             // Set video source and open the modal
//                             $('#modalVideoSource').attr('src', response.videoUrl);
//                             $('#modalVideo')[0].load(); // Load the video
//                             $('#videoModalhover').modal('show'); // Show modal
//                         }
//                     },
//                     error: function (xhr, status, error) {
//                         console.error("Error fetching video:", error);
//                     }
//                 });
//             }, 3000); // Add delay to avoid unnecessary requests
//         });

//         $this.on('mouseleave', function () {
//             // Clear hover timeout and abort any ongoing request
//             if (hoverTimeout) clearTimeout(hoverTimeout);
//             if (activeRequest) activeRequest.abort();

//             // Close the modal and reset video source
//             $('#videoModalhover').modal('hide');
//         });
//     });

//     // Reset video when modal is hidden
//     $('#videoModalhover').on('hidden.bs.modal', function () {
//         $('#modalVideo')[0].pause(); // Pause video playback
//         $('#modalVideoSource').attr('src', ''); // Clear video source
//     });
// });



</script>


@endsection
