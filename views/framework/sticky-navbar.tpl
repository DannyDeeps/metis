<div class="ui borderless main menu">
    <a href="/" class="sidebar-title mb-md-0 me-md-auto">
        <span class="fs-4">Metis</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        {foreach $pageLinks as $pageLink}
            <li class="nav-item">
                <a href="{$pageLink.location}" class="nav-link" aria-current="page">
                    {if $pageLink.icon} <i class="me-1 fas {$pageLink.icon}"></i> {/if} {$pageLink.title}
                </a>
            </li>
        {/foreach}
    </ul>
</div>