document.addEventListener('DOMContentLoaded', () => {
    const openButton = document.querySelector('.modal-open')
    const closeButton = document.querySelector('.modal-close')

    class modal{
        static elem = document.querySelector('.modal')

        static getElem() {
            return this.elem
        }

        static isOpened() {
            return this.elem.classList.contains('show')
        }

        static show() {
            this.elem.classList.add('show');
        }

        static hide() {
            this.elem.classList.remove('show')
        }

    }

    openButton.addEventListener('click', () => {
        modal.show()
    })

    closeButton.addEventListener('click', () => {
        modal.hide()
    })

    window.addEventListener('click', (event) => {
        if (event.target === modal.getElem()){
            modal.hide()
        }
    })
})