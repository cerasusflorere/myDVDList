<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Role extends Model
{
    protected $table = 'role';
    
    /** 取得時にJSONに含める属性 */
    protected $visible = [
        'id', 'DVD_id', 'order', 'role_group_id', 'role', 'player', 'member', 'impression',
        'role_group', 'role_photos'
    ];

    /**
     * リレーションシップ - DVD_listテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function DVD_list()
    {
        return $this->belongsTo('App\Models\DVD_list', 'DVD_id');
    }


    /**
     * リレーションシップ - role_groupテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role_group()
    {
        return $this->belongsTo('App\Models\Role_group','role_group_id');
    }

    /**
     * リレーションシップ - role_photosテーブル
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function role_photos()
    {
        return $this->hasMany('App\Models\Role_photo');
    }
}