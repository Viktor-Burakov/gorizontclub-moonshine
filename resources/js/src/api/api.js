import axios from "axios";

export function getPosts() {
    return axios.get(`/api/admin/post/`)
}

export function getPost(id) {
    return axios.get(`/api/admin/post/${id}`)
}

export function updatePost(post, images) {
    const data = new FormData();
    const uploadImages = [];
    Object.entries(post).forEach(([key, value]) => {

            if (typeof value === 'string' || typeof value === 'number') {
                data.append(key, value)
            } else if (value !== null) {
                Object.entries(value).forEach(([k, v]) => {
                    Object.entries(v).forEach(([k1, v1]) => {
                        if (k1 !== 'pivot') {
                            data.append(`${key}[${k}][${k1}]`, v1)

                            if (k1 === 'images') {
                                data.append(`${key}[${k1}][${k1}]`, v1['id'])
                                    Object.entries(v1).forEach(([k2, v2]) => {
                                        data.append(`${key}[${k}][${k1}][${k2}]`, v2['id'])
                                        data.append('attachImages[]', v2['id'])
                                    })
                            }
                        }
                    })

                })
            }


            // if (key === 'content_blocks') {
            //     Object.entries(value).forEach(([k, v]) => {
            //         data.append(`${key}[${k}]`, v['id'])
            //
            //     })
            // } else if (key === 'images') {
            //     Object.entries(value).forEach(([k, v]) => {
            //         data.append(`${key}[${k}]`, v['id'])
            //         uploadImages.push(images[v['id']])
            //
            //     })
            // } else if (key === 'categories') {
            //     Object.entries(value).forEach(([k, v]) => {
            //         data.append(`${key}[${k}]`, v['id'])
            //     });
            // } else {
            //     data.append(key, value)
            // }
        }
    )
    // uploadImages.forEach((value) => {
    //     data.append('attachImages[]', value['name'])
    // })

    console.log(data)

    return axios.post(`/api/admin/post/${post.id}`, post, {
        'accept': 'application/json',
        'Accept-Language': 'en-US,en;q=0.8',
        'Content-Type': 'multipart/form-data',
    })
}

function addImagesToUpload(key, value) {

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
