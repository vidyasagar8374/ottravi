<?php

namespace Modules\Frontend\app\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Razorpay\Api\Api;
use App\Models\Movie;
use App\Models\HomeCategoryMovie;
use App\Models\HomeCategory;
use App\Models\UserPurchaseMovie;
use App\Models\ottdataList;
use App\Models\ottList;
use App\Models\videoTracking;
use App\Models\Payment;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;



class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //main pages
    public function index()
    {
        $banners = Banner::where('is_active', 1)->get();
        $upcomings = Movie::get();
        $moviescategories = HomeCategory::with('categoryname.movie')->get();
        if(auth()->user()){
            $continuewatches = videoTracking::with('moviedata')
            ->join('user_purchase_movies', 'user_purchase_movies.movie_id', '=', 'video_trackings.movie_id') // Correct the table name
            ->where('user_purchase_movies.user_id', auth()->user()->id)
            ->where('user_purchase_movies.is_watched', 0)
            ->where('user_purchase_movies.is_active', 1)
            ->get();   
        }else{
            $continuewatches = [];
        }
        
        // dd($continuewatches);
        return view('frontend::Pages.MainPages.index-page',compact('banners','upcomings','moviescategories','continuewatches'));
        
        
    }
    public function getVideoDetails(Request $request)
{

    $movieId = Crypt::decrypt($request->movieId);
    //  dd($movieId);
    $movie = Movie::find($movieId);

    if ($movie) {
        return response()->json([
            'videoUrl' => asset($movie->triallerurl),
            'title' => $movie->title,
            // Add any additional data you need here
        ]);
    }

    return response()->json(['error' => 'Movie not found.'], 404);
}
public function updateplaytrack(Request $request)
{
    // dd($request->all());
      // Decrypt the movie ID
        // $movieId = Crypt::decrypt($request->movie_id);
        try {
            videoTracking::where('movie_id', $request->movie_id)
            ->where('user_id', auth()->user()->id)
            ->update([
                'paused_length' => $request->current_time,
                'total_length' => $request->total_length,
            ]);
                UserPurchaseMovie::where('movie_id', $request->movie_id)
                ->where('user_id', auth()->user()->id)
                ->whereNull('after_expire')
                ->orderBy('created_at', 'desc') // Ensure you're ordering by the latest record
                ->limit(1) // Optional: limit to only 1 record if necessary
                ->update([
                    'after_expire' => Carbon::now()->addDays(2)
                ]);
            
        
            return response()->json([
                'success' => true,
                'message' => $movie->wasRecentlyCreated 
                    ? 'Playback details created successfully.' 
                    : 'Playback details updated successfully.',
            ], 200);
        
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating or creating playback details.',
                'error' => $e->getMessage(),
            ], 500);
        }
        
}

// public function store(Request $request)
// {
//     $input = $request->all();
    
//     // Check if Razorpay payment ID is provided
//     if (empty($input['razorpay_payment_id'])) {
//         Session::put('error', 'Payment ID is missing.');
//         return redirect()->back();
//     }

//     $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

//     try {
//         // Start database transaction
//         DB::beginTransaction();

//         $payment = $api->payment->fetch($input['razorpay_payment_id']);
//         $movieId = $payment->notes['movie_id'];
//         // dd($movieId);
//         $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));

//         $paymentRecord = Payment::create([
//             'r_payment_id' => $response['id'],
//             'method' => $response['method'],
//             'currency' => $response['currency'],
//             'user_email' => $response['email'],
//             'amount' => $response['amount'] / 100, 
//             'json_response' => json_encode((array) $response)
//         ]);
       
//     //    dd($paymentRecord_id);

//         if (!$paymentRecord) {
//             throw new \Exception('Failed to save payment record.');
//         }

