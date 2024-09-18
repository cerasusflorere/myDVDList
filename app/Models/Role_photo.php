<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Role_photo extends Model
{
    protected $table = 'role_photo';
    
    /** 取得時にJSONに含める属性 */
    protected $visible = [
        'id', 'DVD_id', 'role_id', 'order', 'url'
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
     * リレーションシップ - roleテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }
}