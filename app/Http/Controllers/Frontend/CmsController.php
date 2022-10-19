<?php

namespace App\Http\Controllers\Frontend;

use App\CmsPage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CmsController extends Controller
{
    //
    public function cmsPage()
    {
        //get link
        $currentUrl = url()->current();
        $domain = parse_url($currentUrl, PHP_URL_HOST);
        $pageUrl = explode($domain . "/", $currentUrl);
        $pageUrl = $pageUrl[1];
        // Show 404 page if CMS Page is disabled or URL does not exist

        $cmsPage = CmsPage::where('status', 1)->get()->pluck('url')->toArray();
        if (!in_array($pageUrl, $cmsPage)) {
            abort(404);
        } else {
            $page_menu = CmsPage::where('status', 1)->orderBy('priority', 'desc')->orderBy('id', 'asc')->get();
            $cmsPage = CmsPage::where('url', $pageUrl)->first();
            return view('frontend.pages.cms-page', compact('cmsPage', 'page_menu'));
        }
    }
    function getHost($Address)
    {
        $parseUrl = parse_url(trim($Address));
        return trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2)));
    }

    function contact(Request $request)
    {
        if ($request->isMethod("Post")) {
            $data = $request->all();
            $rules = [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'required',
            ];
            $customMessages = [
                'firstname.required' => 'First Name is required',
                'lastname.required' => 'Last Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Valid Email is required',
                'subject.required' => 'Subject is required',
                'message.required' => 'Message is required',
            ];
            $this->validate($request, $rules, $customMessages);
            $messageData = [
                'name' => $data['firstname'] . ' ' . $data['lastname'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'user_message' => $data['message'],
            ];

        Mail::send('mail.enquery', $messageData , function ($message) use ($data) {
            $message->to('helaluddin@yopmail.com')->subject('Enquery Team Ecommerce Website');
        });
            //$contact = new Contact();
            // $contact->name = $data['name'];
            // $contact->email = $data['email'];
            // $contact->phone = $data['phone'];
            // $contact->message = $data['message'];
            // $contact->save();
            toast('Your message has been sent successfully', 'success');
            return redirect()->back();
        }
        return view('frontend.pages.contact-page');
    }
}
