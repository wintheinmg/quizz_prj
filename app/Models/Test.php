<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @internal
 * @coversNothing
 */
class Test extends Model
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use Auditable;
    use HasFactory;

    public $table = 'tests';

    protected $append = ['has_questions'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'course_id',
        'pass_score',
        'title',
        'description',
        'duration',
        'is_published',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public function getHasQuestionsAttribute()
    {
        return $this->questions;
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}