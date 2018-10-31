<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('books.index', [
					'books' => Book::paginate(5)
				]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			$this->validate($request, [
				'author' => 'required|max:50',
				'title' => 'required|max:90',
				'pages_count' => 'required|integer',
				'annotation' => 'required',
				'cover_image' => 'image|nullable|max:1999'
			]);

				// Handle File Upload
				if ($request->hasFile('cover_image')) {
					// Get filename with the extension
					$fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
					// Get just filename
					$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
					// Get just extension
					$extension = $request->file('cover_image')->getClientOriginalExtension();
					// Filename to store
					$fileNameToStore = $filename.'_'.time().'.'.$extension;
					// Upload Image
					$path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
				} else {
					$fileNameToStore = 'noimage.jpg';
				}

				$book = new Book;
				$book->author = $request->input('author');
				$book->title = $request->input('title');
				$book->pages_count = $request->input('pages_count');
				$book->annotation = $request->input('annotation');
				$book->cover_image = $fileNameToStore;
				$book->save();

				return redirect()->route('books.index')->with('success', 'The book was added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('books.show', [
					'book' => $book
				]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('books.edit', [
					'book' => $book
				]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
			if ($book->cover_image) {
				$book_old_cover_image = $book->cover_image;
			}

			$this->validate($request, [
				'author' => 'required|max:50',
				'title' => 'required|max:90',
				'pages_count' => 'required|integer',
				'annotation' => 'required',
				'cover_image' => 'image|nullable|max:1999'
			]);

			// Handle File Upload
			if ($request->hasFile('cover_image')) {
				// Get filename with the extension
				$filenameWithExt = $request->file('cover_image')->getClientOriginalName();

				// Get just a filename
				$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
				// Get just an extension
				$extension = $request->file('cover_image')->getClientOriginalExtension();
				// Filename to store
				$fileNameToStore = $filename.'_'.time().'.'.$extension;
				// Upload Image
				$path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
			}

			// Update Book Information
			$book = Book::find($book->id);
			$book->author = $request->input('author');
			$book->title = $request->input('title');
			$book->pages_count = $request->input('pages_count');
			$book->annotation = $request->input('annotation');
			if ($request->hasFile('cover_image')) {
				$book->cover_image = $fileNameToStore;
			}
			$book->save();

			if ($book_old_cover_image != $book->cover_image) {
				Storage::delete('public/cover_images/'.$book_old_cover_image);
			}

			return redirect(route('books.index'))->with('success', 'The book information was updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
				if ($book->cover_image != 'noimage.jpg') {
        	// Delete Image
					Storage::delete('public/cover_images/'.$book->cover_image);
        }

				$book->delete();

				return redirect()->route('books.index')->with('success', 'The book was deleted!');
    }
}
