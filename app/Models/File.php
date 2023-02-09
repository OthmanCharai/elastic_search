<?php

namespace App\Models;

use App\Trait\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory,Searchable;

    public String $index="leyton";
    public String $type="leyton-me";
    protected $fillable=['doc_content','doc_name',"doc_type",'user_id'];

    /**
     * @return BelongsTo
     * syn a user with file
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
