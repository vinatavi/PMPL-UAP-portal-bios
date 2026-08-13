<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    // Pastikan semua kolom yang diisi dari form terdaftar di sini
    protected $fillable = [
        'title',
        'division',
        'category', // <--- PASTIKAN INI SUDAH DITAMBAHKAN
        'event_date',
        'budget',
        'description',
        'document',
        'status',
        'notes',
    ];
}