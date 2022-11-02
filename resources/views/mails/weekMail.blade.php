@component('mail::message')

You have post 

@foreach ($pages as $page)
    <h1>{{ $page->name }}</h1>
    <p>{{ count($page->posts) }}</p>
@endforeach

@component('mail::button', ['url' => '-' ]) 
visite us
@endcomponent

Thanks,<br>

@endcomponent