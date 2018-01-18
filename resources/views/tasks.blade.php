@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">New Quiz</h3>
              </div>
            <!-- /.box-header -->
            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Task Form -->
                <form action="{{ url('task')}}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Quiz</label>
                      <div class="col-sm-6">
                        <div class="input-group input-group-sm">
                          <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                          <span class="input-group-btn">
                            <button type="submit" class="btn btn-info btn-flat">Add Quiz</button>
                          </span>
                        </div>
                      </div>
                    </div>
                </form>
            </div>
          </div>

            <!-- Current Tasks -->
            @if (count($tasks) > 0)
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Current Quizes</h3>
                  </div>
                <!-- /.box-header -->
                <div class="panel-body">

                    <div class="box-body no-padding">
                      <table class="table table-striped">
                        <thead>
                            <th>Quiz Name</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                          @foreach ($tasks as $task)
                              <tr>
                                  <th class="table-text"><a href="{{ url('/quiz/'.$task->id) }}">{{ $task->name }}</a></th>
                                  <!-- Task Delete Button -->
                                  <th class="col-md-3">
                                      <form action="{{ url('task/'.$task->id) }}" method="POST">
                                          {{ csrf_field() }}
                                          {{ method_field('DELETE') }}

                                          <button type="submit" class="btn btn-block btn-danger">
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
