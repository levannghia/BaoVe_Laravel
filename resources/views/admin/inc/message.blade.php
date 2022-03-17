@if(Session::has("message"))
<div class="alert alert-success bg-{{Session::get("type")}} text-white border-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    {{Session::get("message")}}
</div>
@endif