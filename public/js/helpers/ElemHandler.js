export class ElemHandler{

    constructor(elem) {
        this.elem = elem;
    }

    static init(elem){
        return new ElemHandler(elem)
    }

    bind(eventType, handler){
        if(!this.elem) return this;
        if (this.elem.addEventListener) this.elem.addEventListener(eventType, handler, false);
        else if (this.elem.attachEvent)  this.elem.attachEvent('on' + eventType, handler);
        else this.elem['on' + eventType] = handler;
        return this
    }

    trigger(eventType){
        let event;
        try{
            event = new Event(eventType, { bubbles: true, cancelable: true });
        }catch (ex){
            event = document.createEvent('Event');
            event.initEvent(eventType, true, true);
        }
        this.elem.dispatchEvent(event);
        return this
    }

}
