@extends('layouts.app')

@section('content')
<?php ?>
  <div class="container">
      <div class="col-sm-offset-2 col-sm-8">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">All Quizes</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <table class="table table-striped">
              <tbody>
                @foreach ($quizes as $quiz)
                  <tr>
                    <th><a href="{{ url('/user/quiz/'.$quiz->id) }}"><?php echo nl2br($quiz->name);?></a></th>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
@endsection
