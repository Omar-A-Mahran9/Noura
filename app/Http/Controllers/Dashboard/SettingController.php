<?php

namespace App\Http\Controllers\Dashboard;

use App\Rules\NotUrl;
use App\Models\Status;
use App\Models\RevSlider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        // $sliders = RevSlider::get();
        $this->authorize('view_settings');
         // return view('dashboard.settings', compact('sliders'));
        return view('dashboard.settings');
    }

    public function store( Request $request )
    {
        $this->authorize('create_settings');

        $data = $request->validate([
           'website_name_ar'                                  => [ 'required_if:setting_type,general' ,'nullable' , 'string' , 'max:255'  ],
           'website_name_en'                                  => [ 'required_if:setting_type,general' ,'nullable' , 'string' , 'max:255'  ],
           'facebook_url'                                     => [ 'required_if:setting_type,general' ,'url' ,'nullable' , 'string' , 'max:255'  ],
           'twitter_url'                                      => [ 'required_if:setting_type,general' ,'url' ,'nullable' , 'string' , 'max:255'  ],
           'instagram_url'                                    => [ 'required_if:setting_type,general' ,'url' ,'nullable' , 'string' , 'max:255'  ],
           'youtube_url'                                      => [ 'required_if:setting_type,general' ,'url' ,'nullable' , 'string' , 'max:255'  ],
           'snapchat_url'                                     => [ 'required_if:setting_type,general' ,'url' ,'nullable' , 'string' , 'max:255'  ],
           'email'                                            => [ 'required_if:setting_type,general' ,'nullable' , 'string' , 'max:255'  ],
           'phone'                                            => [ 'required_if:setting_type,general' ,'nullable' , 'string' , 'max:255'  ],
           'whatsapp'                                         => [ 'required_if:setting_type,general' ,'nullable' , 'string' , 'max:255'  ],
           'meta_tag_description_ar'                          => [ 'required_if:setting_type,seo'     ,'nullable' , 'string' , 'max:255'  ],
           'meta_tag_description_en'                          => [ 'required_if:setting_type,seo'     ,'nullable' , 'string' , 'max:255'  ],
           'meta_tag_keyword_ar'                              => [ 'required_if:setting_type,seo'     ,'nullable' , 'string' , 'max:255'  ],
           'meta_tag_keyword_en'                              => [ 'required_if:setting_type,seo'     ,'nullable' , 'string' , 'max:255'  ],
         ]);

        $data['phone'] = convertArabicNumbers($data['phone']);
        $data['whatsapp'] = convertArabicNumbers($data['whatsapp']);

         $this->validateFiles('logo','general',$request,$data);
        $this->validateFiles('favicon','general',$request,$data);
 
        foreach ( $data as $key => $value )
        {
            settings()->set( $key , $value);
        }

    }

    private function validateFiles($keyName , $sectionName , Request $request , &$data)
    {
        if(! settings()->get($keyName))
        {
            $request->validate([
                $keyName   => [ 'bail' , "required_if:setting_type,$sectionName", 'image', '', 'max:2048',  'nullable' ],
            ]);
        }


        if($request->hasFile($keyName))
        {
            $request->validate([
                $keyName   => [ 'bail' ,'image', '', 'max:2048' ]
            ]);
            $data[$keyName] = uploadImage( $request->file($keyName) , "Settings");
        }

    }

    public function changeThemeMode(Request $request)
    {
        session()->put('theme_mode', $request->mode);
        return redirect()->back();
    }

    public function changeLanguage(Request $request)
    {
        session()->put('locale', $request->lang);
        return redirect()->back();
    }
}
