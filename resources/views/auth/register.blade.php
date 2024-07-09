 @extends('layouts.header')

 @section('content')
     <div class="row justify-content-center">
         <div class="col-12 col-sm-8 col-md-6">
             <form class="form mt-5" action="" method="post">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                 <h3 class="text-center text-dark">Register</h3>
                 <div class="form-group">
                    <label for="name" class="text-dark">Name:</label><br>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name">
                 </div>
                 <div class="form-group mt-3">
                    <label for="email" class="text-dark">Email:</label><br>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email address">
                 </div>
                 <div class="form-group mt-3">
                    <label for="password" class="text-dark">Password:</label><br>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Minimum of 8 letters">
                 </div>
                 <div class="form-group mt-3">
                    <label for="confirm-password" class="text-dark">Confirm Password:</label><br>
                    <input type="password" name="password_confirmation" id="confirm-password" class="form-control" placeholder="Enter the password again">
                 </div>
                 <br>
                 <div class="form-group text-center">
                    <input name="submit" class="btn btn-dark btn-md" value="Register" id="submit">
                 </div>
                 <div class="text-right mt-2">
                    <a href="/login" class="text-dark">Login here</a>
                 </div>
             </form>
         </div>
     </div>
 @endsection

 <script src="{{ asset('js/jquery.js') }}"></script>
 <script src="{{ asset('js/register.js') }}"></script>