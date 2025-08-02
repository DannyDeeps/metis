{extends "layouts/page.tpl"}

{block "content"}
    <div class="row">
        {if !empty($events)}
            {foreach $events as $event}
                <div class="col-2">
                    <div class="card">
                        <div class="m-2">
                            {$event.getId}
                        </div>
                        <div class="m-2">
                            {$event.getUserId}
                        </div>
                        <div class="m-2">
                            {$event.getEventTypeId}
                        </div>
                        <div class="m-2">
                            {$event.getDescription}
                        </div>
                    </div>
                </div>
            {/foreach}
        {/if}
    </div>
{/block}