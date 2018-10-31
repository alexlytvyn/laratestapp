@extends('layouts.app')

@section('content')
		<a href="{{route('books.index')}}" class="btn btn-default">Back To Books List</a>
		<h2>"{{$book->title}}" by {{$book->author}}</h2>
		<hr/>
		<div class="row">
			<div class="col-md-4">
				<img style="width:100%;" src="/storage/cover_images/{{$book->cover_image}}">
			</div>
			<div class="col-md-8">
				<p>{{$book->annotation}}</p>
				<p>Number of pages: {{$book->pages_count}}</p>
				<form onsubmit="if(confirm('Are you sure you want to delete this item?')){ return true }else{ return false }" class="" action="{{route('books.destroy', $book)}}" method="post">
					{{method_field('DELETE')}}
					{{csrf_field()}}
					<a href="{{route('books.edit', $book)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
					<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
				</form>
			</div>
		</div>
		<hr/>
@endsection
