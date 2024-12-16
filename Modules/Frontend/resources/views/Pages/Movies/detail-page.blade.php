@extends('frontend::layouts.master', ['isSwiperSlider' => true, 'isVideoJs' => true, 'bodyClass' => 'custom-header-relative', 'isSelect2' => true])
@section('content')
    <div class="iq-main-slider site-video">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pt-0">
                    <video id="my-video" poster="{{ asset($movie->banner_image) }}"
                            class="video-js vjs-big-play-centered w-100 my-video-details"
                            @if(!empty($userpurchasedetails)) controls @endif
                            preload="metadata"
                            data-setup='{{ asset($movie->banner_image) }}'
                            @if(!empty($userpurchasedetails) && isset($userpurchasedetails->paused_length))
                            onloadedmetadata="this.currentTime = {{ $userpurchasedetails->paused_length }}"
                            @endif>
                            <source src="{{ asset('movies/' . $movie->movieurl) }}" type="video/mp4" />
                            <source src="MY_VIDEO.webm" type="video/webm" />
                        </video>


                    <input type="hidden" id="movie-id" value="{{ $movie->id }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="movie-purchase-btns pt-5">
    <div class="container">
    <div class="d-flex gap-1">
        @if($userpurchasedetails)
        @else
        @if($movie->getticket)
        <div class="movie-data-buttons">
        <a href="{{ url('/initiate-payment/' . Crypt::encrypt($movie->id)) }}">
                <button id="rzp-button" type="button" class="btn  btn-success btn-sm text-white">Get Tickets</button>
            </a>         
        </div>
        @endif 
        @endif
        @if($movie->officalsite)
        <div class="movie-data-buttons">
           <a href="{{ $movie->officalsite }}" target="_blank"><button type="button" class="btn btn-info btn-sm text-white">Official Site</button></a> 
        </div>
        @endif
        @if($movie->ott)
        <div class="movie-data-buttons">
          <button type="button" class="btn  btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#exampleModalLong">On OTT's</button>
        </div>
        @endif
    </div>
</div>

