function upload(inputId, options = {}) {

    const onUpload = options.onUpload ?? noop
    const input = document.getElementById(inputId)

    const dropzone = element('div', ['dropzone', 'post-images'])
    const dropzoneItems = element('div', ['dropzone-items'])
    input.closest(".form-group-dropzone").insertAdjacentElement('afterend', dropzone)
    dropzone.insertAdjacentElement('afterbegin', dropzoneItems)
    const uploadButton = element('div', [
        'btn',
        'btn-primary',
        'form_submit_button',
        'text-center',
    ], 'Загрузить')
    dropzone.insertAdjacentElement('afterend', uploadButton)
    uploadButton.style.display = 'none'

    let files = []
    const changeHandler = event => {
        if (!event.target.files.length) {
            return
        }
        uploadButton.style.display = 'inline'
        const newFiles = Array.from(event.target.files)

        newFiles.forEach(file => {
            if (!file.type.match('image')) {
                return
            }
            const reader = new FileReader()

            reader.onload = ev => {
                const src = ev.target.result

                const img = new Image();
                img.onload = function () {
                    dropzoneItems.insertAdjacentHTML('afterbegin', `
                   <div id="img_${file.name}" class="x-removeable dropzone-item zoom-in">
                        <button class="dropzone-remove" data-name="${file.name}" type="button">
                            <svg data-name="${file.name}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="fill-current w-5 h-5">
                                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <img src="${src}" alt="">
                        <div class="post-images__info">
                            <div>${file.name}</div>
                            <div>${this.width}x${this.height}</div>
                            <div>${bytesToSize(file.size)}</div>
                        </div>
                    </div>
                `)
                }
                img.src = src;


            }

            reader.readAsDataURL(file)
        })
        files = files.concat(newFiles)
    }


    const uploadHandler = async () => {
        dropzoneItems.querySelectorAll('.dropzone-remove')
            .forEach(e => e.remove())


        onUpload(files)
        console.log('files:', files)

        try {
            const imagesData = await fetch('/api/admin/image/', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: files,
            })
            const movie = await imagesData.json();
            console.log(movie)
            return imagesData
        } catch (err) {
            console.error('Произошла ошибка!', err)
        }
    }
    const removeHandler = event => {
        if (!event.target.dataset.name) {
            return
        }
        const {name} = event.target.dataset

        files = files.filter(file => file.name !== name)

        dropzoneItems.querySelector(`[data-name="${name}"]`)
            .closest('.dropzone-item')
            .remove()

        if (!files.length) {
            uploadButton.style.display = 'none'
        }
    }
    input.addEventListener('change', changeHandler)
    uploadButton.addEventListener('click', uploadHandler)
    dropzoneItems.addEventListener('click', removeHandler)

}

document.addEventListener('DOMContentLoaded', function () {

    upload(
        'content-block-images',
    )


});

function bytesToSize(bytes) {
    const sizes = ['Байт', 'КБ', 'МБ', 'ГБ', 'ТБ']
    if (!bytes) {
        return '0 Байт'
    }
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)))
    return Math.round(bytes / Math.pow(1024, i)) + ' ' + sizes[i]
}

const element = (tag, classes = [], content) => {
    const node = document.createElement(tag)

    if (classes.length) {
        node.classList.add(...classes)
    }

    if (content) {
        node.textContent = content
    }

    return node
}

function noop() {
}
