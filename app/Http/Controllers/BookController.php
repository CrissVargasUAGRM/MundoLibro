<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $record = Book::latest()
        ->when($request->has('title'),function($query) use ($request){
            $query->where('title','like','%' . $request->query('title') . '%');
        })
        ->when($request->has('author'),function($query) use ($request){
            $query->whereHas('authors',function($query) use ($request){
                $query->where('fk_author',$request->query('author'));
            });
        })
        ->when($request->has('category'),function($query) use ($request){
            $query->whereHas('categories',function($query) use ($request){
                $query->where('fk_category',$request->query('category'));
            });
        })
        ->get(['id','title','synopsis','fk_created_by','fk_updated_by']);
        return $record; 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
