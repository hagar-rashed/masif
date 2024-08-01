<header class="header active">
    <div class="top-par">
        <div class="main-container">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <div class="logo">
                        <a href="{{ route('site.home') }}">
                            <img src="{{ asset('storage/' . getSetting('logo')) }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="element">
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
                                <a href="{{ route('site.clients') }}">
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
                        </ul>
                    </div>
                </div>


                <div class="col-lg-2">
                    <div class="language">
                        <a href="">
                            {{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}
                            <i class="fas fa-caret-down"></i>
                        </a>
                        <div class="dropdowm-language">
                            <ul>
                                <li> <a href="{{ route('language', 'ar') }}">عربي</a></li>
                                <li> <a href="{{ route('language', 'en') }}"> English </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="menu-div">
                <div class="content" id="times-ican">
                    <a href="#" title="Navigation menu" class="navicon" aria-label="Navigation">
                        <span class="navicon__item"></span>
                        <span class="navicon__item"></span>
                        <span class="navicon__item"></span>
                        <span class="navicon__item"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
