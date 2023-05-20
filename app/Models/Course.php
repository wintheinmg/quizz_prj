<?php

namespace App\Models;

use \DateTimeInterface;
use App\Models\Student;
use App\Traits\Auditable;
use Spatie\MediaLibrary\HasMedia;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Course extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public $table = 'courses';

    protected $appends = [
        'thumbnail',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'teacher_id',
        'title',
        'description',
        'has_lesson', 
        'price',
        'parent_id',
        'is_published',
        'created_at',
        'course_category_id',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'image'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'course_teacher', 'course_id', 'teacher_id');
    }

    public function getThumbnailAttribute()
    {
        $files = $this->getMedia('thumbnail');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });

        return $files;
    }

    public function course_category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_students', 'course_id', 'student_id')->withPivot('status');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
