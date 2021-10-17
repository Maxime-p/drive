document.addEventListener('DOMContentLoaded', () => {
    const addButton = document.querySelector('#add-item')

    function addItem() {
        const list = document.querySelector('#files-upload')
        let count = list.getAttribute('widget-counter') || list.children.length - 2

        let newWidget = list.getAttribute('data-prototype')
        newWidget = newWidget.replace(/__name__/g, count);

        list.setAttribute('widget-counter', (++count).toString());

        const div = document.createElement('div')
        div.classList.add('entry')

        div.innerHTML = newWidget
        list.appendChild(div)
    }

    addItem()

    addButton.addEventListener('click', () => {
        addItem()
    })
})