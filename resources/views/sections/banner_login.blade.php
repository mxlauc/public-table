<div class="py-3 px-4 px-sm-5 mb-4 bg-light rounded-3 shadow-sm">
    <div class="row gy-3">
        <div class="col col-12 col-lg-8">
            <h1 class="display-5 fw-bold text-primary">
                {{ __('Join Public Table') }}
            </h1>
            <p class="col-md-8 fs-4 my-4">
                {{ __('Share content with other users. Create an account today.') }}
            </p>
            <a href="{{ route('social.auth') }}" class="btn btn-primary">
                {{ __('Login') }}
            </a>
        </div>
        <div class="col col-12 col-lg-4 d-none d-lg-block">
            <img src="/people.png" class="img-fluid">
            <br>
            <a href="http://www.freepik.com"
                target="_blank"
                class="text-muted text-decoration-none"
                style="font-size: 10px">
                {{ __('Designed by') }} pch.vector / Freepik
            </a>
        </div>
    </div>
</div>
