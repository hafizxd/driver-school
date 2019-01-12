@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{--<div class="card">
                <div class="card-header">
                  <h1>User</h1>
                </div>
            </div>--}}
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                  {{--<div class="row">
                    @foreach($user as $users)
                      <div class="col-md-4 text-center">
                        <div class="card card-body" style="padding:0;">
                          @if(empty($users->profile_img))
                            <img class="img-thumbnail" src="" alt="" style="margin-bottom:10px;border:0;">
                          @else
                            <img class="img-thumbnail" src="{{asset('storage/blog/' . $users->profile_img)}}" alt="" style="border:0;;margin-bottom:10px;">
                          @endif
                          <a style="text-decoration:none;" href="user/{{$users->id}}"><h6>{{ $users-> name }}</h6></a>
                        </div>
                      </div>
                    @endforeach
                  </div>--}}

                  <div class="card-columns">
                    @foreach($user as $users)
                      <div class="card">
                        {{--<img class="card-img-top" src="{{asset('storage/blog/' . $users->profile_img)}}">--}}
                        <div class="card-body">
                            @if(empty($users->profile_img))
                              <img class="img-thumbnail" src="" alt="" style="margin-bottom:10px;border:0;">
                            @else
                              <img class="img-thumbnail" src="{{asset('storage/blog/' . $users->profile_img)}}" alt="" style="border:0;;margin-bottom:10px;">
                            @endif
                            <h5 class="card-title"><a href="user/{{$users->id}}">{{ $users-> name }}</a></h5>
                        </div>
                      </div>
                    @endforeach
                  </div>

            </div>
        </div>
    </div>
</div>
@endsection
