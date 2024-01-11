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

