@extends('layouts.app')

@section('content')


  <section class="hero has-text-centered">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          Reset Password
        </h1>
      </div>
    </div>
  </section>

  <div class="columns is-marginless is-centered">
    <div class="column is-6">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">Reset Password</p>
        </header>

        <div class="card-content">
          @if (session('status'))
            <div class="notification">
              {{ session('status') }}
            </div>
          @endif

          <form class="forgot-password-form" method="POST" action="{{ route('password.email') }}">

            @csrf()

            <div class="field is-horizontal">
              <div class="field-label is-normal">
                <label class="label">E-Mail</label>
              </div>

              <div class="field-body">
                <div class="field">
                  <p class="control">
                    <input class="input" id="email" type="email" name="email"
                           value="{{ old('email') }}" required autofocus>
                  </p>

                  @if ($errors->has('email'))
                    <p class="help is-danger">
                      {{ $errors->first('email') }}
                    </p>
                  @endif
                </div>
              </div>
            </div>

            <div class="field is-horizontal">
              <div class="field-label is-normal"></div>

              <div class="field-body">
                <div class="field is-grouped">
                  <div class="control">
                    <button type="submit" class="button is-info">Send Password Reset Link
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
