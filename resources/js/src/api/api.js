import axios from "axios";

export function getPosts() {
    return axios.get(`/api/admin/post/`)
}

export function getPost(id) {
    return axios.get(`/api/admin/post/${id}`)
}

export function updatePost(post) {
    return axios.post(`/api/admin/post/${post.id}`, post)
}

export function uploadImages(images) {
    const data = new FormData()
    Object.entries(images).forEach(([key, image]) => {
        if (typeof image.type === 'object') {
            Object.entries(image).forEach(([field, value]) => {
                data.append(`images[${key}][${field}]`, value)
            })
        } else if (typeof image.type === 'string') {
            data.append('preview', image)
        } else  if (typeof image === 'string') {
            data.append('oldPreview', image)
        }

    })
    return axios.post('/api/admin/post/images', data)
}

export function getCategories() {
    return axios.get(`/api/admin/category/`)
}

export function getContentBlocks() {
    return axios.get(`/api/admin/content-block/`)
}

export function getContentBlock(id) {
    return axios.get(`/api/admin/content-block/${id}`)
}

export function getImages() {
    return axios.get(`/api/admin/image/`)
}
