@extends('layout.auth')  
@section('title', 'Login') 
@section('content')

<div class="">
  <div class="row">
    <div class="col-md-6 p-0 d-flex align-items-center justify-content-center" style="height: 100vh;">
      <div class="w-75">
        <div class="text-center mb-4">
          <img src="assets/img/GDeBookLogo2.png" alt="Logo GDeBook" style="max-width: 160px;">
          <h4 class="sub-title-color font-playfair">LOGIN</h4>
        </div>

        <form method="POST" action="login">
          @csrf

          <x-input-text name="email" label="Email" type="email" placeholder="Enter your email" />
          <x-input-text name="password" label="Password" type="password" placeholder="Enter your password" />

          <div class="mt-4">
            <button type="submit" class="btn btn-theme w-100 font-playfair" style="height: 56px;">Login</button>
          </div>

          <div class="text-center mt-3">
            <span class="sub-title-color font-playfair">Don't have an account? </span>
            <a href="{{ url('/register') }}" class="sub-title-color font-playfair">Register</a>
          </div>
        </form>
      </div>
    </div>

    <div class="col-md-6 p-0 d-none d-lg-block">
      <div style="height: 100vh; width: 100%; overflow: hidden;">
        <img src="assets/img/foto-login.jpg" alt="Library" style="width: 100%; height: 100%; object-fit: cover;">
      </div>
    </div>
  </div>
</div>

@endsection
