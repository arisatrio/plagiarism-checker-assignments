<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentCheckResultSummary extends Model
{
    protected $fillable = [
        'assignment_title',
        'assignment_date',
        'shingle_size',
        'total_files',
        'total_comparisons',
        'average_similarity',
        'highest_similarity',
        'lowest_similarity',
        'threshold',
        'execution_time',
        'checked_at',
    ];

    public function details()
    {
        return $this->hasMany(AssignmentCheckResultDetail::class, 'summary_id');
    }
}
