@extends('app.layout')
@section('content')
    <div class="row">
        <div class="col-3">
            <h3>Connect</h3>
            <a href="#" class="btn btn-primary w-100 my-4"> connect facebook  </a>
        </div>
    </div>
    <div class="row">
        <table class="table table-hover">
            <caption>List of Pages</caption>
            <thead>
                <tr>
                  <th scope="col">name</th>
                  <th scope="col">Added on</th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <th>{{ $page->name }}</th>
                        <th>{{ $page->created_at }}</th>
                        <th><a href="#">Reconnected</a></th>
                        <th><a href="#">Delete</a></th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection