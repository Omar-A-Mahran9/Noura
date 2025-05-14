<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ route('dashboard.index') }}">
            {{-- <img alt="Logo" src="{{ getImagePathFromDirectory(settings()->get('logo'), 'Settings') }}"
                class="h-35px logo" /> --}}

            <img src="{{ asset('images/logo.png') }}" alt="White Logo" style="filter: brightness(0) invert(1);">

        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="black" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="black" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">

                @can('view_employees')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('employees') }}" href="{{ route('dashboard.employees.index') }}"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-user-shield"></i>
                            </span>
                            <span class="menu-title"> {{ __('Admins') }}</span>
                        </a>
                    </div>
                @endcan

                @php
                    $homePage = \App\Models\Page::where('title', 'home')->first();
                    $aboutPage = \App\Models\Page::where('title', 'about')->first();
                @endphp

                @can(['view_page'])
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('page') }}"
                            href="{{ $homePage ? route('dashboard.page.edit', $homePage->id) : '#' }}"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-home"></i>
                            </span>
                            <span class="menu-title">{{ __('Home Page') }}</span>
                        </a>
                    </div>
                @endcan

                @can(['view_page'])
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('page') }}"
                            href="{{ $aboutPage ? route('dashboard.page.edit', $aboutPage->id) : '#' }}"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-info-circle"></i>
                            </span>
                            <span class="menu-title">{{ __('About Page') }}</span>
                        </a>
                    </div>
                @endcan


                @canany(['view_courses', 'view_courses_order', 'view_course_category'])
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Courses') }}</span>
                        </div>
                    </div>
                @endcanany

                @can('view_course_category')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('coursecategories') }}"
                            href="{{ route('dashboard.coursecategories.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-folder"></i>
                            </span>
                            <span class="menu-title"> {{ __('Categories') }}</span>
                        </a>
                    </div>
                @endcan

                @can(['view_courses'])
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('courses') }}" href="{{ route('dashboard.courses.index') }}"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-book"></i>
                            </span>
                            <span class="menu-title"> {{ __('Courses') }}</span>
                        </a>
                    </div>
                @endcan

                @can(['view_courses_order'])
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('Courses_Order') }}"
                            href="{{ route('dashboard.Courses_Order.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-shopping-cart"></i> </span>
                            <span class="menu-title"> {{ __('Courses Order') }}</span>
                        </a>
                    </div>
                @endcan


                @canany(['view_live', 'view_live_order', 'view_live_category'])
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('lives') }}</span>
                        </div>
                    </div>
                @endcanany


                @can(['view_live'])
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('lives') }}" href="{{ route('dashboard.lives.index') }}"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-tv"></i>
                            </span>
                            <span class="menu-title"> {{ __('lives') }}</span>
                        </a>
                    </div>
                @endcan



                @can('view_live')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('lives_orders') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" href="{{ route('dashboard.lives_orders.index') }}"
                            data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-shopping-cart"></i> </span>
                            <span class="menu-title"> {{ __('lives Order') }}</span>
                        </a>
                    </div>
                @endcan



                @canany(['view_books', 'view_books_orders'])
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Books') }}</span>
                        </div>
                    </div>
                @endcanany

                @can('view_books')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('books') }}" data-bs-toggle="tooltip" data-bs-trigger="hover"
                            href="{{ route('dashboard.books.index') }}" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-book"></i>
                            </span>
                            <span class="menu-title"> {{ __('Books') }}</span>
                        </a>
                    </div>
                @endcan

                @can('view_books_notes')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('books_notes') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" href="{{ route('dashboard.books_notes.index') }}"
                            data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-sticky-note"></i>
                            </span>
                            <span class="menu-title"> {{ __('Books Notes') }}</span>
                        </a>
                    </div>
                @endcan

                @can('view_books_orders')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('books_orders') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" href="{{ route('dashboard.books_orders.index') }}"
                            data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-shopping-cart"></i> </span>
                            <span class="menu-title"> {{ __('Books Order') }}</span>
                        </a>
                    </div>
                @endcan





                @can('view_tags')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('tags') }}" href="{{ route('dashboard.tags.index') }}"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-tag"></i>
                            </span>
                            <span class="menu-title"> {{ __('Tags') }}</span>
                        </a>
                    </div>
                @endcan

                @canany(['view_articles', 'view_categories'])
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Articles') }}</span>
                        </div>
                    </div>
                @endcanany

                @can('view_categories')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('categories') }}"
                            href="{{ route('dashboard.categories.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-folder"></i>
                            </span>
                            <span class="menu-title"> {{ __('Categories') }}</span>
                        </a>
                    </div>
                @endcan

                @can('view_articles')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('articles') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" href="{{ route('dashboard.articles.index') }}"
                            data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fas fa-file-alt"></i>
                            </span>
                            <span class="menu-title"> {{ __('Articles') }}</span>
                        </a>
                    </div>
                @endcan







                @canany(['view_consultation', 'view_consultation_type'])
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('consultation') }}</span>
                        </div>
                    </div>
                @endcanany


                {{-- @can(['view_consultation_type'])
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('consultation_type') }}"
                            href="{{ route('dashboard.consultationtype.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-blog"></i> <!-- Changed icon class -->
                            </span>
                            <span class="menu-title"> {{ __('consultatio type') }}</span>
                        </a>
                    </div>
                @endcan --}}
                @php
                    $firstConsultationWork = \App\Models\ConsultationWork::first();
                @endphp

                @can(['view_consultation_work'])
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('consultation_work') }}"
                            href="{{ $firstConsultationWork ? route('dashboard.consultation_work.edit', $firstConsultationWork->id) : '#' }}"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa-regular fa-eye"></i> </span>
                            <span class="menu-title"> {{ __('consultatio work') }}</span>
                        </a>
                    </div>
                @endcan

                @can(['view_consultation_time'])
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('view_consultation_time') }}"
                            href="{{ route('dashboard.consultation_time.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-clock"></i>
                            </span>
                            <span class="menu-title"> {{ __('consultation time') }}</span>
                        </a>
                    </div>
                @endcan
                @can(['view_consultation_time'])
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('Courses_Order') }}"
                            href="{{ route('dashboard.consultation_order.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-shopping-cart"></i> </span>
                            <span class="menu-title"> {{ __('Consultation Order') }}</span>
                        </a>
                    </div>
                @endcan

                {{-- @can(['view_consultation'])
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('consultation') }}"
                            href="{{ route('dashboard.consultation.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-comments"></i>
                            </span>
                            <span class="menu-title"> {{ __('consultation') }}</span>
                        </a>
                    </div>
                @endcan --}}

                {{-- @can(['view_quizzes'])
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('quizzes') }}" href="{{ route('dashboard.quizzes.index') }}"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-question"></i>
                            </span>
                            <span class="menu-title"> {{ __('Quizzes') }}</span>
                        </a>
                    </div>
                @endcan --}}

                <!-- start   :: orders section -->


                {{-- @canany(['group_chat']) --}}
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-0">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Chat Groups') }}</span>
                    </div>
                </div>
                {{-- @endcanany --}}
                {{-- @can('group_chat') --}}
                <div class="menu-item">
                    <a class="menu-link {{ isTabActive('group_chat') }}"
                        href="{{ route('dashboard.group_chat.index') }}" data-bs-toggle="tooltip"
                        data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                            <i class="fa fa-comments"></i>
                        </span>
                        <span class="menu-title"> {{ __('Groups') }}</span>
                    </a>
                </div>
                {{-- @endcan --}}


                @canany(['view_vendors', 'view_contact_us', 'view_news_subscribers'])
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Vendors') }}</span>
                        </div>
                    </div>
                @endcanany


                @can('view_vendors')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('vendors') }}" href="{{ route('dashboard.vendors.index') }}"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-users"></i>
                            </span>
                            <span class="menu-title"> {{ __('Vendors') }}</span>
                        </a>
                    </div>
                @endcan


                @can('view_contact_us')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('contact-us') }}"
                            href="{{ route('dashboard.contact-us.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fas fa-comments"></i>
                            </span>
                            <span class="menu-title"> {{ __('ContactUs us') }}</span>
                        </a>
                    </div>
                @endcan

                {{-- @can('view_news_subscribers')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('news-subscribers') }}" href="{{ route('dashboard.news-subscribers.index') }}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                                <i class="fas fa-newspaper"></i>
                        </span>
                            <span class="menu-title"> {{ __("News Subscribers") }}</span>
                        </a>
                    </div>
                @endcan --}}

                @canany(['view_roles', 'view_employees', 'view_settings'])
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-0">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ __('Settings') }}</span>
                        </div>
                    </div>
                @endcanany


                @can('view_roles')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('roles') }}" href="{{ route('dashboard.roles.index') }}"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                            data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="fa fa-lock"></i>
                            </span>
                            <span class="menu-title"> {{ __('Roles') }}</span>
                        </a>
                    </div>
                @endcan

                @can('view_settings')
                    <div class="menu-item">
                        <a class="menu-link {{ isTabActive('settings') }}"
                            href="{{ route('dashboard.settings.index') }}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon">
                                <i class="bi bi-gear-fill"></i>
                            </span>
                            <span class="menu-title"> {{ __('Settings') }}</span>
                        </a>
                    </div>
                @endcan


            </div>
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Aside menu-->
</div>
