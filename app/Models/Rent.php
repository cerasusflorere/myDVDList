<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Rent extends Model
{
    protected $table = 'rent';
    
    /** 取得時にJSONに含める属性 */
    protected $visible = [
        'id', 'DVD_id', 'flag'
    ];

    /**
     * リレーションシップ - DVD_listテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function DVD_list()
    {
        return $this->belongsTo('App\Models\DVD_list', 'DVD_id');
    }
}

?>