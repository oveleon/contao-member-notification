/**
 * Member Notification
 */
const MemberNotification = (function () {

    'use strict';

    return function (element) {

        const init = function () {
            let moduleCounter = element.querySelector('[data-mnc-count]');
            let notificationCount = !!moduleCounter ? parseInt(moduleCounter?.innerText) : -1;

            element.querySelectorAll('[data-mnc-notification]')?.forEach(function(item, index){
                let ncId    = item.dataset?.mncNotification;
                let handler = item.querySelectorAll('[data-mnc-read]');

                if(!ncId) return;

                handler?.forEach(function(handle){
                    handle.addEventListener('click', function closer(){
                        handle.removeEventListener('click', closer);

                        if(notificationCount >= 0){
                            moduleCounter.innerText = --notificationCount;
                        }

                        // Custom event
                        let event = new CustomEvent("mnc-count", {
                            detail: {
                                element: item,
                                counter: moduleCounter,
                                currentCount: notificationCount
                            }
                        });

                        window.dispatchEvent(event);

                        if('mncMark' in this.dataset){

                            if('mncDeleteOnMark' in item.dataset) {
                                item.parentNode.removeChild(item);
                            }else{
                                item.classList.add('read');
                                handle.parentNode.removeChild(handle);
                            }
                        }

                        read(ncId);
                    });
                });
            });
        };

        const read = function(id){
            let request = new XMLHttpRequest();
                request.open('GET', '/membernotification/read/' + id, false);
                request.send();
        }

        init();
    };
})();

document.addEventListener('DOMContentLoaded', function (){
    if(document.querySelector('.mod_memberNotification')){
        document.querySelectorAll('.mod_memberNotification').forEach(function (module, index) {
            new MemberNotification(module);
        });
    }
});
