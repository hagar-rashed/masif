<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ url('storage/' . getSetting('logo')) }}" width="150px" alt="">
                </a>

            </li>

        </ul>
    </div>
    <div class="divider"></div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ isActiveRoute('admin.home') }}"><a class="d-flex align-items-center"
                    href="{{ route('admin.home') }}"><i class="fa-solid fa-house"></i><span
                        class="menu-title text-truncate">{{ __('models.home') }}</span></a>
            </li>
        </ul>

        {{-- categories --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.categories.index', 'admin.categories.create', 'admin.categories.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.categories.index') }}"><i
                        class="fa-solid fa-bookmark"></i><span
                        class="menu-title text-truncate">{{ __('models.categories') }}</span></a>
            </li>
        </ul> --}}

        {{-- articles --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.articles.index', 'admin.articles.create', 'admin.articles.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.articles.index') }}"><i
                        class="fa-solid fa-newspaper"></i><span
                        class="menu-title text-truncate">{{ __('models.news') }}</span></a>
            </li>
        </ul> --}}
        {{-- villages --}}

        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.villages.index', 'admin.villages.create', 'admin.villages.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.villages.index') }}">
                    <i class="fa-solid fa-arrow-up-from-water-pump"></i>
                    <span class="menu-title text-truncate">{{ __('models.values') }}</span>
                </a>
            </li>
        </ul>
        {{-- unites --}}

        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ areActiveRoutes(['admin.units.index', 'admin.units.create', 'admin.units.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.units.index') }}">
                    <i class="fa-solid fa-arrow-up-from-water-pump"></i>
                    <span class="menu-title text-truncate">{{ __('models.units') }}</span>
                </a>
            </li>
        </ul>
        {{-- trips --}}

        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ areActiveRoutes(['tripIndex', 'createTrip', 'editTrip']) }}">
                <a class="d-flex align-items-center" href="{{ route('tripIndex') }}">
                    <i class="fa-solid fa-arrow-up-from-water-pump"></i>
                    <span class="menu-title text-truncate">{{ __('models.trips') }}</span>
                </a>
            </li>
        </ul>
        {{-- bookings --}}

        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.booking.index', 'admin.booking.create', 'admin.booking.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.booking.index') }}">
                    <i class="fa-solid fa-arrow-up-from-water-pump"></i>
                    <span class="menu-title text-truncate">{{ __('models.bookings') }}</span>
                </a>
            </li>
        </ul>
        {{-- offers --}}

        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.offers.index', 'admin.offers.create', 'admin.offers.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.offers.index') }}">
                    <i class="fa-solid fa-arrow-up-from-water-pump"></i>
                    <span class="menu-title text-truncate">{{ __('models.offers') }}</span>
                </a>
            </li>
        </ul>
        {{-- Qr codes --}}

        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.qrcodes.index', 'admin.qrcodes.create', 'admin.qrcodes.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.qrcodes.index') }}">
                    <i class="fa-solid fa-arrow-up-from-water-pump"></i>
                    <span class="menu-title text-truncate">{{ __('models.qrcodes') }}</span>
                </a>
            </li>
        </ul>

        {{-- services --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.services.index', 'admin.services.create', 'admin.services.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.services.index') }}"><i
                        class="fa-solid fa-star"></i><span
                        class="menu-title text-truncate">{{ __('models.services') }}</span></a>
            </li>
        </ul> --}}

        {{-- values --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.values.index', 'admin.values.create', 'admin.values.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.values.index') }}"><i class="fa-solid fa-arrow-up-from-water-pump"></i><span
                        class="menu-title text-truncate">{{ __('models.values') }}</span></a>
            </li>
        </ul> --}}


        {{-- solutions --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.solutions.index', 'admin.solutions.create', 'admin.solutions.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.solutions.index') }}"><i
                        class="fa-solid fa-lightbulb"></i><span
                        class="menu-title text-truncate">{{ __('models.solutions') }}</span></a>
            </li>
        </ul> --}}

        {{-- brands --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.brands.index', 'admin.brands.create', 'admin.brands.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.brands.index') }}"><i
                        class="fa-solid fa-tag"></i><span
                        class="menu-title text-truncate">{{ __('models.brands') }}</span></a>
            </li>
        </ul> --}}

        {{-- partners --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.partners.index', 'admin.partners.create', 'admin.partners.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.partners.index') }}"><i
                        class="fa-solid fa-handshake"></i><span
                        class="menu-title text-truncate">{{ __('models.partners') }}</span></a>
            </li>
        </ul> --}}

        {{-- customers --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.clients.index', 'admin.clients.create', 'admin.clients.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.clients.index') }}"><i
                        class="fa-solid fa-user-tie"></i><span
                        class="menu-title text-truncate">{{ __('models.clients') }}</span></a>
            </li>
        </ul> --}}

        {{-- jobs --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ areActiveRoutes(['admin.jobs.index', 'admin.jobs.create', 'admin.jobs.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.jobs.index') }}">
                    <i class="fa-solid fa-suitcase"></i><span
                        class="menu-title text-truncate">{{ __('models.jobs') }}</span>
                </a>
            </li>
        </ul> --}}

        {{-- job applications --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.job-applications.index', 'admin.job-applications.create', 'admin.job-applications.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.job-applications.index') }}">
                    <i class="fa-solid fa-file"></i><span
                        class="menu-title text-truncate">{{ __('models.job_applications') }}</span>
                </a>
            </li>
        </ul> --}}

        {{-- sectors --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.sectors.index', 'admin.sectors.create', 'admin.sectors.edit']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.sectors.index') }}">
                    <i class="fa-solid fa-puzzle-piece"></i><span
                        class="menu-title text-truncate">{{ __('models.sectors') }}</span>
                </a>
            </li>
        </ul> --}}

        {{-- videos --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li
                class="nav-item {{ areActiveRoutes(['admin.videos.index', 'admin.videos.create', 'admin.videos.edit', 'admin.videos.show']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.videos.index') }}"><i
                        class="fa-solid fa-video"></i><span class="menu-title text-truncate">{{ __('models.videos') }}</span></a>
            </li>
        </ul> --}}

        {{-- contacts --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ areActiveRoutes(['admin.contacts.index', 'admin.contacts.show']) }}">
                <a class="d-flex align-items-center" href="{{ route('admin.contacts.index') }}"><i
                        class="fa-solid fa-inbox"></i><span
                        class="menu-title text-truncate">{{ __('models.contact_msgs') }}</span></a>
            </li>
        </ul> --}}

        {{-- settings --}}
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ isActiveRoute('admin.settings.edit') }}"><a class="d-flex align-items-center"
                    href="{{ route('admin.settings.edit') }}"><i class="fa-solid fa-gear"></i><span
                        class="menu-title text-truncate">{{ __('models.settings') }}</span></a>
            </li>
        </ul> --}}

    </div>
</div>
<!-- END: Main Menu-->
