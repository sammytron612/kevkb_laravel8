<!doctype html>
<html lang="en">
  <head>
  	<title>KB</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('/css/favicon.png') }}" type="image/x-icon"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
  


    <style>
        .avatar {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-family: sans-serif;
        color: #fff;
        font-weight: bold;
        font-size: 16px;
  }


    </style>
  </head>
  <body>


    <div id="app" class="wrapper d-flex back align-items-stretch">
			<nav class="" id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                    </button>
                </div>
                <div class="p-2 d-flex justify-content-center">
                    @if(Auth::user()->avatar)
                        <div><a href="/profile"><div><img style="width: 52px; height: 52px;" class="rounded-circle" src="/storage/avatars/{{ Auth::user()->avatar }}"></img></div></a></div>
                    @else
                        <div><a href="/profile"><div class="avatar bg-@php echo(Session::get('avatarColour')); @endphp">@php echo(Session::get('avatarI')); @endphp</div></a></div>
                    @endif
                </div>
        <ul class="list-unstyled components mb-5">

            <div class="d-flex justify-content-center mb-2 dropdown">
                @if ($count == 0)
                    <a class="ml-3 btn btn-primary" href="{{ route('notifications.index') }}">Notifications<span class="ml-1 badge badge-light">0</span></a>
                @else
                <button class="btn btn-primary ml-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Notifications<span class="ml-1 badge @if($count < 5) ?
                   badge-light @else badge-danger @endif ">{{ $count }}</span>
                </button>
                @endif
                @if ($count > 0)
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($notifications as $notification)
                        @if($notification->type == "App\Notifications\CommentAdded")
                            <a class="dropdown-item" href="{{ route('notifications.index',$notification->id) }}">
                                <i>A new comment has been added to '{{ $notification['data']['title'] }}' by {{ $notification['data']['author'] }}
                                - {{ $notification->created_at->format('d-m-Y h:i:s') }}
                                </i>
                            </a>
                        @endif
                        @if($notification->type == "App\Notifications\AdminNotification")
                            <a class="dropdown-item" href="{{ route('notifications.index',$notification->id) }}">
                                <i>A Message from KB - {{ $notification->created_at->format('d-m-Y h:i:s') }}
                                </i>
                            </a>
                        @endif
                        @if($notification->type == "App\Notifications\NewArticle")
                            <a class="dropdown-item" href="{{ route('notifications.index',$notification->id) }}">
                                <i>Something new has been added - {{ $notification->created_at->format('d-m-Y h:i:s') }}
                                </i>
                            </a>
                        @endif
                        @if($notification->type == "App\Notifications\ApprovalNotification")
                            <a class="dropdown-item" href="{{ route('notifications.index',$notification->id) }}">
                                <i>An article is pending approval - {{ $notification->created_at->format('d-m-Y h:i:s') }}
                                </i>
                            </a>
                        @endif
                        @if (!$loop->last)
                            <div class="dropdown-divider"></div>
                        @endif
                    @endforeach
                    </div>
                @endif
            </div>

          <li class="active">
            <a href="/home"><span class="fa fa-dashboard mr-3"></span>Dashboard</a>
          </li>

          <li>
              <a href="{{ url('articles_index') }}"><span class="fa fa-newspaper-o mr-3"></span>Articles</a>
          </li>
          <li>
            <a href="{{ route('articles.create') }}"><span class="fa fa-plus mr-3"></span>New Article</a>
          </li>

          @if(Gate::check('stealth') && (Gate::check('isEditor') || Gate::check('isViewer')))
          @else
          <li class="{{ (request()->is('sections*')) ? 'active' : '' }}">
            <a href="{{ route('sections.index') }}"><span class="fa fa-sticky-note mr-3"></span>Sections</a>
          </li>
          @endif

          <li  >
            <a href="{{ route('searches.index') }}"><span class="fa fa-search mr-3"></span>Search</a>
          </li>

          <li>
            <a href="{{ route('settings.index') }}"><span class="fa fa-cog mr-3"></span>Settings</a>
          </li>

          @can('isAdmin')
          <li>
            <a href="{{ route('admin.index') }}"><span class="fa fa-user mr-3"></span>Admin</a>
          </li>
          @endcan
          <li>
            <a href="{{ route('drafts.index') }}"><span class="fa fa-save mr-3"></span>Drafts
                @if (Session::get('count') < 5)
                <span class="badge badge-pill badge-primary ml-2">@php echo(Session::get('count')); @endphp</span>
                @else
                    <span class="badge badge-pill badge-danger ml-2">@php echo(Session::get('count')); @endphp</span>
                @endif
           </a>
         </li>
         
          <li>
            <a href="{{ route('comments.viewComments') }}"><span class="fa fa-comments mr-3"></span>Comments</a>
          </li>


            <li>
            <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"><span class="fa fa-sign-out mr-3"></span>{{ __('Logout') }}</a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>


            </li>
        </ul>

    	</nav>

        <!-- Page Content  -->
            <div  id="content" class="pt-5 p-4">
                @yield('content')
            </div>
		</div>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
   <script>
    $(document).ready(function(){
        //loads when document is ready

        if (document.cookie.indexOf('modal_shown=') >= 0) {
         //do nothing if modal_shown cookie is present
        } else {
          $('#disclaimer').modal('show');  //show modal pop up
          document.cookie = 'modal_shown=seen'; //set cookie modal_shown
          //cookie will expire when browser is closed
        }

        })
    </script>
  </body>
</html>
