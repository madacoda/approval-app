<div id="sidebar-menu">
    <ul class="sidebar-links" id="simple-bar">
        <li class="back-btn"><a href="{{ route('dashboard') }}"><img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
        </li>
        <li class="sidebar-main-title">
            <div>
            <h6 class="lan-1">Welcome</h6>
            <p class="lan-2">PNM Test - Approval App</p>
            </div>
        </li>
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="#"><i data-feather="home"></i><span class="lan-3">Dashboard</span></a>
            <ul class="sidebar-submenu">
            <li><a class="lan-4" href="{{ route('dashboard') }}">Dashboard</a></li>
            </ul>
        </li>
        <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="layout"></i><span class="lan-7">Master</span></a>
            <ul class="sidebar-submenu">
            <li><a href="{{ route('master.approval-category.index') }}">Approval Category</a></li>
            <li><a href="{{ route('master.job-position.index') }}">Job Position</a></li>
            </ul>
        </li>
        <li class="sidebar-main-title">
            <div>
            <h6 class="lan-8">Applications</h6>
            <p class="lan-9"></p>
            </div>
        </li>
        <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('user.index') }}"><i data-feather="users"> </i><span>Users</span></a></li>
        <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('approval.index') }}"><i data-feather="file-text"></i><span>Approvals</span></a></li>
    </ul>
</div>