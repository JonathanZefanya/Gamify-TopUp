@if(isset($template['authentication']) && $loginRegister = $template['authentication'][0])
    <div class="col-lg-6 d-none d-lg-block">
        <div class="img-box">
            <img
                src="{{getFile(@$loginRegister->content->media->image->driver,@$loginRegister->content->media->image->path)}}"
                alt="...">
        </div>
    </div>
@endif
