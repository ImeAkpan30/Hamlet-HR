<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
 
    <form method="POST" action="/subscribe" accept-charset="UTF-8" class="form-horizontal" role="form">
        <div class="row" style="margin-bottom:40px;">
            <div class="col-md-8 col-md-offset-2 ">
                <p>
                    <div>
                        Lagos Eyo Print Tee Shirt
                        ₦ 2,950

                          <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Test Card</h5>
                                <p class="card-text">Card Number: 4123450131001381 <br>
                                    Expiry Date: any date in the future <br>
                                    CVV: 883 <br></p>
                            </div>
                        </div>
                    </div>
                </p>
                <input type="text" class="form-control" name="email" value="otemuyiwa@gmail.com"> {{-- required --}} 
                <input type="text"class="form-control"  name="phone" value="09025614561">
                <input type="number" name="amount" value="800"> {{-- required in kobo --}}
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="currency" value="NGN"> <br/>
                <input type="text" name="duration" value="10" placeholder="How many month"> Duration<br/>
                <input type="text" name="plan_id" value="2" placeholder="PLan id"> plan_id<br/>
                <input type="text" name="user_id" value="50" placeholder="User id"> user_id<br/>
                <input type="hidden" name="metadata"   value="{{ json_encode($array = 
                [   
                    'user_id' => 50,
                    'plan_id' => 1
                ]) }}" > 
                {{-- For other necessary things you want to add to your payload. it is optional though --}}
                <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                {{ csrf_field() }} {{-- works only when using laravel 5.1, 5.2 --}}

                <p>
                    <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
                        <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
                    </button>
                </p>
            </div>
        </div>
    </form>
</body>
</html>

