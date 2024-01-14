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
