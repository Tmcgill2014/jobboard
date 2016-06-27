@extends('layout')
@section('title')
{{ $title }}
@stop

@section( 'content' )
@if ( !$jobs->count() )
There is no job posts! Login and post a new Job!
@else
<div>
		@foreach( $jobs as $job)
		<div class="list-group">
			<div class="list-group-item">
				<h3>
					<a href="{{ url('/'.$job->slug) }}">{{ $job->title }}</a>
						@if (!Auth::guest() && ($job->author_id == Auth::user()->id || Auth::user()->is_admin() ))
							@if ( $job->active == '1')
							<button class="btn pull-right"><a href="{{ url('edit/'.$job->slug) }}">Edit Job Post</a></button>
							@else
							<button class="btn pull-right"><a href="{{ url('edit/'.$job->slug) }}">Edit Job Draft</a></button>
							@endif
						@endif
					</h3>
					<p>
						{{ $job->created_at->format('M d,Y \a\t h:i a') }} By <a href="#">{{ $job->author->name }}</a>
					</p>
				</div>
				<div class="list-group-item">
					<article> {!! str_limit($job->body, $limit = 1500, $end = '... <a href="#">Read More</a>') !!}
					</article>
				</div>
			</div>
	@endforeach
	{!! $jobs->render() !!}				
	</div>
	@endif
	@stop