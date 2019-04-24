<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    /**
     * Nós estaremos usando o create() método para salvar o novo modelo em uma única linha.
     * Para evitar o erro de atribuição em massa que o Laravel lançará por padrão,
     * precisamos especificar as colunas que queremos que sejam atribuídas em massa.
     *
     * @var array
     */
    protected $fillable = [ 'user_id', 'title', 'description' ];

    /**
     * Um usuário pode adicionar quantos livros quiser, mas um livro só pode pertencer a um usuário.
     * Portanto, o relacionamento entre o modelo do usuário e o modelo do livro é um relacionamento one-to-many.
     *
     * @return BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     *  Um livro pode ser avaliado por vários usuários, portanto, um livro pode ter muitas classificações.
     * Uma classificação só pode pertencer a um livro. Este também é um relacionamento one-to-many.
     *
     * @return HasMany
     */
    public function ratings() {
        return $this->hasMany(Rating::class);
    }
}
