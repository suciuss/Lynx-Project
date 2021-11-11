@extends('layouts.app')

@section('styles')
    <style>
        .show{
            display: block;
        }

        .btn {
            background-color: DodgerBlue; /* Blue background */
            border: none; /* Remove borders */
            color: white; /* White text */
            padding: 12px 16px; /* Some padding */
            font-size: 16px; /* Set a font size */
            cursor: pointer; /* Mouse pointer on hover */
        }

        /* Darker background on mouse-over */
        .btn:hover {
            background-color: RoyalBlue;
        }

        #searchTable {
            background-image: url('https://www.w3schools.com/css/searchicon.png');
            background-position: 10px 10px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }
    </style>
@endsection

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
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div>
                        <input type="text" id="searchTable" name="searchTable" placeholder="Search for users.." title="Type in a name" style="margin-bottom: 20px">
                    </div>

                    <table class="table table-light" id="myTable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col"><center>User ID</center></th>
                            <th scope="col"><center>Name</center></th>
                            <th scope="col"><center>Email</center></th>
                            <th scope="col"><center>Phone Number</center></th>
                            <th scope="col"><center>Actions</center></th>
                            <th scope="col"><center>Is Verified</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <th scope="row">#{{$user->id}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone_number}}</td>
                            <td>
                                <a href="/edit-user-view/{{$user->id}}" class="btn btn-primary" title="Edit">
                                    Edit
                                </a>
                                <button type="button" class="btn btn-danger delete" data-id="{{$user->id}}">Delete</button>
                                <button type="button" class="btn btn-warning unverify" data-id="{{$user->id}}">Unverify</button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
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
        $(document).ready(function(){

            fetch_customer_data();

            function fetch_customer_data(query = '')
            {
                $.ajax({
                    url:"{{ route('search') }}",
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        $('tbody').html(data.table_data);
                        $('#total_records').text(data.total_data);
                    }
                })
            }

            $(document).on('keyup', '#searchTable', function(){
                var query = $(this).val();
                fetch_customer_data(query);
            });
        });
    </script>

    <script>
        $(document).on('click','.delete',function(){
            var element = $(this);
            var del_id = element.attr("data-id");
            var info = del_id;
            if(confirm("Are you sure you want to delete this?"))
            {
                $.ajax({
                    type: "POST",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/delete-user",
                    data: info,
                    success: function(){

                    }
                });
                $(this).parents("tr").animate({ backgroundColor: "#003" }, "slow")
                    .animate({ opacity: "hide" }, "slow");
            }
            return false;
        });

        $(document).on('click','.unverify',function(){
            var element = $(this);
            var del_id = element.attr("data-id");
            var info = del_id;
            if(confirm("Are you sure you want to unverify this?"))
            {
                $.ajax({
                    type: "POST",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/unverify-user",
                    data: info,
                    success: function () {

                    },
                    error: function () {

                    },
                    complete: function () {
                        $.ajax({
                            url:"{{ route('search') }}",
                            method:'GET',
                            data:{query:''},
                            dataType:'json',
                            success:function(data)
                            {
                                $('tbody').html(data.table_data);
                                $('#total_records').text(data.total_data);
                            }
                        })
                    }
                });
            }
            return false;
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
