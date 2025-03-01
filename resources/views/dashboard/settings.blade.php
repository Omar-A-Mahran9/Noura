@extends('partials.dashboard.master')
@section('content')
    <!--begin::Card-->
    <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10 mt-0"
        style="background-size: auto  calc(100% + 10rem); background-position: {{ isArabic() ? 'left' : 'right' }} ; background-image: url('{{ asset('dashboard-assets/media/illustrations/sketchy-1/4.png') }}')">
        <!--begin::Card header-->
        <div class="p-6">
            <div class="d-flex align-items-center">
                <!--begin::Icon-->
                <div class="symbol symbol-circle me-5">
                    <div class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs020.svg-->
                        <span>
                            <i class="bi bi-gear-fill fs-1 text-primary"></i>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <!--end::Icon-->
                <!--begin::Title-->
                <div class="d-flex flex-column">
                    <h2>{{ __('settings') }}</h2>
                </div>
                <!--end::Title-->
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pb-0">
            <!--begin::Navs-->
            <div class="d-flex overflow-auto h-55px">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold flex-nowrap">

                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6  setting-label active" id="general-settings-label"
                            href="javascript:" onclick="changeSettingView('general')">{{ __('General') }}</a>
                    </li>
                    <!--end::Nav item-->

                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 setting-label" id="seo-settings-label"
                            href="javascript:" onclick="changeSettingView('seo')">{{ __('Seo') }}</a>
                    </li>
                    <!--end::Nav item-->



                </ul>
            </div>
            <!--begin::Navs-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    <!--begin::Form-->
    <form action="{{ route('dashboard.settings.store') }}" class="form" method="post" id="submitted-form"
        data-redirection-url="{{ route('dashboard.settings.index') }}">
        @csrf

        <!-- Begin :: General Settings Card -->
        <input type="hidden" name="setting_type" value="general" id="setting-type-inp">

        <!-- Begin :: General Settings Card -->
        <div class="card card-flush setting-card" id="general-settings-card">
            <!--begin::Card header-->
            <div class="card-header pt-8">

                <div class="card-title">
                    <h2>{{ __('General') }}</h2>
                </div>

                <div class="card-title">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary mx-4" id="submit-btn-general">

                        <span class="indicator-label">{{ __('Save') }}</span>

                        <!-- begin :: Indicator -->
                        <span class="indicator-progress">{{ __('Please wait ...') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!-- end   :: Indicator -->

                    </button>
                    <!-- end   :: Submit btn -->

                </div>
            </div>
            <!--end::Card header-->

            <!-- Begin :: Card body -->
            <div class="card-body">

                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Website name in arabic') }}</label>
                        <input type="text" class="form-control" name="website_name_ar"
                            value="{{ settings()->get('website_name_ar') ?? '' }}" id="website_name_ar_inp"
                            placeholder="{{ __('Enter the website name in arabic') }}">
                        <p class="invalid-feedback" id="website_name_ar"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Website name in english') }}</label>
                        <input type="text" class="form-control" name="website_name_en"
                            value="{{ settings()->get('website_name_en') ?? '' }}" id="website_name_en_inp"
                            placeholder="{{ __('Enter the website name in english') }}">
                        <p class="invalid-feedback" id="website_name_en"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('Facebook') }}</label>
                        <input type="text" class="form-control" name="facebook_url"
                            value="{{ settings()->get('facebook_url') ?? '' }}" id="facebook_url_inp"
                            placeholder="{{ __('Enter the facebook page url') }}">
                        <p class="invalid-feedback" id="facebook_url"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('Twitter') }}</label>
                        <input type="text" class="form-control" name="twitter_url"
                            value="{{ settings()->get('twitter_url') ?? '' }}" id="twitter_url_inp"
                            placeholder="{{ __('Enter the twitter page url') }}">
                        <p class="invalid-feedback" id="twitter_url"></p>

                    </div>
                    <!-- End   :: Col -->
                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('Instagram') }}</label>
                        <input type="text" class="form-control" name="instagram_url"
                            value="{{ settings()->get('instagram_url') ?? '' }}" id="instagram_url_inp"
                            placeholder="{{ __('Enter the instagram page url') }}">
                        <p class="invalid-feedback" id="instagram_url"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('Youtube') }}</label>
                        <input type="text" class="form-control" name="youtube_url"
                            value="{{ settings()->get('youtube_url') ?? '' }}" id="youtube_url_inp"
                            placeholder="{{ __('Enter the youtube channel url') }}">
                        <p class="invalid-feedback" id="youtube_url"></p>

                    </div>
                    <!-- End   :: Col -->


                </div>
                <!-- End   :: Input group -->


                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('Snapchat') }}</label>
                        <input type="text" class="form-control" name="snapchat_url"
                            value="{{ settings()->get('snapchat_url') ?? '' }}" id="snapchat_url_inp"
                            placeholder="{{ __('Enter the snapchat url') }}">
                        <p class="invalid-feedback" id="snapchat_url"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('Email') }}</label>
                        <input type="text" class="form-control" name="email"
                            value="{{ settings()->get('email') ?? '' }}" id="email_inp"
                            placeholder="{{ __('Enter the email') }}">
                        <p class="invalid-feedback" id="email"></p>

                    </div>
                    <!-- End   :: Col -->
                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('Phone') }}</label>
                        <input type="text" class="form-control" name="phone"
                            value="{{ settings()->get('phone') ?? '' }}" id="phone_inp"
                            placeholder="{{ __('Enter the phone') }}">
                        <p class="invalid-feedback" id="phone"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('Whatsapp') }}</label>
                        <input type="text" class="form-control" name="whatsapp"
                            value="{{ settings()->get('whatsapp') ?? '' }}" id="whatsapp_inp"
                            placeholder="{{ __('Enter the whatsapp') }}">
                        <p class="invalid-feedback" id="whatsapp"></p>

                    </div>
                    <!-- End   :: Col -->
                </div>
                <!-- End   :: Input group -->


                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('logo') }}</label>
                        <br>
                        <input type="file" class="d-none" accept="image/*" name="logo" id="logo-uploader">
                        <button class="btn btn-secondary w-100 image-upload-inp" type="button"> <i
                                class="bi bi-upload fs-8"></i>
                            {{ settings()->getSettings('logo') ?: __('no file is selected') }}
                        </button>
                        <p class="invalid-feedback" id="logo"></p>


                    </div>
                </div>
                <!-- End   :: Col -->


            </div>
            <!-- End   :: Card body -->

        </div>
        <!-- End   :: General Settings Card -->


        <!-- Begin :: Seo Settings Card -->
        <div class="card card-flush setting-card" style="display:none" id="seo-settings-card">
            <!--begin::Card header-->
            <div class="card-header pt-8">

                <div class="card-title">
                    <h2>Seo</h2>
                </div>

                <div class="card-title">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary mx-4" id="submit-btn-seo">

                        <span class="indicator-label">{{ __('Save') }}</span>

                        <!-- begin :: Indicator -->
                        <span class="indicator-progress">{{ __('Please wait ...') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!-- end   :: Indicator -->

                    </button>
                    <!-- end   :: Submit btn -->

                </div>

            </div>
            <!--end::Card header-->

            <!-- Begin :: Card body -->
            <div class="card-body">

                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('Meta tag description in arabic') }}</label>
                        <textarea class="form-control form-control form-control" name="meta_tag_description_ar"
                            id="meta_tag_description_ar_inp" data-kt-autosize="true">{{ settings()->get('meta_tag_description_ar') ?? '' }}</textarea>
                        <p class="invalid-feedback" id="meta_tag_description_ar"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('Meta tag description in english') }}</label>
                        <textarea class="form-control form-control form-control" name="meta_tag_description_en"
                            id="meta_tag_description_en_inp" data-kt-autosize="true">{{ settings()->get('meta_tag_description_en') ?? '' }}</textarea>
                        <p class="invalid-feedback" id="meta_tag_description_en"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('Meta tag keywords in arabic') }}</label>
                        <input type="text" class="" id="meta_tag_keyword_ar_inp" name="meta_tag_keyword_ar"
                            value="{{ settings()->get('meta_tag_keyword_ar') ?? '' }}"
                            placeholder="{{ __('Enter the meta tag keywords in arabic') }}" />
                        <p class="invalid-feedback" id="meta_tag_keyword_ar"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-3">

                        <label class="form-label">{{ __('Meta tag keywords in english') }}</label>
                        <input type="text" class="" id="meta_tag_keyword_en_inp" name="meta_tag_keyword_en"
                            value="{{ settings()->get('meta_tag_keyword_en') ?? '' }}"
                            placeholder="{{ __('Enter the meta tag keywords in english') }}" />
                        <p class="invalid-feedback" id="meta_tag_keyword_en"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

            </div>
            <!-- End   :: Card body -->

        </div>
        <!-- End   :: Seo Settings Card -->


    </form>
    <!--end::Form-->
@endsection
@push('scripts')
    <script src="{{ asset('dashboard-assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/components/form_repeater.js') }}"></script>
    <script src="{{ asset('dashboard-assets/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
    <script>
        let changeSettingView = (tab) => {

            $('.setting-card').hide();
            $('.setting-label').removeClass('active');

            $("#" + tab + '-settings-card').show()
            $("#" + tab + '-settings-label').addClass('active')

            $("#setting-type-inp").val(tab);
        };

        $(document).ready(() => {

            initTinyMc(true);

            $('.image-upload-inp').click(function() {

                $(this).prev().trigger('click');

            });

            $('[id*=-uploader]').change(function() {

                let fileName = $(this)[0].files[0].name;

                $(this).next().html(`<i class="bi bi-upload fs-8" ></i> ${ fileName } `);

            });

            new Tagify(document.getElementById('meta_tag_keyword_ar_inp'), {
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
            });
            new Tagify(document.getElementById('meta_tag_keyword_en_inp'), {
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
            });


        });
    </script>
@endpush
