@foreach($moviescategories as $category)
<!-- adding git rep -->
<div class="upcomimg-block">
    <div class="container-fluid">
        <section class="overflow-hidden">
            <div class="d-flex align-items-center justify-content-between px-3 my-4">
                <h5 class="main-title text-capitalize mb-0">{{ $category->name }}</h5>
                <!-- <a href="{{ route('frontend.view_all') }}"
                    class="text-primary iq-view-all text-decoration-none flex-none">{{__('otthome.view_all')}}</a> -->
            </div>
            <div class="card-style-slider">
                <div class="position-relative swiper swiper-card" data-slide="6" data-laptop="6" data-tab="3"
                    data-mobile="2" data-mobile-sm="2" data-autoplay="false"  data-navigation="true"
                    data-pagination="true">
                    <ul class="p-0 swiper-wrapper m-0  list-inline">
                    @foreach($category->categoryname as $key => $data)
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
@endforeach
<!-- Video Modal -->
<div class="modal fade" id="videoModalhover" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-hotspot modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="video-container">
                    <video id="modalVideo" controls autoplay muted loop style="width: 100%; height: auto;">
                        <source id="modalVideoSource" src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let hoverTimeout; // Variable to store the timeout ID
const getVideoDetailsUrl = "{{ route('get.video') }}";
$('.video-and-image-block').hover(
    function () {
        const videoBoxhover = $(this).find('.video-box'); 
        const videoBox = $(this).find('.video-box video'); 
        const movieId = $(this).data('movie-id'); // Get the data-movie-id attribute value
        
        // Start a timeout for 2 seconds
        hoverTimeout = setTimeout(() => {
            videoBoxhover.css('display', 'block'); 

            if (videoBox.length) {
                // Make an AJAX call to fetch the video URL
                $.ajax({
                    url: getVideoDetailsUrl, // Generates the correct URL for the named route
                    method: 'GET',
                    data: { movieId: movieId },
                    success: function (response) {
                        const videoSrc = response.videoUrl; // Assuming server returns videoUrl in JSON
                        videoBox.attr('src', videoSrc); 
                        videoBox[0].play(); // Play video
                    },
                    error: function () {
                        console.error('Failed to fetch video URL');
                    }
                });
            }
        }, 1000); // 2-second delay
    },
    function () {
        // Clear the timeout if the mouse leaves before 2 seconds
        clearTimeout(hoverTimeout);

        const videoBoxhover = $(this).find('.video-box'); 
        const videoBox = $(this).find('.video-box video'); 
        if (videoBox.length) {
            videoBox[0].pause(); 
            videoBox.attr('src', ''); 
        }
        videoBoxhover.css('display', 'none');
    }
);





    // backup
//  $('.video-and-image-block').hover(
//     // dealy with 3 seconds
//     function () {
//         const videoBoxhover = $(this).find('.video-box'); 
//         const videoBox = $(this).find('.video-box video'); 
//         const videoSrc = "{{ asset('trailer/10665530-uhd_4096_2160_25fps.mp4') }}";
//         videoBoxhover.css('display', 'block'); 
//         if (videoBox.length) {
//             videoBox.attr('src', videoSrc); 
//             videoBox[0].play(); // Play video
//         }
//     },
//     function () {
//         const videoBoxhover = $(this).find('.video-box'); 
//         const videoBox = $(this).find('.video-box video'); 
//         if (videoBox.length) {
//             videoBox[0].pause(); 
//             videoBox.attr('src', ''); 
//         }
//         videoBoxhover.css('display', 'none');
//     }
// );


// new




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