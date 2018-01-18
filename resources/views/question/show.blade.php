@extends('layouts.app')

@section('content')
<style media="screen">
  label.col-sm-1.col-sm-1, .col-sm-12  {
    margin-bottom: 20px;
  }
</style>
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Question {{$question->name}}</h3>
          </div>
        <!-- /.box-header -->
        <div class="panel-body">
            <!-- Display Validation Errors -->
            @include('common.errors')
            <!-- New Task Form -->
            <form action="{{ url($quiz->id.'/question/'.$question->id.'/save')}}" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" name="parent_id_quiz" id="parent-id-quiz" class="form-control" value="{{ $quiz->id }}">
                <input type="hidden" name="parent_id_question" id="parent-id-question" class="form-control" value="{{ $question->id }}">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Question</label>
                  <div class="col-sm-6">
                    <input type="text" name="name" class="form-control" value="{{ $question->name }}">
                  </div>

                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Type</label>
                  <div class="col-sm-6">
                    <input type="text" readonly name="type" class="form-control" value="{{ $question->type }}">
                    <button type="submit" class="btn btn-block btn-info">Save</button>
                  </div>
                </div>
            </form>
          </div>
        </div>

        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title"><span style="text-transform: capitalize;">{{$question->type}}</span> Answer</h3>
          </div>
        <!-- /.box-header -->
        <div class="panel-body">
            <!-- Display Validation Errors -->
            @include('common.errors')
            <!-- New Task Form -->
            <form action="{{ url($question->id.'/answer/add')}}" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" name="parent_id_quiz_an" class="form-control" value="{{ $quiz->id }}">
                <input type="hidden" name="parent_id_question_an" class="form-control" value="{{ $question->id }}">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Answer</label>
                  <div class="col-sm-6">
                    <input type="text" name="answer" class="form-control" value="">
                  </div>

                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Points</label>
                  <div class="col-sm-6">
                    <input type="text"  name="points" class="form-control" value="">
                    <button type="submit" class="btn btn-block btn-info">Add Answer</button>
                  </div>
                </div>
            </form>
          </div>
        </div>

        @if (count($answers) > 0)
        <div class="panel-body">
            <table class="table table-striped">
              <thead>
                  <th>Name</th>
                  <th>Points</th>
                  <th>&nbsp;</th>
              </thead>
              <tbody>
                @foreach ($answers as $answer)
                <tr>
                    <th class="table-text"><?php echo nl2br($answer->name);?></th>
                    <th class="table-text">{{ $answer->points }}</th>
                    <!-- Task Delete Button -->
                    <th>
                        <form action="{{ url($quiz->id.'/'.$question->id.'/answer/'.$answer->id.'/delete')}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-btn fa-trash"></i>Delete
                            </button>
                        </form>
                    </th>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
