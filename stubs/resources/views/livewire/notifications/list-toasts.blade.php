<div
    class="fixed top-10 right-10"
    x-data="{
        notify: function(message, type = 'success') {
            this.$notify(message, {
                wrapperId: 'notifications',
                templateId: 'toast-' + type,
                autoClose: 3000,
                autoRemove: 4000,
            })
        }
    }"
    x-on:toast.dot.window="notify($event.detail.message, $event.detail.type)"
>
    <div class="fixed top-10 right-10 w-64 z-99" id="notifications"></div>

    <template id="toast-danger">
        <div
            class="w-full max-w-xs rounded-lg bg-white p-4 text-gray-500 shadow dark:bg-gray-800 dark:text-gray-400"
            role="alert"
        >
            <div class="flex">
                <div
                    class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-danger-100 text-danger-500 dark:bg-danger-800 dark:text-danger-200"
                >
                    <x-fwb-s-exclamation-circle class="h-5 w-5"/>
                </div>

                <div class="text-sm font-normal ms-3">{notificationText}</div>
            </div>
        </div>
    </template>

    <template id="toast-success">
        <div
            class="w-full max-w-xs rounded-lg bg-white p-4 text-gray-500 shadow dark:bg-gray-800 dark:text-gray-400"
            role="alert"
        >
            <div class="flex">
                <div
                    class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-success-100 text-success-500 dark:bg-success-800 dark:text-success-200"
                >
                    <x-fwb-s-check-circle class="h-5 w-5"/>
                </div>

                <div class="pt-1 text-sm font-normal ms-3">{notificationText}</div>
            </div>
        </div>
    </template>
</div>
