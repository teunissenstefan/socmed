<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @auth
            @if($totalNotifications>0)
                ({{$totalNotifications}})
            @endif
        @endauth
        @yield('pageTitle') - {{ config('app.name', 'SocMed') }}
    </title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
    <!--script src="{{ asset('js/app.js') }}" defer></script-->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
    <!--link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"-->
</head>
<body>
    <div id="app">
        <nav class="navbar fixed-top navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <form class="form-inline"method="post" action="{{route('processSearchForm')}}">
                                <input class="form-control mr-sm-2" name="searchQuery" value="@if(isset($searchQuery)){{$searchQuery}}@endif" type="search" placeholder="Search people" aria-label="Search">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        @endif
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('messages.index') }}">{{ __('Messages') }}
                                        <span class="badge badge-primary @if($countMessagesForMe) @else d-none @endif" id="unreadMessageCountBadge">{{$countMessagesForMe}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('friends.show') }}">{{ __('Friends') }}
                                        <span class="badge badge-primary @if($countFriendRequestsForMe) @else d-none @endif" id="friendRequestsForMeBadge">{{$countFriendRequestsForMe}}</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('profile', ['id' => Auth::user()->id])}}">
                                        {{ __('My profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4"><br/><br/>
            @yield('content')
        </main>

    </div>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Confirm delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>You are about to delete one record, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {{ Form::open(array('url' => '/', 'class' => 'pull-right delform')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-ok')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-delete-comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Delete comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>You are about to delete one comment, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" id="deleteCommentButton" class="btn btn-danger pull-right">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-unfriend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Confirm unfriend</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>You are about to unfriend this person.</p>
                    <p>Do you want to proceed?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {{ Form::open(array('url' => '/', 'class' => 'pull-right unfriendform')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Unfriend', array('class' => 'btn btn-danger btn-ok')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        @auth
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.delform').attr('action', $(e.relatedTarget).data('href'));
        });

        if (("Notification" in window)) {
            if (Notification.permission !== 'denied' && Notification.permission !=='granted') {
                Notification.requestPermission();
            }
            var oldrequests = {{$countFriendRequestsForMe}};
            var oldmessagecount = {{$countMessagesForMe}};
            var check10 = setInterval(function () {
                $.ajax({
                    type:'GET',
                    url: '{{route('friends.count')}}',
                    cache: false,
                    success: function(html){
                        var newrequests = Number(html);
                        if(newrequests>oldrequests){
                            Notify("You have new friend requests!");
                            $('#friendRequestsForMeBadge').removeClass("d-none");
                            $('#friendRequestsForMeBadge').html(newrequests);
                        }
                        oldrequests = newrequests;
                    }
                });
                $.ajax({
                    type:'GET',
                    url: '{{route('messages.count')}}',
                    cache: false,
                    success: function(html){
                        var newmessagecount = Number(html);
                        if(newmessagecount>oldmessagecount){
                            Notify("You have new messages!");
                            $('#unreadMessageCountBadge').removeClass("d-none");
                            $('#unreadMessageCountBadge').html(newmessagecount);
                        }
                        oldmessagecount = newmessagecount;
                    }
                });
            }, 10000);
        }
        function Notify(msg){
            if (Notification.permission !== 'denied' && Notification.permission !=='granted') {
                Notification.requestPermission();
            }else if(Notification.permission =='granted'){
                var notification = new Notification(msg);
            }
        }

        //  Post Comment
        function PostComment(formelement,statusid,sendurl){
            $.ajax({
                type:'POST',
                url: sendurl,
                data: formelement.serialize(),
                cache: false,
                success: function(html){
                    // Insert new comment after the form
                    $("#comments"+statusid+" > li:nth-child(1)").after(html);
                    formelement.find('input:text').val('');
                }
            });
        }

        //  Delete Comment
        $('#confirm-delete-comment').on('show.bs.modal', function(e) {
            $(this).find('#deleteCommentButton').attr('onclick', 'DeleteComment("'+$(e.relatedTarget).data('href')+'","'+$(e.relatedTarget).attr('data-id')+'");');
        });
        function DeleteComment(sendurl,id){
            $.ajax({
                type:'GET',
                url: sendurl,
                cache: false,
                success: function(html){
                    $('#'+id).remove();
                    $('#confirm-delete-comment').modal('hide');
                }
            });
        }

        var check60 = setInterval(function () {
            $.get("{{route('stillonline')}}");

        }, 60000);

        $('#confirm-unfriend').on('show.bs.modal', function(e) {
            $(this).find('.unfriendform').attr('action', $(e.relatedTarget).data('href'));
        });
        @endif
    </script>
</body>
</html>