//         $movie = Movie::find($movieId);
//         if (!$movie) {
//             throw new \Exception('Movie not found.');
//         }
//         $paymentRecord_id = $paymentRecord->id;
//         $insertpurchase = UserPurchaseMovie::create([
//             'user_id' => auth()->user()->id,
//             'movie_id' => $movie->id,
//             'ticket_id' => $paymentRecord_id,
//             'is_active' => 1,
//             'purchase_date' => Carbon::now(), // Current date and time
//             'expire_date' => Carbon::now()->addDays(env('PURCHASE_EXPIRY_DAYS')), // One month from now
//             'is_watched' => 0
//         ]);
//         // dd($insertpurchase);
//         if (!$insertpurchase) {
//             throw new \Exception('Failed to create movie purchase.');
//         }


//         DB::commit();

//         // Success message
      
//         return redirect()->back()->with('success', 'Payment successful!');

//     } catch (\Exception $e) {
//         // Rollback the transaction if any exception occurs
//         DB::rollBack();
//         Session::put('error', $e->getMessage());
//         return redirect()->back();
//     }
// }

public function store(Request $request)
{
    $razorpay_id = $request->razorpay_payment_id;
    // dd($razorpay_id);
    $movie_id = $request->movie_id;

    if (!empty($razorpay_id)) {
        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $payment = $api->payment->fetch($razorpay_id);

            $paymentRecord = Payment::create([
                'r_payment_id' => $payment['id'],
                'method' => $payment['method'],
                'currency' => $payment['currency'],
                'user_email' => $payment['email'],  
                'amount' => $payment['amount'] / 100,  
                'json_response' => json_encode((array) $payment)
            ]);
            if ($paymentRecord) {
                $paymentRecord_id = $paymentRecord->id;
                        $insertpurchase = UserPurchaseMovie::create([
                            'user_id' => auth()->user()->id,
                            'movie_id' => $movie_id,
                            'ticket_id' => $paymentRecord_id,
                            'is_active' => 1,
                            'purchase_date' => Carbon::now(), // Current date and time
                            'expire_date' => Carbon::now()->addDays(env('PURCHASE_EXPIRY_DAYS')), // One month from now
                            'is_watched' => 0
                        ]);
                        // create videoTracking record
                        $videoTracking = videoTracking::create([
                            'user_id' => auth()->user()->id,
                            'movie_id' => $movie_id,
                            'paused_length' => 0,
                            'total_length' => 0,
                        ]);
                }

            return response()->json(['success' => true]);
            // // session()->flash('success', 'Contact form submitted successfully!');
            // return redirect()->view('frontend.single-temple');

        } catch (\Exception $e) {
           
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        return response()->json(['success' => false, 'message' => 'Payment ID or signature is missing.']);
    }
}



    public function ott()
    {
        return view('frontend::Pages.MainPages.ott-page');
    }

    public function movie()
    {
        return view('frontend::Pages.MainPages.movies-page');
    }

    public function tv_show()
    {
        return view('frontend::Pages.MainPages.tv-shows-page');
    }

    public function video()
    {
        return view('frontend::Pages.MainPages.videos-Page');
    }

    public function merchandise()
    {
        return view('frontend::Pages.MainPages.merchandise-page');
    }

    //movies pages
    public function resticted()
    {
        return view('frontend::Pages.Movies.resticted-page');
    }

    public function releted_merchandies()
    {
        return view('frontend::Pages.Movies.releted-merchandies-page');
    }

    //deatil pages
    public function movie_detail(Request $request)
    {
        // dd($request->id);
        $movieId = $request->id;
        try {
            $id = Crypt::decrypt($movieId);
            $movie = Movie::findOrFail($id);
            if($movie){

                $ottdetails = Movie::with('ottdetails.ott')->where('id',$id)->get();
                //  dd($ottdetails);
                if(auth()->check()){
                    $userpurchasedetailsQuery = videoTracking::with('moviedata')
                    ->join('user_purchase_movies', 'user_purchase_movies.movie_id', '=', 'video_trackings.movie_id')
                    ->where('user_purchase_movies.user_id', auth()->user()->id)
                    ->where('user_purchase_movies.movie_id', $id)
                    ->where('user_purchase_movies.is_watched', 0)
                    ->where('user_purchase_movies.is_active', 1)
                    ->where(function ($query) {
                        $query->where(function ($subQuery) {
                            // Check if `after_expire` is NULL and compare `expire_date`
                            $subQuery->whereNull('user_purchase_movies.after_expire')
                                    ->where('user_purchase_movies.expire_date', '>=', Carbon::now());
                        })
                        ->orWhere(function ($subQuery) {
                            // Check if `after_expire` is NOT NULL and compare `after_expire`
                            $subQuery->whereNotNull('user_purchase_movies.after_expire')
                                    ->where('user_purchase_movies.after_expire', '>=', Carbon::now());
                        });
                    });
                $userpurchasedetails = $userpurchasedetailsQuery->first();
                } else{
                    $userpurchasedetails = [];
                   
    
                }
           
                   
                 }
                else{
                $userpurchasedetails = [];
                $ottdetails = [];

            }
            /* 
                SELECT * 
                    FROM video_trackings as vt 
                    INNER JOIN user_purchase_movies as up 
                    ON vt.movie_id = up.movie_id 
                    AND vt.user_id = up.user_id 
                    WHERE up.is_watched = 0 
                    AND up.is_active = 1 
                    AND (
                        (up.after_expire IS NULL AND up.expire_date >= ?) 
                        OR 
                        (up.after_expire IS NOT NULL AND up.after_expire >= ?)
                    );

            
            */
            return view('frontend::Pages.Movies.detail-page',compact('movie','userpurchasedetails','ottdetails'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Handle the case where decryption fails (invalid or tampered data)
            abort(404, 'Invalid movie ID');
        }

    }
    public function initiate_payment(Request $request)
    {
         // dd($request->id);
         $movieId = $request->id;
         try {
             // Decrypt the ID
             $id = Crypt::decrypt($movieId);
             $movie = Movie::findOrFail($id);
             $ottdetails = '';
             if($movie){
                 $ottdetails = Movie::with('ottdetails.ott')->where('id',$id)->get();
                 //  dd($ottdetails);
             }
             $userpurchasedetails = UserPurchaseMovie::get();
             
             return view('frontend::Pages.Movies.initiate-payment',compact('movie','userpurchasedetails','ottdetails'));
         } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
             // Handle the case where decryption fails (invalid or tampered data)
             abort(404, 'Invalid movie ID');
         }
    }

    public function tvshow_detail()
    {
        return view('frontend::Pages.TvShows.detail-page');
    }

    public function episode()
    {
        return view('frontend::Pages.TvShows.episode-page');
    }

    public function video_detail()
    {
        return view('frontend::Pages.videos-detail');
    }

    public function product_detail()
    {
        return view('frontend::Pages.product-detail');
    }

    public function watchlist_detail()
    {
        return view('frontend::Pages.watchlist-detail');
    }

    public function view_all()
    {
        return view('frontend::Pages.view-all');
    }

    // Genres Pages Routes
    public function genres()
    {
        return view('frontend::Pages.geners-page');
    }

    public function all_genres()
    {
        return view('frontend::Pages.all-geners-page');
    }

    // tag Pages Routes
    public function tag()
    {
        return view('frontend::Pages.tags-page');
    }

    // cast Pages Routes
    public function cast_details()
    {
        return view('frontend::Pages.Cast.detail-page');
    }

    public function cast_list()
    {
        return view('frontend::Pages.Cast.list-page');
    }

    public function all_personality()
    {
        return view('frontend::Pages.Cast.all-personality');
    }

    // playlist Pages Routes
    public function play_list()
    {
        return view('frontend::Pages.playlist');
    }

    // Extra Pages
    public function about_us()
    {
        return view('frontend::Pages.ExtraPages.about-page');
    }

    public function contact_us()
    {
        return view('frontend::Pages.ExtraPages.contact-page');
    }

    public function faq_page()
    {
        return view('frontend::Pages.ExtraPages.faq-page');
    }

    public function privacy()
    {
        return view('frontend::Pages.ExtraPages.privacy-policy-page');
    }

    public function terms_and_policy()
    {
        return view('frontend::Pages.ExtraPages.terms-of-use-page');
    }

    public function comming_soon_page()
    {
        return view('frontend::Pages.ExtraPages.comming-soon-page');
    }

    public function pricing_page()
    {
        return view('frontend::Pages.pricing-page');
    }

    public function error_page1()
    {
        return view('frontend::Pages.ExtraPages.error-page1');
    }

    public function error_page2()
    {
        return view('frontend::Pages.ExtraPages.error-page2');
    }

    // Blog Pages
    public function blog_list_page()
    {
        return view('frontend::Pages.Blog.list-page');
    }

    public function blog_filter()
    {
        return view('frontend::Pages.Blog.blog-filter');
    }

    public function blog_detail_page()
    {
        return view('frontend::Pages.Blog.detail-page');
    }

    public function blog_grid_list()
    {
        return view('frontend::Pages.Blog.grid-list');
    }

    public function blog_right_sidebar()
    {
        return view('frontend::Pages.Blog.right-sidebar');
    }

    public function blog_sidebar_list_page()
    {
        return view('frontend::Pages.Blog.sidebar-list-page');
    }

    public function blog_category()
    {
        return view('frontend::Pages.Blog.blog-category');
    }

    public function blog_tag()
    {
        return view('frontend::Pages.Blog.blog-tag');
    }

    public function blog_date()
    {
        return view('frontend::Pages.Blog.blog-date');
    }

    public function blog_author()
    {
        return view('frontend::Pages.Blog.blog-author');
    }

    // Blog column
    public function blog_column_grid($grid)
    {
        $gridClasses = '';
        $title = 'Blogs';
        switch ($grid) {
            case 'one-column':
                $gridClasses = 'row-cols-lg-1 row-cols-md-1';
                $title = __('frontendheader.1_column_blog');
                break;

            case 'two-column':
                $gridClasses = 'row-cols-lg-2 row-cols-md-2';
                $title =__('frontendheader.2_column_blog');
                break;

            case 'three-column':
                $gridClasses = 'row-cols-lg-3 row-cols-md-3';
                $title = __('frontendheader.3_column_blog');
                break;

            case 'four-column':
                $gridClasses = 'row row-cols-lg-4 row-cols-md-2 row-cols-1';
                $title = __('frontendheader.4_column_blog');
                break;

            default:
                // code...
                break;
        }

        return view('frontend::Pages.Blog.one-column', compact('gridClasses', 'title'));
    }

    //Blog sidebar
    public function blog_left_sidebar()
    {
        return view('frontend::Pages.Blog.left-sidebar');
    }

    public function blog_template()
    {
        return view('frontend::Pages.Blog.blog-template');
    }

    public function detail_page()
    {
        return view('frontend::Pages.Blog.detail-page');
    }

    public function blog_audio()
    {
        return view('frontend::Pages.Blog.blog-audio');
    }

    public function blog_video()
    {
        return view('frontend::Pages.Blog.blog-video');
    }

    public function blog_link()
    {
        return view('frontend::Pages.Blog.blog-link');
    }

    public function blog_quote()
    {
        return view('frontend::Pages.Blog.blog-quote');
    }

    public function blog_gallery()
    {
        return view('frontend::Pages.Blog.blog-gallery');
    }

    //shop pages
    public function all_products()
    {
        return view('frontend::Pages.MerchandiseShopPages.all-product-page');
    }

    public function shop()
    {
        return view('frontend::Pages.MerchandiseShopPages.shop-page');
    }

    public function my_account()
    {
        if(auth()->user()){
            $user = auth()->user();
          
            $purchasemovies = UserPurchaseMovie::with('moviedata')->where('user_id', $user->id)->get();
            // dd($purchasemovies);
        }else{
            // dd($user);
            $user = null;
            $purchasemovies = [];
        }

        // dd($user);
        return view('frontend::Pages.MerchandiseShopPages.my-account-page',compact('user','purchasemovies'));
    }

    public function cart()
    {
        return view('frontend::Pages.MerchandiseShopPages.cart-page');
    }

    public function wishlist()
    {
        return view('frontend::Pages.MerchandiseShopPages.wishlist-page');
    }

    public function chekout()
    {
        return view('frontend::Pages.MerchandiseShopPages.chekout-page');
    }

    public function order_tracking()
    {
        return view('frontend::Pages.MerchandiseShopPages.order-tracking');
    }
}
