<div class="modal fade"
    id="loginModal"
    tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div
            class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title">Acción necesaria</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>
                    Para continuar necesitas iniciar sesión
                </p>
                <a href="{{route('social.auth')}}"
                    class="btn btn-primary mb-5">
                    Iniciar sesión
                </a>
            </div>
        </div>
    </div>
</div>
