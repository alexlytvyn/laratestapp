@extends('layouts.app')

@section('content')
		<h1>Books List</h1>
		<hr/>
		<a href="{{route('books.create')}}" class="btn btn-primary pull-right"><i class="fa fa-plus-square-o"></i> Add a Book</a>
		@if (count($books))
			<table class="table table-striped">
				<thead>
					<th>#</th>
					<th>Author</th>
					<th>Title</th>
					<th>Cover Image</th>
					<th class="text-right">Action</th>
				</thead>
				<tbody>
					@foreach ($books as $book)
						<tr>
							<td>{{$book->id}}</td>
							<td>{{$book->author}}</td>
							<td>{{$book->title}}</td>
							<td><img height="100" width="100" src="/storage/cover_images/{{$book->cover_image}}" class="img-thumbnail"></td>
							<td class="text-right">
								<form onsubmit="if(confirm('Are you sure you want to delete this item?')){ return true }else{ return false }" action="{{route('books.destroy', $book)}}" method="post">
									{{method_field('DELETE')}}
									{{csrf_field()}}

									<a href="{{route('books.show', $book)}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
									<a href="{{route('books.edit', $book)}}" class="btn btn-default"><i class="fa fa-edit"></i></a>
									<button type="submit" class="btn"><i class="fa fa-trash-o"></i></button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">
							<ul class="pagination pull-right">
								{{$books->links()}}
							</ul>
						</td>
					</tr>
				</tfoot>
			</table>
		@else
			<h1 class="text-center">There are no books in the database!</h1>
		@endif
		<hr/>
@endsection
