<input
    type="text"
    class="form-control form-control-sm"

    id="{$name}_input"
    name="{$name}"
    placeholder="{$field.display}"

    {if !empty($field.maxLength)}
        maxlength="{$field.maxLength}"
    {/if}

    {if !empty($field.required)}
        required
    {/if}
>

<label for="{$name}_input">
    {$field.display}
</label>