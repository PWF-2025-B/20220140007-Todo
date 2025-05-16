<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title'];

    /**
     * Relasi: Category memiliki banyak Todo.
     */
    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    /**
     * (Opsional) Relasi: Category dimiliki oleh satu User.
     * Berguna kalau nanti kamu mau tahu siapa yang buat kategori ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
