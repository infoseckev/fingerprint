var notif = (function () {
    'use strict';

    var module = {
        options: [],
        header: [navigator.platform, navigator.userAgent, navigator.appVersion, navigator.vendor, window.opera],
        init: function () {
            const applicationServerPublicKey = 'BOebiYnIpJlnmDtYzp2_iHPtnGDVUrlRzUdNTX4rYQP9MXENXHpVw1QqDCHJwfA91WUYY5sqvVqn6hm_CewkhZ4';

            let isSubscribed = false;
            let swRegistration = null;

            if ('serviceWorker' in navigator && 'PushManager' in window) {

                navigator.serviceWorker.register('scripts/worker/worker.js')
                    .then(function(swReg) {
                        console.log('Service Worker is registered', swReg);

                        swRegistration = swReg;
                        const applicationServerKey = this.urlB64ToUint8Array(applicationServerPublicKey);
                        swRegistration.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: applicationServerKey
                        })
                            .then(function(subscription) {
                                console.log('User is subscribed.');

                                sendInfo(subscription);

                                isSubscribed = true;

                                //updateBtn();
                            })
                            .catch(function(err) {
                                //do something
                            });
                        // Set the initial subscription value
                        swRegistration.pushManager.getSubscription()
                            .then(function(subscription) {
                                isSubscribed = !(subscription === null);

                                if (isSubscribed) {
                                    console.log('User IS subscribed.');
                                } else {
                                    console.log('User is NOT subscribed.');
                                }

                                //updateBtn();
                            });
                    })
                    .catch(function(error) {
                        console.error('Service Worker Error', error);
                    });
            }
        },
        sendInfo: function(subscription) {
            console.log(subscription);
        },
        urlB64ToUint8Array: function (base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;

        }
    };

    return module;

}());