@extends('frontend::layouts.master', ['isSwiperSlider' => true, 'isVideoJs' => true, 'bodyClass' => 'custom-header-relative', 'isSelect2' => true]) @section('content')
<style>
    .card {
        margin-top: 50px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    .btn-pay {
        background-color: #ff7529;
        color: #fff;
        border: none;
    }
    .btn-pay:hover {
        background-color: #e66721;
    }
    .company-logo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 10px;
    }
    .content-wrapper-payment {
        margin-left: 140px !important; /* Adjust this value for more or less space */
    }

    .table {
        margin-bottom: 20px; /* Add space between table and form */
    }
</style>



    <div class="container pb-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Success Message -->
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Payment Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('movieslist/p.logo.jpeg') }}" alt="Company Logo" class="company-logo" />
                            <h5 class="mb-3">P19</h5>
                            <p class="text-muted">Entertine world</p>
                        </div>
                        <div class="content-wrapper-payment">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td><strong>Movie Name:</strong></td><td>{{ $movie->title }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Amount:</strong></td>
                                        <td>{{ $movie->price }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Customer Name:</strong></td>
                                        <td>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ Auth::user()->email }}</td>
                                    </tr>
                                </tbody>
                                        
                            </table>
                           

                        </div>
                        <div class="details-form-btn">
                                <button type="button" class="formbtn btn btn-primary w-100">Pay Now</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="movie_id" value="{{ Crypt::encrypt($movie->id) }}">

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    // Pay Now button click event
    // commit changes
    document.querySelector('.formbtn').addEventListener('click', function(e) {
        
        encrptmovieId = document.getElementById('movie_id').value;
        e.preventDefault();

        var options = {
            "key": "{{ env('RAZORPAY_KEY') }}",  // Razorpay key
            "amount": {{ $movie->price * 100 }}, // Amount in paise
            "currency": "INR",
            "name": "P19",
            "description": "P19",
            "image": "{{ asset('movieslist/p.logo.jpeg') }}", // Image URL
            "prefill": {
                "name": "{{ Auth::user()->first_name }}", // User name
                "email": "{{ Auth::user()->email }}",     // User email
            },
            "notes": {
                "movie_id": "{{ $movie->id }}" // Movie ID
            },
            "theme": {
                "color": "#ff7529"
            },
            "handler": function (response) {
                // AJAX call to store payment details
                $.ajax({
                    url: "{{ route('razorpay.payment.store') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        razorpay_payment_id: response.razorpay_payment_id, // Payment ID
                        movie_id: "{{ $movie->id }}" // Movie ID
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token
                    },
                    success: function(data) {
                        if (data.success) {
                            // return to route
                            window.location.href = "{{ url('/movie-detail/') }}/" + encrptmovieId;  
                        } else {
                            alert('Payment failed: ' + data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.open();
    });
</script>




    @endsection

