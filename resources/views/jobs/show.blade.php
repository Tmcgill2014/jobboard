@extends ('layout')
@section ('title')
	@if($job)
	{{ $job->title }}
		@if (!Auth::guest() && ($job->author_id == Auth::user()->id || Auth::user()->is_admin() ))

			<button class="btn pull-right" ><a href="{{ url('edit/'.$job->slug) }}">Edit Job Post</a></button>

		@endif
		@else
		Page doesn't exist, please try again!
		@endif
	@stop


	@section('content')
	@if($job)
		<div>
			{!! $job->body !!}
		</div>
		<div>
			<h2>Leave a Comment</h2>
		</div>
		@if(Auth::guest())
		<p>Login to Comment</p>
		@else
		<div class="panel-body">
			<form action="/comment/add" method="post">
				{!! csrf_field() !!}
				<input type="hidden" name="job_id" value="{{ $job->id }}">
				<input type="hidden" name="slug" value="{{ $job->slug }}">
				<div class="form-group">
				<textarea required="required" placeholder="Enter Comment here" name="body" class="form-control"></textarea>
				</div>
				<input type="submit" name="job_comment" class="btn btn-success" value="Post">
			</form>
		</div>
		@endif
		<div>
			@if($comments)
			<ul>
				@foreach($comments as $comment)
					<li class="panel-body">
						<div class="list-group">
							<div class="lists-group-item">
								<h3>{{ $comment->author->name }}</h3>
								<p>{{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
							</div>
							<div class="list-group-item">
								<p>{{ $comment->body }}</p>
							</div>
						</div>
					</li>
				@endforeach
			</ul>
		@endif
		</div>
		@else
		404 error
		@endif
		@stop