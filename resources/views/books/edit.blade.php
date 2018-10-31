@extends('layouts.app')

@section('content')
		<a href="{{route('books.index')}}" class="btn btn-default">Back To Books List</a>
		<h2>Book Editing</h2>
		<hr/>

		<form action="{{route('books.update', $book)}}" method="post" enctype="multipart/form-data">
			{{method_field('PUT')}}
			{{ csrf_field() }}

			<div class="form-group">
				<label for="author">Author</label>
				<input type="text" class="form-control" name="author" value="{{$book->author or ""}}">
			</div>

			<div class="form-group">
				<label for="title">Book Title</label>
				<input type="text" class="form-control" name="title" value="{{$book->title or ""}}">
			</div>

			<div class="form-group">
				<label for="pages_count">Number of Pages</label>
				<input type="text" class="form-control" name="pages_count" value="{{$book->pages_count or ""}}">
			</div>

			<div class="form-group">
				<label for="annotation">Book Annotation</label>
				<textarea class="form-control" name="annotation">{{$book->annotation or ""}}</textarea>
			</div>

			<div class="form-group">
				<label for="cover_image">Cover Image</label>
				<input type="file" class="form-control" name="cover_image" value="">

				@if ($book->cover_image)
					<img height="100" width="100" src="/storage/cover_images/{{$book->cover_image}}" class="img-thumbnail">
					<br/><br/>
				@endif
			</div>

			<input class="btn btn-primary" type="submit" value="Save" style="margin-bottom:25px;">
		</form>
		<hr/>
@endsection
