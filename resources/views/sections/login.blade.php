<div class="modal fade"
    id="loginModal"
    tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div
            class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title">{{__('Required action')}}</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>
                    {{__('To continue you need to log in')}}
                </p>
                <a href="{{route('social.auth')}}"
                    class="btn btn-primary mb-5">
                    {{__('Login')}}
                </a>
            </div>
        </div>
    </div>
</div>
