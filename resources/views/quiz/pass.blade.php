@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
                 <div class="panel-body">
                     <div class="box-body no-padding">
                       <table class="table table-striped">
                         <thead>
                             <th>User Name</th>
                             <th>Score</th>
                         </thead>
                         <tbody>

                           @foreach ($users as $user)
                               <tr>
                                   <th class="table-text"><?php  echo $user["name"];  ?></th>
                                   <th class="table-text"><?php  echo $user["score"];  ?></th>
                               </tr>
                           @endforeach
                         </tbody>
                       </table>
                     </div>
                 </div>
    </div>
</div>
@endsection
