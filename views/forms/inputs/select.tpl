<select
    class="form-select"
    name="{$name}"
    id="{$name}_input"
    placeholder="{$field.display}"
>
    {html_options options=$field.setList}
</select>

<label for="{$name}_input">
    {$field.display}
</label>