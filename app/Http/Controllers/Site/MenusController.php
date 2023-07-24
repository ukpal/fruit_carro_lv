<?php
namespace App\Http\Controllers\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Slug;
use App\Models\Page;
use App\Models\Menu;
use Validator;
use Session;
use DB;
use Carbon\Carbon;

class MenusController extends Controller {
    public function details(Request $request) {
        $slug = $request->segment(1);
        $pageDetails = Menu::where([['menus.status','=','Active'],['slugs.slug','=',$slug]])->select('slugs.slug','slugs.slug_type','pages.*')->leftJoin('pages', [['pages.id', '=', 'menus.page_id']])->leftJoin('slugs', [['slugs.parent_id', '=', 'menus.id'],['slugs.slug_type', '=', DB::raw("'Menus'")]])->first();

        $mainHeader = $pageDetails->title ;

        return view('site.pages.details', ['mainHeader' => $mainHeader,'pageDetails' => $pageDetails]);
    }
}
