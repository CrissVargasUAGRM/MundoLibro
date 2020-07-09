<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Nullable;

class AuthorController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $record = Author::latest()
        ->when($request->has('name'),function($query) use ($request){
            $query->where('name','like','%' . $request->query('name') . '%');
        })
        ->get(['id', 'name', 'avatar', 'created_at']);

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
        $request->validate([
            'name'=>[
                'required',
                'string',
                'alpha_spaces',
                // function($atributte,$value,$fail){
                //     $regex = '/^[\pL\.\s]+$/u';
                //     if(!preg_match($regex,$value)){
                //         $fail(trans('validation.alpha_spaces'));
                //     }
                // },
                Rule::unique('authors')->where(function($query){
                    return $query->where('deleted_at', null);
                }),
            ],
            'avatar'=>[
                'nullable',
                'image'
            ]
        ]);

        $record = Author::create([
            'name' => $request->input('name'),
            'fk_created_by' => auth()->user()->id,
        ]);
        
        if($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('images/authors', 'public');
            $record->update([
                'avatar' => $path
            ]);
        }

        return $record;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        return $author->load([
            'createdBy'=>function($query){
                $query->select('id', 'name');
            },

            'updatedBy'=>function($query){
                $query->select('id', 'name');
            }
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:authors,name,' . $author->id,
                Rule::unique('authors')->where(function($query){
                    return $query->where('deleted_at', null);
                })->ignore($author->id),
            ],
            'avatar' => [
                'nullable',
                'image'
            ]
        ]);
 
        $author->update([
            'name' => $request->input('name'),
            'fk_updated_by' => auth()->user()->id,
        ]);

        if($request->hasFile('avatar')){
            Storage::disk('public')->delete($author->avatar);

            $path = $request->file('avatar')->store('images/authors','public');
            $author->update([
                'avatar'=>$path
            ]);
        }

        return $author;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        Storage::disk('public')->delete($author->avatar);
        
        $author -> delete();

        return response([],204);
    }
}
