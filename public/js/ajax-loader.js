import {ElemHandler} from "./helpers/ElemHandler.js";
import {Requester} from "./helpers/Requester.js";

let initAjaxCard = (dom, afterLoad) => {
    let elem = ElemHandler.init(dom).bind('reload', () => {
        let url = dom.getAttribute('data-url');
        Requester.init().URL(url).setHeaders({
            Accept: 'application/json',
        }).onError((code, statusText, message) => {
            console.log(code, statusText, message)
        }).onSuccess((response) => {
            try{
                response = JSON.parse(response);
                afterLoad(response);
            }catch (ex){}
        }).onProgress((event) => {
            console.log(event);
        }).get();
    }).trigger('reload');

    setInterval(() => {
        elem.trigger('reload');
    }, 10000);

}

let tableHtml = {
    aLink: (link) => {
        return `<a href="${link}" target="_blank" class="btn btn-primary">عرض</a>`;
    },
    tr: (html) => {
        return `<tr>${html}</tr>`;
    },
    td: (html) => {
        return `<td>${html}</td>`;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    let ridingCard = document.querySelector('.riding-ajax-loader'),
        activeCard = document.querySelector('.active-ajax-loader'),
        offlineCard = document.querySelector('.offline-ajax-loader');

    initAjaxCard(ridingCard, (response) => {
        if(!response.success) return;
        let html = "";
        response.data.forEach((row) => {
            html += tableHtml.tr(
                tableHtml.td(row.name) +
                tableHtml.td(row.active_ride.id) +
                tableHtml.td(row.active_ride.status) +
                tableHtml.td(tableHtml.aLink(ridingCard.getAttribute('data-route') + '/' + row.active_ride.id))
            );
        });
        ridingCard.innerHTML = html;
    });

    initAjaxCard(activeCard, (response) => {
        if(!response.success) return;
        let html = "";
        response.data.forEach((row) => {
            html += tableHtml.tr(
                tableHtml.td(row.name) +
                tableHtml.td(row.gender) +
                tableHtml.td(row.phone_number) +
                tableHtml.td(tableHtml.aLink(activeCard.getAttribute('data-route') + '/' + row.id))
            );
        });
        activeCard.innerHTML = html;
    });

    initAjaxCard(offlineCard, (response) => {
        if(!response.success) return;
        let html = "";
        response.data.forEach((row) => {
            html += tableHtml.tr(
                tableHtml.td(row.name) +
                tableHtml.td(row.gender) +
                tableHtml.td(row.phone_number) +
                tableHtml.td(tableHtml.aLink(offlineCard.getAttribute('data-route') + '/' + row.id))
            );
        });
        offlineCard.innerHTML = html;
    });

});

