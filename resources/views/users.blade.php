@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="col-sm-offset-2 col-sm-8">
        <div class="panel-body">
          <form action="{{ url('/search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search users"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
            <table class="table table-striped task-table">
                <thead>
                    <th>User Name</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="table-text"><div><?php echo $user->name;?></div></td>
                            <td class="table-text"><div><?php echo $user->first_name;?></div></td>
                            <td class="table-text"><div><?php echo $user->last_name;?></div></td>
                            <td class="table-text"><div><?php echo $user->email;?></div></td>
                            <td class="table-text"><div><?php echo $user->phone;?></div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>
@endsection
