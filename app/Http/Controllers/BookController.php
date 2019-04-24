<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\BookResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Retorna uma lista dos livros que foram adicionados.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return BookResource::collection(Book::with('ratings')->paginate(25));
    }

    /**
     *  Cria um novo livro com o ID do usuário atualmente autenticado junto com os detalhes do livro
     * e o mantém no banco de dados.
     *
     * @param  Request  $request
     * @return BookResource
     */
    public function store(Request $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $book = Book::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return new BookResource($book);
    }

    /**
     * Aceita um modelo Book e simplesmente retorna um recurso de livro com base no livro especificado.
     *
     * @param Book $book
     * @return BookResource
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Primeiro verifica se o usuário que está tentando atualizar um livro é o proprietário do livro
     * (ou seja, quem criou o livro). Se o usuário não for o proprietário do livro, retornamos uma mensagem de erro
     * apropriada e definimos o código de status HTTP como 403(o que indica: Proibido - o usuário é autenticado, mas
     * não tem permissão para executar uma ação). Caso contrário, atualizamos o livro com os novos detalhes e
     * retornamos um recurso do livro com os detalhes atualizados.
     *
     * @param Request $request
     * @param Book $book
     * @return BookResource
     */
    public function update(Request $request, Book $book)
    {
        // check if currently authenticated user is the owner of the book
        if ($request->user()->id !== $book->user_id) {
            return response()->json(['error' => 'You can only edit your own books.'], 403);
        }

        $book->update($request->only(['title', 'description']));

        return new BookResource($book);
    }

    /**
     * Exclui um livro especificado do banco de dados. Como o livro especificado foi excluído e
     * não está mais disponível, definimos o código de status HTTP da resposta retornada para 204
     * (o que indica: Nenhum conteúdo - a ação foi executada com êxito, mas não há conteúdo para retornar).
     *
     * @param Book $book
     * @return Response
     * @throws Exception
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
