@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="panel-body">
                <div class="box-body no-padding">
                  @if(isset($details))
                      <p> The Search results for your query <b> {{ $query }} </b> are :</p>
                  <table class="table table-striped">
                    <thead>
                      <th>User Name</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                    </thead>
                    <tbody>
                      @foreach($details as $user)
                      <tr>
                          <th class="table-text">{{$user->name}}</th>
                          <th class="table-text">{{$user->first_name}}</th>
                          <th class="table-text">{{$user->last_name}}</th>
                          <th class="table-text">{{$user->email}}</th>
                          <th class="table-text">{{$user->phone}}</th>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @endif
                  @if(isset($message))
                    <h2>{{$message}}</h2>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
