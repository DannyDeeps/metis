{extends 'layouts/page.tpl'}

{block 'content'}

    <div class="container-fluid">
        {foreach $eventTypes as $type => $events}
            <div class="fw-bold">{$type}</div>
            <div class="event-container">
                {foreach $events as $event}
                    {include 'tiles/event.tpl' event=$event}
                {/foreach}
            </div>
        {/foreach}
    </div>

    <button class="event-canvas-btn">
        Event Canvas
    </button>

{/block}