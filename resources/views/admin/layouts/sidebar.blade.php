<nav class="sidenav navbar navbar-vertical {{App::isLocale('fa')?'fixed-right':'fixed-left'}} navbar-expand-xs navbar-dark bg-white p-0"
     id="sidenav-main">
    <!-- Brand -->
    <div class="sidenav-header d-flex flex-md-column align-items-center justify-content-center">
        <a class="navbar-brand p-1" href="{{url('/')}}">
            <img src="{{asset('img/'.$panel_settings->logo)}}" class="navbar-brand-img" alt="...">
        </a>
        <h1 class="m-0 p-2 text-light">{{$panel_settings->title}}</h1>
        <div class="ml-auto d-none">
            <!-- Sidenav toggler -->
            <div class="sidenav-toggler d-none" data-action="sidenav-unpin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Nav items -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{$current_route=='/admin/home'?'active':''}}" href="<?=url('admin')?>"> <i
                                class="fad fa-chart-area text-green"></i><span class="nav-link-text">داشبورد</span> </a>
                </li>
                @canany(['admin.browse','role.browse','permission.browse'])
                    <li class="nav-item">
                        <a class="nav-link {{$current_route=='/admin/admins'||$current_route=='/admin/roles'||$current_route=='/admin/permissions'?'active':''}}"
                           href="#navbar-admins" data-toggle="collapse" role="button" aria-expanded="false"
                           aria-controls="navbar-admins">
                            <i class="fad fa-users-crown text-yellow"></i><span
                                    class="nav-link-text">مدیریت ادمین</span>
                        </a>
                        <div class="collapse {{$current_route=='/admin/admins'||$current_route=='/admin/roles'||$current_route=='/admin/permissions'?'show':''}}"
                             id="navbar-admins">
                            <ul class="nav nav-sm flex-column">
                                @can('admin.browse')
                                    <li class="nav-item"><a href="<?=url('admin/admins')?>"
                                                            class="nav-link {{$current_route=='/admin/admins'?'active':''}}"><i
                                                    class="fad fa-user-shield text-yellow"></i> لیست ادمین ها</a>
                                    </li> @endcan
                                @can('role.browse')
                                    <li class="nav-item"><a href="<?=url('admin/roles')?>"
                                                            class="nav-link {{$current_route=='/admin/roles'?'active':''}}"><i
                                                    class="fad fa-user-tag text-yellow"></i> گروه بندی دسترسی</a>
                                    </li> @endcan
                                @can('permission.browse') <!-- <li class="nav-item"><a href="<?=url('admin/permissions')?>" class="nav-link {{$current_route=='/admin/permissions'?'active':''}}"><i class="fad fa-user-lock text-yellow"></i> تعریف دسترسی</a></li> --> @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @can('product.browse')
                    <li class="nav-item">
                        <a class="nav-link {{$current_route=='/admin/products'?'active':''}}"
                           href="<?=url('admin/products');?>"><i class="fab fa-product-hunt text-green"></i> <span
                                    class="nav-link-text">لیست محصولات</span></a>
                    </li>
                @endcan
                @can('order.browse')
                    <li class="nav-item">
                        <a class="nav-link {{$current_route=='/admin/orders'?'active':''}}"
                           href="<?=url('admin/orders');?>"><i class="far fa-shopping-cart text-blue"></i> <span
                                    class="nav-link-text">لیست سفارشات</span></a>
                    </li>
                @endcan
                @can('payment.browse')
                    <li class="nav-item">
                        <a class="nav-link {{$current_route=='/admin/payments'?'active':''}}"
                           href="<?=url('admin/payments');?>"><i class="fad fa-usd-circle text-red"></i> <span
                                    class="nav-link-text">لیست پرداخت ها</span></a>
                    </li>
                @endcan
                @can('article.browse')
                    <li class="nav-item">
                        <a class="nav-link {{$current_route=='/admin/articles'?'active':''}}"
                           href="<?=url('admin/articles');?>"><i class="fab fa-blogger-b text-orange"></i> <span
                                    class="nav-link-text">لیست مقالات</span></a>
                    </li>
                @endcan
                @can('category.browse')
                    <li class="nav-item">
                        <a class="nav-link {{$current_route=='/admin/categories'?'active':''}}"
                           href="<?=url('admin/categories');?>"><i class="fad fa-list text-blue
"></i> <span class="nav-link-text">لیست دسته بندی </span></a>
                    </li>
                @endcan
                @can('menu.browse')
                    <li class="nav-item">
                        <a class="nav-link {{$current_route=='/admin/menus'?'active':''}}"
                           href="{{route('menus.index')}}"><i class="fad fa-list text-blue
"></i> <span class="nav-link-text">لیست منو </span></a>
                    </li>
                @endcan

                @can('notification.browse')
                    <li class="nav-item">
                        <a class="nav-link {{$current_route==route('notification.email.showForm')
                        ||$current_route=route('notification.sms.showForm')?'active':''}}" href="#navbar-notification"
                           data-toggle="collapse" role="button" aria-expanded="false"
                           aria-controls="navbar-notification">
                            <i class="fad fa-bell text-neutral"></i><span class="nav-link-text">اطلاع رسانی</span>
                        </a>
                        <div class="collapse
                        {{$current_route==route('notification.email.showForm')
                        ||$current_route=route('notification.sms.showForm')?'show
':''}}" id="navbar-notification">
                            <ul class="nav nav-sm flex-column">
                                @can('notification.browse')
                                    <li class="nav-item"><a href="{{route('notification.email.showForm')}}" class="nav-link
{{$current_route==route('notification.email.showForm')?'active':''}}"><i class="fad fa-envelope text-yellow"></i>
                                            ارسال ایمیل </a>
                                    </li>
                                @endcan
                                @can('notification.browse')
                                    <li class="nav-item"><a href="{{route('notification.sms.showForm')}}" class="nav-link
{{$current_route==route('notification.sms.showForm')?'active':''}}"><i class="fad fa-sms text-green"></i>
                                            ارسال پیام کوتاه </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                @can('about_us.browse')
                    <li class="nav-item">
                        <a class="nav-link {{$current_route=='/admin/about_us'?'active':''}}"
                           href="<?=url('admin/about_us');?>"><i class="fad fa-receipt text-orange"></i> <span
                                    class="nav-link-text">درباره ما</span></a>
                    </li>
                @endcan
                @can('panel_settings.browse')
                    <hr class="my-1 w-75 border-light">
                    <li class="nav-item">
                        <a class="nav-link {{$current_route=='/admin/panel_settings'?'active':''}}"
                           href="<?=url('admin/panel_settings');?>"><i class="fad fa-sliders-h-square text-gray"></i>
                            <span class="nav-link-text">تنظیمات پنل</span></a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</nav>
    
