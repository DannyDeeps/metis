{% extends "@canvases/layouts/end.twig" canvas={} %}

{% block canvas-id %}event{% endblock %}

{% block canvas-title %}Event{% endblock %}

{% block canvas-body %}
    <ul class="nav nav-tabs">
        {% for eventType in allFormFields|keys %}
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#{{ eventType|lower }}-tab">
                    {{ eventType|pascaltodisplay }}
                </button>
            </li>
        {% endfor %}
    </ul>

    <div class="tab-content p-2">
        {% for eventType, formFields in allFormFields %}
            <div class="tab-pane fade" id="{{ eventType|lower }}-tab" role="tabpanel">
                <form method="post" class="form">
                    <input type="hidden" name="action" value="create{{ eventType }}">
                    {% for name, field in formFields %}
                        <div class="form-floating mb-3 text-dark">
                            {{ include('@forms/inputs/' ~ field.type ~ '.twig', { name: name, field: field }) }}
                        </div>
                    {% endfor %}
                    <button class="btn btn-sm btn-success" type="submit">Create</button>
                </form>
            </div>
        {% endfor %}
    </div>
{% endblock %}