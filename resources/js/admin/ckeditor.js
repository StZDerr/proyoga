import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

class LaravelUploadAdapter {
    constructor(loader, uploadUrl) {
        this.loader = loader;
        this.uploadUrl = uploadUrl;
    }

    upload() {
        return this.loader.file.then((file) => {
            return new Promise((resolve, reject) => {
                const data = new FormData();
                data.append("upload", file);

                fetch(this.uploadUrl, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN":
                            document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute("content") ?? "",
                    },
                    body: data,
                })
                    .then((response) => response.json())
                    .then((result) => {
                        if (!result.url) {
                            reject("Ошибка загрузки изображения");
                            return;
                        }

                        resolve({
                            default: result.url,
                        });
                    })
                    .catch((error) => reject(error));
            });
        });
    }

    abort() {}
}

function uploadAdapterPlugin(uploadUrl) {
    return (editor) => {
        editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
            return new LaravelUploadAdapter(loader, uploadUrl);
        };
    };
}

function initCkEditor() {
    const editorFields = document.querySelectorAll("textarea[data-ckeditor]");

    if (!editorFields.length) {
        return;
    }

    editorFields.forEach((field) => {
        const uploadUrl = field.dataset.uploadUrl;
        const config = {
            language: "ru",
            toolbar: [
                "heading",
                "|",
                "bold",
                "italic",
                "underline",
                "|",
                "link",
                "bulletedList",
                "numberedList",
                "|",
                "blockQuote",
                "insertTable",
                "|",
                "undo",
                "redo",
            ],
        };

        if (uploadUrl) {
            config.extraPlugins = [uploadAdapterPlugin(uploadUrl)];
            config.toolbar.splice(11, 0, "uploadImage");
        }

        ClassicEditor.create(field, config).catch((error) => {
            console.error("Ошибка инициализации CKEditor:", error);
        });
    });
}

document.addEventListener("DOMContentLoaded", initCkEditor);
