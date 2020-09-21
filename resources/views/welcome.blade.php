<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart - Fligno</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
     input,
        .StripeElement {
          height: 40px;
          padding: 10px 12px;

          color: #32325d;
          background-color: white;
          border: 1px solid transparent;
          border-radius: 4px;

          box-shadow: 0 1px 3px 0 #e6ebf1;
          -webkit-transition: box-shadow 150ms ease;
          transition: box-shadow 150ms ease;
        }

        input:focus,
        .StripeElement--focus {
          box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
          border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
          background-color: #fefde5 !important;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  </head>
  <body>
    <div id="app">
      @php
          $admin = App\Models\User::where('role','admin')->first();
      @endphp
      <landing-page></landing-page>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
   
  </body>
</html>