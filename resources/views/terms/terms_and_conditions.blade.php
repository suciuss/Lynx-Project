@extends('layouts.app')


@section('content')
    @if($currentUser->accepted_terms_id != $latestTerms->id)
        <div style="background-color: #ffc7c7; width: 100%; height: 50px; margin-top: -23px; margin-bottom: 20px">
            <center><p style="padding-top: 7px">You haven't accepted our latest <a href="{{route('terms')}}">Terms and Conditions</a> You can <button class="btn btn-primary accept" data-user-id="{{$currentUser->id}}">Accept</button> them now. These are the <a href="{{route('acceptedTerms')}}">Terms and Conditions</a> that you aceepted. </p></center>
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; align-content: space-between; justify-content: space-between;">
                        <div>
                            {{ __('Terms and Conditions') }}
                        </div>
                        <div>
                            <a href="/create-terms-view" class="btn btn-primary">Add new Terms</a>
                        </div>
                    </div>

                    <div class="card-body">
                            @foreach($terms as $term)
                                <div>
                                    <h1>{{$term->name}}</h1>
                                </div>
                                <br>
                                <p>{{$term->content}}</p>
                                @if($term->publication_date == null)
                                <div style="display: flex">
                                    <div>
                                        <form action="{{route('publishTerms', $term->id)}}" method="POST">
                                            @csrf
                                            <b>Unpublished</b>
                                            <button class="btn btn-primary" style="margin-left: 20px" type="submit">Publish Now</button>
                                        </form>
                                    </div>
                                    <div>
                                        <a href="{{route('editTermsView', ['termsId' => $term->id])}}" class="btn btn-secondary" style="margin-left: 20px">Edit</a>
                                    </div>
                                    <div>
                                        <form action="{{route('deleteTerms', $term->id)}}" method="POST">
                                            @csrf
                                            <button class="btn btn-danger" style="margin-left: 20px" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </div>
                                @else
                                <b>Published at: {{$term->publication_date}}</b>
                                @endif
                                <hr>
                            @endforeach
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