<!-- ott model -->
<div class="modal fade" id="exampleModalLong"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">OTT APPs</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row pt-3 pb-3">
        @foreach($ottdetails as $key => $otts)
        @foreach($otts->ottdetails as  $ott)
            <div class="col-3">
              <a href="{{ $ott->url }}" target="_blank"><img src="{{ asset($ott->ott->image) }}" alt="" width="100" height="100" class="img-fluid"></a>  
            </div>
        @endforeach
        
        </div>
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- ott model -->

    <div class="details-part">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @include('frontend::components.cards.movie-description', [
                        'moveName' => $movie->title,
                        'imdbRating' => '4.8',
                        'movieType' => __('frontenddetail_page.horror'),
                        'movieDuration' => '1hr : 48mins',
                        'movieReleased' => 'Feb 2017',
                        'trailerLink' => $movie->triallerurl,
                        'bgImageurl' => $movie->bgsm_image
                    ])

                    @include('frontend::components.cards.movie-source')

                </div>
            </div>
        </div>
    </div>

    <!-- full movie description -->
    <!-- <div class="cast-tabs">
        <div class="container-fluid">
            <div class="content-details trending-info g-border iq-rtl-direction">
                <ul class="iq-custom-tab tab-bg-fill d-flex nav nav-pills mb-5 " role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" data-bs-toggle="pill" href="#cast-1" role="tab"
                            aria-selected="true">{{__('frontenddetail_page.cast')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="pill" href="#crew-1" role="tab"
                            aria-selected="false">{{__('frontenddetail_page.crew')}}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="cast-1" class="tab-pane animated fadeInUp active show" role="tabpanel">
                        <div class="position-relative swiper swiper-card" data-slide="5" data-laptop="5" data-tab="3"
                            data-mobile="2" data-mobile-sm="1" data-autoplay="false" data-loop="false"
                            data-navigation="true" data-pagination="true">
                            <ul class="list-inline swiper-wrapper">
                                <li class="swiper-slide">
                                    <div class="cast-images m-0 row align-items-center position-relative">
                                        <div class="col-4 img-box p-0">
                                            <img src="{{ asset('frontend/images/genre/g1.webp') }}" class="img-fluid"
                                                alt="image" loading="lazy">
                                        </div>
                                        <div class="col-8 block-description">
                                            <h6 class="iq-title">
                                                <a href="{{route('frontend.cast_details')}}" tabindex="0">{{__('frontenddetail_page.james_chinlund')}} </a>
                                            </h6>
                                            <div class="video-time d-flex align-items-center my-2">
                                                <small class="text-white">{{__('frontenddetail_page.as_james')}}</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="swiper-slide">
                                    <div class="cast-images m-0 row align-items-center position-relative">
                                        <div class="col-4 img-box p-0">
                                            <img src="{{ asset('frontend/images/genre/g2.webp') }}" class="img-fluid"
                                                alt="image" loading="lazy">
                                        </div>
                                        <div class="col-8 block-description">
                                            <h6 class="iq-title">
                                                <a href="{{route('frontend.cast_details')}}" tabindex="0">{{__('frontenddetail_page.james_earl')}} </a>
                                            </h6>
                                            <div class="video-time d-flex align-items-center my-2">
                                                <small class="text-white">{{__('frontenddetail_page.as_jones')}}</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="crew-1" class="tab-pane animated fadeInUp" role="tabpanel">
                        <div class="position-relative swiper swiper-card" data-slide="5" data-laptop="5" data-tab="3"
                            data-mobile="2" data-mobile-sm="2" data-autoplay="false" data-loop="false"
                            data-navigation="true" data-pagination="true">
                            <ul class="list-inline swiper-wrapper">
                                <li class="swiper-slide">
                                    <div class="cast-images m-0 row align-items-center position-relative">
                                        <div class="col-4 img-box p-0">
                                            <img src="{{ asset('frontend/images/genre/g3.webp') }}" class="img-fluid"
                                                alt="image" loading="lazy">
                                        </div>
                                        <div class="col-8 block-description starring-desc ">
                                            <h6 class="iq-title">
                                                <a href="{{route('frontend.cast_details')}}" tabindex="0"> {{__('frontenddetail_page.jeff_nathanson')}} </a>
                                            </h6>
                                            <div class="video-time d-flex align-items-center my-2">
                                                <small class="text-white">{{__('frontenddetail_page.writing')}}</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="swiper-slide">
                                    <div class="cast-images m-0 row align-items-center position-relative">
                                        <div class="col-4 img-box p-0">
                                            <img src="{{ asset('frontend/images/genre/g5.webp') }}"
                                                class="person__poster--image img-fluid" alt="image" loading="lazy">
                                        </div>
                                        <div class="col-8 block-description starring-desc ">
                                            <h6 class="iq-title">
                                                <a href="{{route('frontend.cast_details')}}" tabindex="0"> {{__('frontenddetail_page.irene_mecchi')}} </a>
                                            </h6>
                                            <div class="video-time d-flex align-items-center my-2">
                                                <small class="text-white">{{__('frontenddetail_page.writing')}}</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="swiper-slide">
                                    <div class="cast-images m-0 row align-items-center position-relative">
                                        <div class="col-4 img-box p-0">
                                            <img src="{{ asset('frontend/images/genre/g4.webp') }}"
                                                class="person__poster--image img-fluid" alt="image" loading="lazy">
                                        </div>
                                        <div class="col-8 block-description starring-desc ">
                                            <h6 class="iq-title">
                                                <a href="{{route('frontend.cast_details')}}" tabindex="0"> {{__('frontenddetail_page.karan_gilchrist')}} </a>
                                            </h6>
                                            <div class="video-time d-flex align-items-center my-2">
                                                <small class="text-white">{{__('frontenddetail_page.production')}} </small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
<!-- end ful -->

    <!-- below movies recomended -->

    <script>
document.addEventListener('DOMContentLoaded', () => {
    // Initialize the Video.js player
    const videoElement = document.querySelector('#my-video'); // The video element ID
    const movieId = document.querySelector('#movie-id').value;
    const player = videojs(videoElement); // Create Video.js player instance

    // Function to save playback details
    function savePlaybackDetails() {
        const currentTime = player.currentTime(); // Current playback time
        const totalLength = player.duration(); // Total video duration

        console.log(`Saving playback: Current time = ${currentTime}, Total length = ${totalLength}`);

        $.ajax({
            url: "{{ route('frontend.updateplaytrack') }}", // URL endpoint
            type: 'POST', // HTTP method
            dataType: 'json', // Expected response data type
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                movie_id: movieId, // Movie ID
                current_time: currentTime, // Current playback time
                total_length: totalLength, // Total video duration
            },
            success: function (response) {
                console.log('Playback saved:', response);
            },
            error: function (xhr, status, error) {
                console.error('Error saving playback:', error);
                console.error('Response:', xhr.responseText);
            },
        });
    }

    player.ready(() => {
        console.log('Video.js player is ready.');

        // Listen for control-related events
        const events = ['play', 'pause', 'seeked', 'volumechange', 'ratechange', 'fullscreenchange'];

        events.forEach(event => {
            player.on(event, () => {
                console.log(`User triggered event: ${event}`);
                savePlaybackDetails();
            });
        });

        // Add event listener for metadata loaded
        player.on('loadedmetadata', () => {
            console.log('Metadata loaded. Duration:', player.duration());
        });

        // Save playback details every 10 minutes (600,000 milliseconds)
        setInterval(savePlaybackDetails, 600000);

        // Trigger save on page unload
        window.addEventListener('beforeunload', () => {
            savePlaybackDetails();
        });

        // Trigger save when the page becomes hidden
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                savePlaybackDetails();
            }
        });

        // Fallback for sudden shutdown or close
        window.addEventListener('unload', () => {
            savePlaybackDetails();
        });
    });
});
</script>

        <!-- below movies recomended -->
@endsection
