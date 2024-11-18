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
                        <h4>Payment Gateway</h4>
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
                            <form action="{{ route('razorpay.payment.store') }}" method="POST">
                                @csrf
                                <script
                                    src="https://checkout.razorpay.com/v1/checkout.js"
                                    data-key="{{ env('RAZORPAY_KEY') }}"
                                    data-amount="{{ $movie->price }} * 100"
                                    data-buttontext="Pay Now"
                                    data-name="GeekyAnts Official"
                                    data-description="Razorpay payment"
                                    data-image="{{ asset('movieslist/p.logo.jpeg') }}"
                                    data-prefill.name="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"
                                    data-prefill.email="{{ Auth::user()->email }}"
                                    data-theme.color="#ff7529"
                                    data-notes.movie_id="{{ $movie->id }}"
                                ></script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection

