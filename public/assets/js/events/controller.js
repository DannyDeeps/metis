$(() => {
    $(document).on('submit', '.new-event-form', (e) => {
        e.preventDefault()

        let data= $(e.currentTarget).serializeArray()

        $.post('/ajax/events', data, (response) => {

            if (response.success) {
                notyf.success('Event Created')
            } else {
                notfy.error(response.message)
            }

        }, 'JSON')
    })

    $(document).on('click', '.event-canvas-btn', (e) => {
        $.post('/ajax/events', { action: 'canvas' }, (response) => {
            if (response.success) {
                $('body').append(response.data.html)

            } else {
                notfy.error(response.message)
            }

        }, 'JSON')
    })
})