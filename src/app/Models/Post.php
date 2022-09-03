<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'message', 'user_id'];

    public function rules() {
        return [
            'title' => 'required|min:6',
            'message' => 'required|min:6',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'user_id.exists' => 'User_id informado não existe',
            'title.min' => 'O nome deve ter no mínimo 6 caracteres',
            'message.min' => 'O nome deve ter no mínimo 6 caracteres'
        ];
    }

    public function user() {
        //UM post PERTENCE a um usuário
        return $this->belongsTo(User::class);
    }
}
