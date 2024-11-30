@if(count($continuewatches) > 0)
<section class="continue-watching-block">
    <div class="container-fluid">
        <div class="overflow-hidden">
            <div class="d-flex align-items-center justify-content-between px-2 px-md-3 mb-4">
                <h5 class="main-title text-capitalize mb-0">{{__('otthome.continue_watching')}}</h5>
            </div>
            <div class="position-relative swiper swiper-card" data-slide="{{$value}}" data-slide="4" data-laptop="4"
                data-tab="3" data-mobile="2" data-mobile-sm="2" data-autoplay="false" data-loop="false"
                data-navigation="true" data-pagination="true">
                <ul class="p-0 swiper-wrapper m-0  list-inline">
           
                    @foreach($continuewatches as $continuewatch)
                    @php
                        if (!function_exists('formatTime')) {
                            function formatTime($seconds) {
                                $hours = floor($seconds / 3600); // Calculate hours
                                $minutes = floor(($seconds % 3600) / 60); // Calculate minutes
                                $seconds = $seconds % 60; // Calculate remaining seconds

                                // Return time in HH:MM:SS format
                                return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                            }
                        }

                        // Calculate progress as a percentage
                        $progress = $continuewatch->total_length > 0 
                                    ? ($continuewatch->paused_length / $continuewatch->total_length) * 100 
                                    : 0;

                        // Format paused_length and total_length as time
                        $formattedPausedLength = formatTime($continuewatch->paused_length);
                        $formattedTotalLength = formatTime($continuewatch->total_length);

                        $movieid = Crypt::encrypt($continuewatch->movie_id);
                    @endphp
                      
                      
                        <li class="swiper-slide">
                            
                                @include('frontend::components.cards.continue-watch-card', [
                                    'imagePath' => asset($continuewatch->moviedata->bgsm_image),
                                    'progressValue' => round($progress, 2) . "%", // Rounded progress
                                    'dataLeftTime' => $formattedPausedLength . " of " . $formattedTotalLength,
                                    'movieId' => $movieid
                                ])
                            
                        </li>
                    @endforeach
                </ul>
                <div class="swiper-button swiper-button-next"></div>
                <div class="swiper-button swiper-button-prev"></div>
            </div>
        </div>
    </div>
</section>
@endif