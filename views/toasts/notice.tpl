<div class="toast position-absolute top-0 start-50 translate-middle-x align-items-center text-white bg-{$notice->getStatus()} bg-gradient border-0 mt-2" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            {if !empty($notice->getIcon())}
                {$notice->getIcon()}
            {/if}
            {$notice->getPrevious()->getMessage()}
        </div>
        <div class="d-flex ms-auto">
            <button type="button" class="btn shadow-none text-light" data-bs-toggle="collapse" data-bs-target="#notice-info">
                <i class="fas fa-binoculars"></i>
            </button>
            <button type="button" class="btn shadow-none text-light" data-bs-dismiss="toast">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="collapse" id="notice-info">
        <div class="notice-info px-4 py-2 d-flex flex-column">
            <span class="text-wrap text-break">Thrown on line <strong>{$notice->getPrevious()->getLine()}</strong> in file <strong>{$notice->getPrevious()->getFile()}</strong></span>
        </div>
    </div>
</div>