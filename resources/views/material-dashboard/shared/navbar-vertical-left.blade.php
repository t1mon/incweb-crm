{{--{{--}}
{{--{{    dd(\Illuminate\Support\Facades\Route::current()->project) }}--}}
{{--    dd(request()->route()->named('project.*'))--}}
{{--}}--}}
<aside class=" border-0 rounded-0 border-radius-xl bg-gradient-dark mb-2">
    <div class="d-flex p-2 justify-content-between align-items-center gap-3 flex-wrap flex-sm-nowrap">

        <div class="d-flex align-items-center gap-3">
            <a class="navbar-brand m-0 p-0" href="{{ route('home') }}">
                <!--GIT ИЗМЕНЕНИЯ <img src="{{ asset('media/img/logo/logo.svg') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">PRO</span> -->
                <span class="ms-1 font-weight-bold text-white">MLeads</span>
            </a>

{{--            <dark-mode></dark-mode>--}}
        </div>

        <header-search></header-search>
        @auth()
        <div class="dropdown">
            <a id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false" class="text-white d-flex justify-content-center align-items-center" aria-controls="ProfileNav" role="button">
{{--                <img src="{{ asset('media/img/avatar.jpg') }}" class="avatar">--}}
                <span class="nav-link-text ps-1"> {{ Auth::user()->name }} </span>
            </a>

            <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownProfile">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white m-0 rounded-0 p-2 d-flex align-items-center" href="{{ route('users.show', Auth::user()) }}">
                            <span class="sidenav-mini-icon font-weight-bolder"> MP </span>
                            <span class="sidenav-normal ps-1"> {{ __('users.public_profile') }} </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white m-0 rounded-0 p-2 d-flex align-items-center" href=" {{ route('users.edit') }} ">
                            <i class="material-icons-round opacity-10">manage_accounts</i>
                            <span class="sidenav-normal ps-1">{{ __('users.settings') }} </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/logout') }}"
                           class="nav-link text-white m-0 rounded-0 p-2 d-flex align-items-center"
                           onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <i class="material-icons-round opacity-10">logout</i>
                            <span class="sidenav-normal ps-1"> @lang('auth.logout') </span>
                        </a>

                        <form id="logout-form" class="d-none" action="{{ url('/logout') }}" method="POST">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        @endauth
    </div>
    <hr class="horizontal light m-0">
    <div class="w-auto h-auto max-height-vh-100 h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav align-items-center flex-row d-flex justify-content-between">
            @auth()
                <li class="nav-item">
                    <a class="nav-link m-0 rounded-0 px-2 d-flex align-items-center gap-1" href="{{ route('home') }}">
                        <i class="material-icons-round opacity-10 text-success">house</i>
                        <span class="nav-link-text text-success">Главная</span>
                    </a>
                </li>

                <div class="d-flex align-items-center gap-3 pe-2">
                    @if(request()->route()->named('project.*') && !request()->route()->named('project.index'))
                        <div class="d-flex gap-3 align-items-center">
                            <li data-britva-popup class="nav-item">
                                <a data-britva-popup-trigger href="#" class="nav-link text-white active m-0 px-2 rounded-0 collapsed d-flex align-items-center gap-1">
                                    <i class="material-icons-round opacity-10">expand_more</i>
                                    <span class="nav-link-text">Проекты</span>
                                </a>
                                <div data-britva-popup-menu class="britva__popup-menu" >
                                    <i data-britva-popup-close class="material-icons-round britva__popup-menu__close">close</i>
                                    <navbar-projects :projects="{{auth()->user()->getAllprojects()}}"></navbar-projects>
                                </div>
                            </li>

                            <li class="nav-item">
                                <div class="dropdown">
                                    <a class="d-flex" id="dropdownProjectMenu" data-bs-toggle="dropdown" aria-expanded="false" href="">
                                        <i class="material-icons-round text-light">menu</i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownProjectMenu">
                                        <ul class="navbar-nav">
                                            <li class="nav-item {{ request()->route()->named('project.journal') ? 'active' : '' }}">
                                                <a class="nav-link m-0 rounded-0 d-flex align-items-center gap-2 p-2 {{ request()->route()->named('project.journal') ? 'active' : '' }}" href="{{ route('project.journal', $project ) }}">
                                                    <i class="material-icons-round opacity-10">text_snippet</i>
                                                    <span class="nav-link-text">ЕЖЛ</span>
                                                </a>
                                            </li>

                                            <hr class="horizontal light m-0">

                                            @if($project->isOwner() or Auth::user()->isManagerFor($project))
                                                <li class="nav-item {{ request()->route()->named('project.journal') ? 'active' : '' }}">
                                                    <a class="d-flex align-items-center gap-2 p-2 nav-link m-0 rounded-0 {{ request()->route()->named('project.log') ? 'active' : '' }}" href="{{ route('project.log', $project ) }}">
                                                        <i class="material-icons-round opacity-10">notes</i>
                                                        <span class="nav-link-text">Лог</span>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                </div>
                            </li>
                        </div>
                    @endif
                    @if(request()->route()->named('project.*') && !request()->route()->named('project.index'))

                        @if($project->isOwner() or Auth::user()->isManagerFor($project))

                            <li class="nav-item dropdown">
                                <a id="dropdownProjectSettings" data-bs-toggle="dropdown" aria-expanded="false" class="nav-link text-white m-0 rounded-0 p-0  d-flex align-items-center" aria-controls="pagesExamples" role="button">
                                    <i class="material-icons-round">settings</i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownProjectSettings">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link text-white m-0 rounded-0" href={{route('project.settings-basic', $project)}}>
                                                <span class="sidenav-normal  ms-2  ps-1"> Основное </span>
                                            </a>
                                        </li>

                                        <hr class="horizontal light m-0">

                                        <li class="nav-item ">
                                            <a class="nav-link text-white m-0 rounded-0" href={{route('project.settings-sync', $project)}}>
                                                <span class="sidenav-normal  ms-2  ps-1"> Синхронизации </span>
                                            </a>
                                        </li>

                                        <hr class="horizontal light m-0">

                                        <li class="nav-item ">
                                            <a class="nav-link text-white m-0 rounded-0" href={{route('project.token', $project->id)}}>
                                                <span class="sidenav-normal  ms-2  ps-1"> @lang('projects.sidebar.integrations') </span>
                                            </a>
                                        </li>

                                        <hr class="horizontal light m-0">

                                        <li class="nav-item ">
                                            <a class="nav-link text-white " href={{route('project.integrations', $project->id)}}>
                                                <span class="sidenav-normal  ms-2  ps-1"> (+) Интеграции </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                    @endif
                </div>

            @endauth

        </ul>
    </div>
    <hr class="horizontal light m-0">
</aside>
