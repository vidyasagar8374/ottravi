@extends('frontend::layouts.master', ['isSwiperSlider' => true, 'isVideoJs' => true, 'bodyClass' => 'custom-header-relative', 'isSelect2' => true])

@section('content')
<h1>sagar vidya M testing rep</h1>
    <div class="iq-main-slider site-video">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pt-0">
                        <video id="my-video" poster="{{ asset($movie->banner_image)  }}"
                            class="video-js vjs-big-play-centered w-100" controls preload="auto"
                            data-setup='{{ asset($movie->banner_image)  }}'>
                            <source src="{{ asset('frontend/images/video/sample-video.mp4') }}" type="video/mp4" />
                            <source src="MY_VIDEO.webm" type="video/webm" />
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="movie-purchase-btns pt-5">
    <div class="container">
    <div class="row justify-content-start">
        @if($movie->getticket)
        <div class="col-auto">
            <a href=""><button type="button" class="btn btn-outline-secondary">Get Tickets</button></a>
        </div>
        @endif 
        @if($movie->officalsite)
        <div class="col-auto">
           <a href="{{ $movie->officalsite }}" target="_blank"><button type="button" class="btn btn-outline-secondary">Official Site</button></a> 
        </div>
        @endif
        @if($movie->ott)
        <div class="col-auto">
          <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModalLong">Bye Now</button>
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


    <div class="cast-tabs">
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
    </div>


    <!-- below movies recomended -->

 



  

    
    


        <!-- below movies recomended -->
@endsection
