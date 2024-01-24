export function bytesToSize(bytes) {
    const sizes = ['Байт', 'КБ', 'МБ', 'ГБ', 'ТБ']
    if (!bytes) {
        return '0 Байт'
    }
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)))
    return Math.round(bytes / Math.pow(1024, i)) + ' ' + sizes[i]
}

export function strSlug(str) {
    const converter = {
        а: "a",
        б: "b",
        в: "v",
        г: "g",
        д: "d",
        е: "e",
        ё: "e",
        ж: "zh",
        з: "z",
        и: "i",
        й: "y",
        к: "k",
        л: "l",
        м: "m",
        н: "n",
        о: "o",
        п: "p",
        р: "r",
        с: "s",
        т: "t",
        у: "u",
        ф: "f",
        х: "h",
        ц: "c",
        ч: "ch",
        ш: "sh",
        щ: "sch",
        ь: "",
        ы: "y",
        ъ: "",
        э: "e",
        ю: "yu",
        я: "ya",
    }

    str = str.toLowerCase()

    let slug = ''
    for (let i = 0; i < str.length; ++i) {
        if (converter[str[i]] === undefined) {
            slug += str[i]
        } else {
            slug += converter[str[i]]
        }
    }

    slug = slug.replace(/[^-0-9a-z]/g, '-')
    slug = slug.replace(/[-]+/g, '-')
    slug = slug.replace(/^\-|-$/g, '')
    return slug
}
