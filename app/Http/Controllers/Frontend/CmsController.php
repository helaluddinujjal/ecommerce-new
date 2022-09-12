<?php

namespace App\Http\Controllers\Frontend;

use App\CmsPage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    //
    public function cmsPage()
    {
        //get link
         $currentUrl=url()->current();
        $domain=parse_url($currentUrl,PHP_URL_HOST);
        $pageUrl=explode($domain."/",$currentUrl);
        $pageUrl=$pageUrl[1];
         // Show 404 page if CMS Page is disabled or URL does not exist

         $cmsPage = CmsPage::where('status', 1)->get()->pluck('url')->toArray();
            if (!in_array($pageUrl, $cmsPage)) {
                abort(404);
            }else{
                $page_menu=CmsPage::where('status',1)->orderBy('priority','desc')->orderBy('id','asc')->get();
                $cmsPage = CmsPage::where('url', $pageUrl)->first();
                return view('frontend.pages.cms-page', compact('cmsPage','page_menu'));
            }

    }
    function getHost($Address) {
        $parseUrl = parse_url(trim($Address));
        return trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2)));
     }
}
