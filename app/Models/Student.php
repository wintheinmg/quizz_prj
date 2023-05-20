<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Course;
use \DateTimeInterface;
use App\Traits\Auditable;
use Spatie\MediaLibrary\HasMedia;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Student extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const HOW_KNEW_ACCA_SELECT = [
        '1' => 'Through Facebook',
        '2' => 'Through Friends and Relatives',
        '3' => 'Through Direct Inquiry',
        '4' => 'Through Others',
    ];

    public $table = 'students';

    public static $searchable = [
        'name',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'date',
        'name',
        'user_id',
        'nrc',
        'address',
        'phone_no',
        'email',
        'acca_student_no',
        'subject',
        'exam_session_period',
        'old_student',
        'which',
        'how_knew_acca',
        'why_choose',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }
    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }
    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function courses(){
        return $this->belongsToMany(Course::class,'course_students','student_id','course_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
