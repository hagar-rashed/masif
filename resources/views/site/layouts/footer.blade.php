<!-- start footer ==============================
        ============================== -->
<footer>
    <div class="footer">
        <div class="main-container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="element-footer">
                        <h2> {{ __('models.about_company') }} </h2>
                        <ul>
                            <li><a href="{{ route('site.about') }}"> {{ __('models.about_us') }} </a></li>
                            <li><a href="{{ route('site.solutions') }}"> {{ __('models.solutions') }} </a></li>
                            <li><a href="{{ route('site.partners') }}"> {{ __('models.partners') }} </a></li>
                            <li><a href="{{ route('site.clients') }}"> {{ __('models.clients') }} </a></li>
                            <li><a href="{{ route('site.jobs.index') }}">{{ __('models.jobs') }}</a></li>
                            <li><a href="{{ route('site.internships.index') }}">{{ __('models.internships') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="element-footer">
                        <h2>{{ __('models.contact_us') }}</h2>
                        <ul>
                            <li><a> <i class="bi bi-geo-alt"></i> {{ getSetting('address') }} </a></li>
                            <li><a href="tel:{{ getSetting('phone_1') }}"> <i class="bi bi-telephone"></i>
                                    {{ getSetting('phone_1') }} </a></li>
                            <li><a href="tel:{{ getSetting('phone_2') }}"> <i class="bi bi-telephone"></i>
                                    {{ getSetting('phone_2') }} </a></li>
                            <li><a href="https://wa.me/{{ getSetting('whatsapp') }}"> <i class="bi bi-whatsapp"></i>
                                    {{ getSetting('whatsapp') }} </a></li>
                        </ul>
                    </div>
                </div>


                <div class="col-lg-4">
                    @include('site.includes.mailList')
                </div>
            </div>



            <div class="end-page">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="logo-footer">
                            <a href="{{ route('site.home') }}">
                                <img src="{{ asset('storage/' . getSetting('footer_logo')) }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <p>
                            {{ __('models.all_rights') . ' ' . date('Y') . ' ' . __('models.reserved_to') . ' ' . 'New Cairo' }}
                        </p>
                    </div>
                    <div class="col-lg-4">
                        <div class="meida-footer">
                            <ul>
                                <li><a href="{{ getSetting('linkedin') }}"> <i class="fab fa-linkedin"></i></a></li>
                                <li><a href="{{ getSetting('messenger') }}"> <i
                                            class="fab fa-facebook-messenger"></i></a></li>
                                <li><a href="{{ getSetting('facebook') }}"> <i class="fab fa-facebook-f"></i> </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>








        </div>
    </div>

</footer>
<!-- end footer=========================
        ===========================  -->






</div>





<div class="media-icons">
    <div class="click-media-icons">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share"
            viewBox="0 0 16 16">
            <path
                d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
        </svg>
    </div>
    <ul>
        <li><a href="{{ getSetting('linkedin') }}"> <i class="fab fa-linkedin"></i></a></li>
        <li><a href="{{ getSetting('messenger') }}"> <i class="fab fa-facebook-messenger"></i></a></li>
        <li><a href="{{ getSetting('facebook') }}"> <i class="fab fa-facebook-f"></i> </a></li>
    </ul>
</div>



<p><button id="theme-toggle">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-moon-fill" viewBox="0 0 16 16">
            <path
                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
        </svg>
    </button></p>








<!-- start menu responsive ===
        ======== -->
<div class="bg_menu ">
</div>
<div class="menu_responsive" id="menu-div">

    <div class="element_menu_responsive">
        <ul>

            <li>
                <a href="{{ route('site.home') }}" class="{{ isActiveRoute('site.home') }}">
                    {{ __('models.home') }}
                </a>
            </li>
            <li>
                <a href="{{ route('site.about') }}" class="{{ isActiveRoute('site.about') }}">
                    {{ __('models.about_us') }}
                </a>
            </li>
            <li>
                <a href="{{ route('site.solutions') }}" class="{{ isActiveRoute('site.solutions') }}">
                    {{ __('models.solutions') }}
                </a>
            </li>
            <li>
                <a href="{{ route('site.sectors') }}" class="{{ isActiveRoute('site.sectors') }}">
                    {{ __('models.sectors') }}
                </a>
            </li>
            <li>
                <a href="{{ route('site.partners') }}" class="{{ isActiveRoute('site.partners') }}">
                    {{ __('models.partners') }}
                </a>
            </li>
            <li>
                <a href="{{ route('site.clients') }}" class="{{ isActiveRoute('site.clients') }}">
                    {{ __('models.clients') }}
                </a>
            </li>
            <li>
                <a href="{{ route('site.jobs.index') }}"
                    class="{{ areActiveRoutes(['site.jobs.index', 'site.jobs.show', 'site.jobs.apply']) }}">
                    {{ __('models.jobs') }}
                </a>
            </li>
            <li>
                <a href="{{ route('site.news.index') }}"
                    class="{{ areActiveRoutes(['site.news.index', 'site.news.show', 'site.news.filter']) }}">
                    {{ __('models.news') }}
                </a>
            </li>
            <li>
                <a href="{{ route('site.contact') }}" class="{{ isActiveRoute('site.contact') }}">
                    {{ __('models.contact_us') }}
                </a>
            </li>

            <li>
                <a class="click-dropdown-mune" href=""> {{ __('models.lang') }}</a>
                <div class="dropdowm-language-mune">
                    <ul>
                        <li><a href="{{ route('language', 'ar') }}">عربي</a> </li>
                        <li><a href="{{ route('language', 'en') }}"> English</a> </li>
                    </ul>
                </div>

            </li>
        </ul>
    </div>


    <div class="remove-mune">
        <span></span>
    </div>




</div>

<!-- end menu responsive ===
        ======== -->

</div>

@include('site.layouts.script')



</body>
<!-- end-body
=================== -->

</html>
