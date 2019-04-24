<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * Nós estaremos usando o create() método para salvar o novo modelo em uma única linha.
     * Para evitar o erro de atribuição em massa que o Laravel lançará por padrão,
     * precisamos especificar as colunas que queremos que sejam atribuídas em massa.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'email', 'password' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'password', 'remember_token' ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'email_verified_at' => 'datetime' ];

    /**
     * Um usuário pode adicionar quantos livros quiser, mas um livro só pode pertencer a um usuário.
     * Portanto, o relacionamento entre o modelo do usuário e o modelo do livro é um relacionamento one-to-many.
     *
     * @return HasMany
     */
    public function books() {
        return $this->hasMany(Book::class);
    }

    /**
     * Obtém o identificador que será armazenado na declaração de assunto do JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Permite incluir quaisquer declarações customizadas que desejamos incluir no JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
}
