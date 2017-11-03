<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ImageUpload extends Model
{
  use LogsActivity;

    protected $casts = [
      'original_filename' => 'string',
      'original_filepath' => 'string',
      'original_filedir' => 'string',
      'original_extension' => 'string',
      'original_mime' => 'string',
      'original_filesize' => 'integer',
      'original_width' => 'integer',
      'original_height' => 'integer',
      'path' => 'string',
      'dir' => 'string',
      'filename' => 'string',
      'basename' => 'string',
      'exif' => 'array',
  ];

  /**
   * The keys used in thumbnail.
   *
   * @var array
   */
  protected $thumbnailKeys = [
      'path' => 'string',
      'dir' => 'string',
      'filename' => 'string',
      'filepath' => 'string',
      'filedir' => 'string',
      'width' => 'integer',
      'height' => 'integer',
      'filesize' => 'integer',
      'is_squared' => 'boolean',
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'original_filename', 'original_filepath', 'original_filedir',
      'original_extension', 'original_mime', 'original_filesize',
      'original_width', 'original_height',
      'path', 'dir', 'filename', 'basename',
      'exif',
  ];

    public function package()
    {
        return $this->belongsTo('App\Package', 'image_id', 'id')->withDefault();
    }
}
