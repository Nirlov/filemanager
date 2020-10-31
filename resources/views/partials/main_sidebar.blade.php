<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="list-group list-group-flush">
        <a href="{{ route('home') }}" class="list-group-item list-group-item-action bg-light {{ Request::path() == 'home'?'active':'' }}">Dashboard</a>
        <a href="{{ route('content_bank_index') }}" class="list-group-item list-group-item-action bg-light {{ Request::path() == 'filemanager'?'active':'' }}">Content Bank</a>
        <a href="{{ route('setting_index') }}" class="list-group-item list-group-item-action bg-light {{ Request::path() == 'filemanager/setting'?'active':'' }}">Setting</a>
    </div>
</div>