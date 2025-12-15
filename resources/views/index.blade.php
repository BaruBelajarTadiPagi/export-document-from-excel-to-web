@extends('app')
@section('content')

<div class="row">
    <div class="col-md-12">
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        
        <div class="card">
            <div class="card-header">
                <h3>Team List
                    <a href="{{ url('team/create') }}" class="btn btn-primary btn-sm text-white float-end">
                        Add Person
                    </a>

                    
                </h3>
                

                <div class="row">

                    
                        
                        <div class="col-md-3">
                            <form action="{{ route('team.import.xls') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                <input type="file" class="form-control @error('filexls') is-invalid @enderror" name="filexls">
                                @error('filexls')
                                <p style="color: red;">{{ $message }}</p>
                                @enderror
                                <button class="btn btn-info mt-2" type="submit">Import <i class="mdi mdi-file-excel"></i></button>
                            </form>
                        </div>

                        <div class="col-md-6">

                            <a href="{{ route('team.xls') }}" class="btn btn-success btn-sm text-white mt-2">
                                Export to xls
                            </a>
                        </div>
                    
                </div>

                    
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Position Job</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teams as $team)
                            <tr>
                                <td>{{ $team->id }}</td>
                                <td>{{ $team->name }}</td>
                                <td>{{ $team->position }}</td>
                                <td>
                                    <img src="{{ asset("$team->image") }}" style="width: 70px; height: 70px" alt="Team">
                                </td>
                                <td>
                                    <a href="{{ url('team/'.$team->id.'/edit') }}" class="btn btn-success">Edit</a>
                                    <a href="{{ url('team/'.$team->id.'/delete') }}" 
                                        onclick="return confirm('Are you sure you want to delete this person?');"
                                        class="btn btn-danger"
                                    >
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection