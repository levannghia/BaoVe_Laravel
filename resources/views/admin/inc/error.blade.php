@if(count($errors)>0)
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-danger">
                <h5 class="card-title"><i class="fe-alert-triangle"></i> Đã xảy ra lỗi</h5>
                <ul style="margin: 0;padding: 0 15px;">
                    @foreach($errors->all() as $key => $value)
                    <li class="card-text">{{$value}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endif