<?php

namespace App;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * Nós estaremos usando o create() método para salvar o novo modelo em uma única linha.
     * Para evitar o erro de atribuição em massa que o Laravel lançará por padrão,
     * precisamos especificar as colunas que queremos que sejam atribuídas em massa.
     *
     * @var array
     */
    protected $fillable = [ 'book_id', 'user_id', 'rating' ];

    /**
     * Um livro pode ser avaliado por vários usuários, portanto, um livro pode ter muitas classificações.
     * Uma classificação só pode pertencer a um livro. Este também é um relacionamento one-to-many.
     *
     * @return BelongsTo
     */
    public function book() {
        return $this->belongsTo(Book::class);
    }
}
