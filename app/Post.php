<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;
use Illuminate\Support\Str;

class Post extends Model
{
    const IS_PUBLISHED_NO = 0;
    const IS_PUBLISHED_YES = 1;
    const IS_DELETED_NO = 0;
    const IS_DELETED_YES = 1;
    
    protected $connection = 'mongodb';
    protected $collection = 'posts';

    protected $guarded = ['slug'];

    protected $dates = ['published_at'];

    /**
     * Attributes of post collection
     */
    protected $attributes = [
        'title' => '',
        'slug' => '',
        'summary' => '',
        'detail' => '',
        'is_deleted' => self::IS_DELETED_NO,
        'is_published' => self::IS_PUBLISHED_NO,
        'created_by' => null,
        'published_at' => null,
        'updated_at' => null,
        'created_at' => null,
    ];

    /**
     * Generate slug when saving title
     * @param mixed $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim($value);
        $this->attributes['slug'] = Str::slug($this->attributes['title'], '-');
    }

    /**
     * Publish a post
     * @return bool
     */
    public function publish()
    {
        $this->attributes['is_published'] = self::IS_PUBLISHED_YES;
        $this->attributes['published_at'] = new \MongoDB\BSON\UTCDateTime();
        return $this->save();
    }

    /**
     * Soft delete a post
     * @return bool
     */
    public function delete()
    {
        $this->is_deleted = self::IS_DELETED_YES;
        return $this->save();
    }
}
