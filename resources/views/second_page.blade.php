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
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div>You are logged in on the second page</div>
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
