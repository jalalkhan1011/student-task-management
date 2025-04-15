<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ __('Student Management') }} {{ Auth::user()->role ?: '' }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        @if (Auth::user()->role == 'Headmaster' || Auth::user()->role == 'Teacher')
            <a class="nav-link collapsed" href="{{ route('students.index') }}">
                <i class="fas fa-fw fa-solid fa-user-graduate"></i>
                <span>{{ __('Students') }}</span>
            </a>
        @endif
        @if (Auth::user()->role == 'Teacher')
            <a class="nav-link collapsed" href="{{ route('tasks.index') }}">
                <i class="fas fa-fw fa-solid fa-user-graduate"></i>
                <span>{{ __('Tasks') }}</span>
            </a>
        @endif
        @if (Auth::user()->role == 'Headmaster')
            <a class="nav-link collapsed" href="{{ route('task.pending') }}">
                <i class="fas fa-fw fa-solid fa-user-graduate"></i>
                <span>{{ __('Pending Tasks') }}</span>
            </a>
        @endif
        @if (Auth::user()->role == 'Student')
            <a class="nav-link collapsed" href="{{ route('assign.task') }}">
                <i class="fas fa-fw fa-solid fa-user-graduate"></i>
                <span>{{ __('Assign Tasks') }}</span>
            </a>
        @endif
        @if (Auth::user()->role == 'Headmaster')
            <a class="nav-link collapsed" href="{{ route('announcements.index') }}">
                <i class="fas fa-fw fa-solid fa-user-graduate"></i>
                <span>{{ __('Announcement') }}</span>
            </a>
        @endif
    </li> 
    
    <!-- Divider -->
    <hr class="sidebar-divider"> 
    <!-- Divider --> 

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
