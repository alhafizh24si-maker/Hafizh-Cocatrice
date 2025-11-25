<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original_name',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'description'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk file URL
    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    // Accessor untuk file icon berdasarkan mime type
    public function getFileIconAttribute()
    {
        if (str_contains($this->mime_type, 'image')) {
            return 'fa-file-image text-primary';
        } elseif (str_contains($this->mime_type, 'pdf')) {
            return 'fa-file-pdf text-danger';
        } elseif (str_contains($this->mime_type, 'word') || str_contains($this->mime_type, 'document')) {
            return 'fa-file-word text-primary';
        } elseif (str_contains($this->mime_type, 'excel') || str_contains($this->mime_type, 'spreadsheet')) {
            return 'fa-file-excel text-success';
        } else {
            return 'fa-file text-secondary';
        }
    }

    // Method untuk format file size
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
