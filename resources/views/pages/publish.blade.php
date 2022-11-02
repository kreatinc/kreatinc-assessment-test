@extends('app.layout')
@section('content')
<div class="row">
<div class="col-3">
    @error('file')
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">
            {{ $message }}
        </div>
            </div>
        
    </div>
    @enderror
    
    <h3>Publish</h3>

      <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <form class="modal-content" action='{{ route("publish") }}' id="form" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel">Modal 1</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="row w-100 mb-3">
                        @csrf
                        <div class="col-12 mb-3">
                            <label for="message" class="form-label">Post Description</label>
                            <textarea name="message" id="message" class='form-control' cols="30" rows="5">what's in your mind</textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="file" class="form-label mb-2">Add Image or video</label><br>
                            <input type="file" name="file" id="file" class="from-control">
                        </div>
                        <div class="col-12">
                        <select name="page_id" id="page_id" class="form-select mb-3">
                            <option value="">Choose a Page</option>
                        @foreach ($pages as $page)
                                <option value="{{$page->facebook_id}}">{{ $page->name }}</option>
                        @endforeach
                        </select>
                        
                        </div>
                        <div class="col-12" id='schudel' >
                            
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <div class="btn btn-secondary" data-bs-dismiss="modal">Cancel</div>
                <button class="btn btn-success">Publish</button>
                <button class="btn btn-primary" id="buttonSchudel" >Schudel</button>
            </div>
        </form>
        </div>
      </div>
      
 
      <a class="btn btn-primary px-5 mt-4" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Create Post</a>
      
</div>
<div class="row my-5">
<table class="table table-hover">
    <caption>List of posts</caption>
    <thead>
        <tr>
          <th scope="col">name</th>
          <th scope="col">Added on</th>
          <th scope="col">posted</th>
          <th scope="col"></th>
          <th scope="col"></th> 
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
            <tr>
                <th style='text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden; max-width: 300px'>{{ $post->message ?? 'no content' }}</th>
                <th>{{ $post->created_time }}</th>
                <th>@if ( $post->scheduled_publish_time == null) true @else false @endif</th>
                @if ( $post->scheduled_publish_time == null)
                    <th><a href="#">View</a></th>
                    <th></th>
                    
                @else
                    
                    <th><a href="#">Edite</a></th>
                    <th><a href="#">share now</a></th>
                @endif
                <th><a href="#">Delete</a></th>
                
            </tr>
        @endforeach
    </tbody>
</table>
</div>
<script>
    buttonSchudel.addEventListener('click', (e) => {
        e.preventDefault();
        buttonSchudel.classList.toggle('active')

        if( !buttonSchudel.classList.contains('active') ){
            form.setAttribute('action',  '{{ route('publish') }}');
            schudel.innerHTML = ''
        }else{
            form.setAttribute('action',  '{{ route('scheduled') }}' );
            schudel.innerHTML = '<label for="schudel_date"> Select Date and Time </label> '
                            + ' <input type="datetime-local" name="schudel_date" id="schudel_date" class="form-control mb-2" required> '
        }
    })
</script>
@endsection 