import focus from '@alpinejs/focus'
import AlpineFloatingUI from '@awcodes/alpine-floating-ui';
import notifications from 'alpinejs-notify'
import axios from 'axios';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm'

Alpine.plugin(AlpineFloatingUI);
Alpine.plugin(focus)
Alpine.plugin(notifications)

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Livewire.start()
