@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">New Question</h3>
          </div>
        <!-- /.box-header -->
        <div class="panel-body">
            <!-- Display Validation Errors -->
            @include('common.errors')
            <!-- New Task Form -->
            <form action="{{ url($quiz->id.'/question/add')}}" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group">
                  <label class="col-sm-3 control-label">Question</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" class="form-control" value="{{ old('task') }}">
                    <input type="hidden" name="parent_id" class="form-control" value="{{ $quiz->id }}">
                    <select class="form-control" name="type">
                      <option value="open">Open Answer Question</option>
                      <option value="single">Single Answer Question</option>
                      <option value="multiple">Multiple Answer Question</option>
                    </select>
                    <button type="submit" class="btn btn-block btn-info">Add Quiz</button>
                  </div>
                </div>
            </form>
        </div>
      </div>



        <!-- Current Tasks -->
        @if (count($questions) > 0)
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Current Questions of Quiz "{{ $quiz->name }}"</h3>
          </div>
        <!-- /.box-header -->
        <div class="panel-body">

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                    <th>Quiz Name</th>
                    <th>Type</th>
                    <th>&nbsp;</th>
                </thead>
                <tbody>
                  @foreach ($questions as $question)
                      <tr>
                          <th class="table-text"><a href="{{ url($quiz->id.'/question/'.$question->id.'/show') }}">{{ $question->name }}</a></th>
                          <th class="table-text">{{ $question->type }}</th>
                          <!-- Task Delete Button -->
                          <th>
                              <form action="{{ url($quiz->id.'/question/'.$question->id.'/delete') }}" method="POST">
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
          </div>
        </div>
        @endif
    </div>
</div>
@endsection
