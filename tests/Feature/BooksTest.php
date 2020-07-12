<?php

namespace Tests\Feature;

use App\Book;
use App\Format;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BooksTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetListBooks()
    {
        //hago una peticion con los sgtes headers llamando a la funcion headers de TestCase
        $this->withHeaders($this->headers())
        ->json('get',route('books.index'))
        ->assertJsonCount(10)
        ->assertOk();
    }

    function testUnauthorizedUsersCannotGetListBooks(){
        $this->getJson(route('books.index'))->assertUnauthorized();
    }

    function testCreateBook(){
        $this->withoutExceptionHandling();
        //agregamos datos en un arreglo como si lo hicieramos por postman o un frontend
        $payload=[
            'title'=>'Elizabeth vete a la mierda',
            'synopsis'=>'Esta chica solo manipula en ciertas palabras solo busca placer no puede dar amor de verdad',
            'authors'=>[1,2],
            'categories'=>[4],
        ];

        //genramos una variable response para guardar la respuesta de la peticion
        $response = $this->withHeaders($this->headers())
        ->postJson(route('books.store'),$payload)
        ->assertCreated();

        $book = $response->getOriginalContent();

        $this->assertDatabaseHas('books', [
            'title'=>$book->title,
        ]);

        $this->assertDatabaseHas('author_book',[
            'fk_book' => $book->id,
            'fk_author' => 1,
        ]);

        $this->assertDatabaseHas('author_book',[
            'fk_book' => $book->id,
            'fk_author' => 2,
        ]);

        $this->assertDatabaseHas('book_category',[
            'fk_book' => $book->id,
            'fk_category' => 4,
        ]);
    }

    function testCreateBookWithoutTitle(){
        $payload=[
            'title'=>'',
            'synopsis'=>'Esta chica solo manipula en ciertas palabras solo busca placer no puede dar amor de verdad',
            'authors'=>[1,2],
            'categories'=>[4],
        ];

        //genramos una variable response para guardar la respuesta de la peticion
        $this->withHeaders($this->headers())
        ->postJson(route('books.store'),$payload)
        ->assertJsonValidationErrors(['title'])
        ->assertStatus(422);
    }

    function testGetBookDetail(){
        $book = Book::find(1);

        $this->withHeaders($this->headers())
             ->json('get',route('books.show',$book->id))
             ->assertOk();
    }

    function testUpdateBook(){
        $this->withoutExceptionHandling();

        $book = Book::find(2);
        //agregamos datos en un arreglo como si lo hicieramos por postman o un frontend
        $payload=[
            'title'=>'Elizabeth vete a la mierda update',
            'synopsis'=>'Esta chica solo manipula en ciertas palabras solo busca placer no puede dar amor de verdad update',
            'authors'=>[2],
            'categories'=>[1, 4],
        ];

        //genramos una variable response para guardar la respuesta de la peticion
        $response = $this->withHeaders($this->headers())
        ->putJson(route('books.update',$book->id),$payload)
        ->assertOk();

        $book = $response->getOriginalContent();

        $this->assertDatabaseHas('books', [
            'id'=>$book->id,
            'title'=>$book->title,
        ]);
    }

    function testDeleteBook(){
        $book = Book::find(1);

        $format = Format::find(1);

        $book->formats()->save($format);

        $this->withHeaders($this->headers())
             ->deleteJson(route('books.destroy',$book->id))
             ->assertNoContent();

        $this->assertDatabaseHas('books',[
            'id'=>$book->id,
            'deleted_at'=>now(),
        ]);

        $this->assertDatabaseHas('formats',[
            'id'=>$format->id,
            'deleted_at'=>now(),
        ]);
    }
}
