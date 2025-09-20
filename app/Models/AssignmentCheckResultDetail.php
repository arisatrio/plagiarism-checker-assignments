<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentCheckResultDetail extends Model
{
    protected $fillable = [
        'summary_id',
        'file1',
        'file2',
        'similarity',
        'similarity_score',
    ];

    public function summary()
    {
        return $this->belongsTo(AssignmentCheckResultSummary::class, 'summary_id');
    }
}
