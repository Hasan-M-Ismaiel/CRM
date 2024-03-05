<div aria-live="polite" aria-atomic="true" class="position-relative " >
    <div class="toast-container position-absolute top-0 end-0 p-3" >
        <!-- Then put toasts within -->
    
        <a id="toast_link_to_notification_target" href="" style="text-decoration: none;">
            <!--the toast-->
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; bottom: 7; right:2;">
                <div class="toast-header">
                    <!--image-->
                    <img id="toast_image" src="" class="rounded-circle me-2" alt="image" width="40" height="40">
                    <!--grating-->
                    <strong id="toast_title" class="me-auto">Hello {{Auth::user()->name}},</strong>
                    <button href="" type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <!--the content-->
                <div class="toast-body" id="toast_content"></div>
            </div>
        </a>
    </div>
</div>