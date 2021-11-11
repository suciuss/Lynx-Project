@extends('layouts.app')

@section('content')
    @if($currentUser->accepted_terms_id != $latestTerms->id)
        <div style="background-color: #ffc7c7; width: 100%; height: 50px; margin-top: -23px; margin-bottom: 20px">
            <center><p style="padding-top: 7px">You haven't accepted our latest <a href="{{route('terms')}}">Terms and Conditions</a> You can <button class="btn btn-primary accept" data-user-id="{{$currentUser->id}}">Accept</button> them now. These are the <a href="{{route('acceptedTerms')}}">Terms and Conditions</a> that you aceepted. </p></center>
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit User') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('editUser') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email') ??  $user->email }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                                <div class="col-md-6">
                                    <input id="phone_number" type="number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{old('phone_number') ?? $user->phone_number}}" required autocomplete="name" autofocus>

                                    @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="terms_accepted_at" style="float:left; margin: 5px 0px;" class="col-md-4 col-form-label text-md-right">{{ __('Terms And Conditions') }}</label>

                                <div class="col-md-6">
                                    <input style="margin: 5px 0px; width: 40px;" id="terms_accepted_at" type="checkbox" class="form-control @error('name') is-invalid @enderror" name="terms_accepted_at" value="true" required autocomplete="name" autofocus>

                                    @error('terms_accepted_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Edit User') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function (){
            $('#navbarDropdown').click(function () {
                document.getElementById('dropdown-menu-working').classList.toggle('show');
            });
        });
    </script>

    <script>
        $(document).on('click','.accept',function() {
            var element = $(this);
            var user_id = element.attr("data-user-id");
            $.ajax({
                type: "POST",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/accept-new-terms",
                data: user_id,
                success: function () {
                    location.reload();
                },
                error: function () {
                    location.reload();
                },
                complete: function () {
                    location.reload();
                }
            });
        });
    </script>
@endsection
