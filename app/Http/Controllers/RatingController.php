<?php

namespace App\Http\Controllers;

use App\Book;
use App\Rating;
use App\Http\Resources\RatingResource;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Usado para avaliar um livro especificado. Estamos usando o firstOrCreate()
     * que verifica se um usuário já classificou um livro específico. Se o usuário tiver,
     * simplesmente retornamos um recurso de classificação com base na classificação.
     * Caso contrário, adicionamos a classificação do usuário ao livro especificado e
     * o mantemos no banco de dados.
     *
     * @param Request $request
     * @param Book $book
     * @return RatingResource
     */
    public function store(Request $request, Book $book) {
        /** @noinspection PhpUndefinedMethodInspection */
        $rating = Rating::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'book_id' => $book->id,
            ],
            ['rating' => $request->rating]
        );

        return new RatingResource($rating);
    }
}
