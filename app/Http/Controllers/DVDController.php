<?php

namespace App\Http\Controllers;

use Cloudinary;
use App\Models\DVD_list;
use App\Models\Role;
use App\Models\Role_group;
use App\Models\Role_photo;
use App\Models\Location;
use App\Models\Costumer;
use App\Models\History;
use App\Models\Song;
use App\Models\Singer;
use App\Models\Other;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\StorePhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

date_default_timezone_set('Asia/Tokyo'); 

class DVDController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DVDs = DVD_list::where('own', 1)->where('adaptation', 1)
                ->with(['locations','costumers', 'roles','photos','rents'=> function($query) {
                    $query->where('flag', 1);
                }])->orderByRaw('duration_from is null asc')->orderBy('duration_from')->get();
        return $DVDs;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $DVD = DVD_list::where('id', $id)
              ->with(['locations', 'costumers', 'roles', 'roles.role_group:id,name', 'roles.role_photos', 'role_groups', 'histories', 'songs', 'songs.singers', 'songs.singers.role', 'songs.singers.role_group', 'others', 'photos', 'rents'])->first();
        

        return $DVD ?? abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function theater()
    {
        $locations = Location::groupBy('theater')->get(['theater']);
        return $locations;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function author()
    {
        $authors = DVD_list::groupBy('author')->get(['author']);
        return $authors;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function costumer()
    {
        $costumers = Costumer::groupBy('name')->get(['name']);
        return $costumers;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lyricist()
    {
        $lyricists = DVD_list::groupBy('lyricist')->get(['lyricist']);
        return $lyricists;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function choreo()
    {
        $choreos = DVD_list::groupBy('choreo')->get(['choreo']);
        return $choreos;
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function director()
    {
        $choreos = DVD_list::groupBy('director')->get(['director']);
        return $choreos;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rent()
    {
        $DVD = DVD_list::with(['rents' => function($query) {
            $query->where(['flag', 1], ['official', 1])->max('start_date');
        }])->get(['id', 'title', 'duration_from']);

        return $DVD ?? abort(404);
    }
}
