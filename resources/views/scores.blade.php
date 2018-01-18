@extends('layouts.app')
<link rel="stylesheet" href="/css/master.css">
@section('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
      <div class="custom-control custom-checkbox">
                   <input type="checkbox" class="custom-control-input" id="customCheck1" checked="">
                   <label class="custom-control-label" for="customCheck1">Check this custom checkbox</label>
                 </div>
                 <div class="panel-body">

                     <div class="box-body no-padding">
                       <table class="table table-striped">
                         <thead>
                             <th>Quiz Name</th>
                             <th>Number Of Passes</th>
                             <th>&nbsp;</th>
                         </thead>
                         <tbody>

                           @foreach ($quizes as $quiz)
                               <tr>
                                   <th class="table-text"><a href="{{ url('/quiz/passes/'.$quiz["quiz_id"]) }}"><?php  echo $quiz["name"];  ?></a></th>
                                   <th class="table-text"><?php  echo $quiz["quiz_count"];  ?></th>
                                   <!-- Task Delete Button -->
                                   <th class="col-md-3">
                                     <button type="button" class="btn btn-block btn-info">
                                         <a href="{{ url('/quiz/passes/'.$quiz["quiz_id"]) }}">More Details</a>
                                     </button>
                                   </th>
                               </tr>
                           @endforeach
                         </tbody>
                       </table>
                     </div>
                 </div>
    </div>
</div>
@endsection
