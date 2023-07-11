<?php

namespace App\Http\Controllers\Api\BicolHealthFacility\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RecordController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 400;

    public function index()
    { 
        $Record_list = DB::table('registration as a')
        ->leftjoin('registration_maintenance as b', 'a.client_type_id', 'b.id')
        ->leftjoin('registration_maintenance as c', 'a.membership_category_id', 'c.id')
        ->select(
            'a.id',
            'a.philhealth_id',
            DB::raw('CONCAT(a.last_name,\' , \',a.first_name,\'  \',a.extension,\'  \',a.middle_name) as name'),
            'a.description',
            'b.name as category_name'
        )
        ->get();
        return response()->json($Record_list, 200);
    }

    public function store(Request $request)
    { 
       
    }

    public function show($id)
    { 

    }

    public function show_maintenance($action)
    { 
    
    }
}
