<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title','description', 'short_note', 'price','vat_applicable', 'vat_percentage', 'image_public_url', 'image_name'];
}
