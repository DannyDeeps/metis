<textarea
    class="form-control form-control-sm"
    id="{$name}_input"
    placeholder="{$field.display}"

    {if !empty($field.required)}
        required
    {/if}
></textarea>

<label for="{$name}_input">
    {$field.display}
</label>