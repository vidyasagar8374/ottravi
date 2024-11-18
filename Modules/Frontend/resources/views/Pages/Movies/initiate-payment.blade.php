<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="card card-default">
    <div class="card-header">
        Laravel - Razorpay Payment Gateway Integration
    </div>
    <div class="card-body text-center">
        <form action="{{ route('razorpay.payment.store') }}" method="POST" >
            @csrf 
            <script src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="{{ env('RAZORPAY_KEY') }}"
                    data-amount="10000"
                    data-buttontext="Pay 100 INR"
                    data-name="GeekyAnts official"
                    data-description="Razorpay payment"
                    data-image="https://media.istockphoto.com/id/1188628606/vector/tv-logo-design-inspiration.jpg?s=1024x1024&w=is&k=20&c=UMbAYpKvOQsBr8g98oYpZG8-_RhmZZwq-rme4gK--Lw="
                    data-prefill.name="ABC"
                    data-prefill.email="abc@gmail.com"
                    data-theme.color="#ff7529">
            </script>
        </form>
    </div>
</div> 
</body>
</html>