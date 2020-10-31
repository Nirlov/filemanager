@if(Session::has('alert_msg') && Session::has('alert_status'))
<div style="position: fixed; bottom: 15px; right: 0;" class="sufee-alert alert with-close alert-{{ Session::get('alert_status') }} alert-dismissible fade show">
    <span class="badge badge-pill badge-{{ Session::get('alert_status') }}">Success</span>
    {{ Session::get('alert_msg') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@endif