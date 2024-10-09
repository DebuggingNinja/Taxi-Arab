export class Requester{

    static init(){
        return new Requester();
    }

    constructor() {
        this.successCallback = (response) => console.log(response)
        this.progressCallBack = (event) => {
            if (event.lengthComputable) {
                let percentage = ((event.loaded / event.total) * 100).toFixed(2) + '%';
                console.log(percentage);
            }
        }
        this.errorCallback = (errorCode, errorMessage, message) => {
            console.log("Error: " + errorMessage + ", Code (" + errorCode + ")", message);
        }
    }
    post(){
        return this.call("POST");
    }

    get(){
        return this.call("GET");
    }

    patch(){
        return this.call("PUT");
    }

    delete(){
        return this.call("DELETE");
    }

    call(requestMethod){
        let xhr = new XMLHttpRequest();
        xhr.open(requestMethod, this.url, true);
        for (const [name, value] of Object.entries(this.headers)) {
            xhr.setRequestHeader(name, value);
        }
        let success = this.successCallback, error = this.errorCallback;
        xhr.onload = () => {
            if (xhr.status >= 200 && xhr.status < 300) success(xhr.responseText);
            else error(xhr.status, xhr.statusText, xhr.responseText);
        };

        xhr.upload.addEventListener('progress', (event) => {
            this.progressCallBack(event);
        });

        xhr.onerror = () => {
            this.errorCallback(0, "request failed")
        };

        if(requestMethod === "PUT"){
            xhr.send(this.toUrlParams(this.formData));
        }
        else xhr.send(this.formData);

        return this;
    }

    URL(url){
        this.url = url;
        return this;
    }

    onProgress(callback){
        this.progressCallBack = callback;
        return this;
    }

    onError(callback){
        this.errorCallback = callback;
        return this;
    }

    onSuccess(callback){
        this.successCallback = callback;
        return this;
    }

    setHeaders(headers){
        this.headers = headers;
        return this;
    }

    setFormData(formData){
        this.formData = formData;
        return this;
    }

    toUrlParams(formData){
        return (new URLSearchParams(formData)).toString();
    }

}
