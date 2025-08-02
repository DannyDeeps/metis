<input
    type="datetime-local"
    class="form-control form-control-sm"

    id="{$name}_input"
    name="{$name}"
    placeholder="{$field.display}"

    {if !empty($field.required)}
        required
    {/if}
>

<label for="{$name}_input">
    {$field.display}
</label>