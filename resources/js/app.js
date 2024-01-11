import {createApp} from "vue"
import App from './src/App.vue'
import PrimeVue from "primevue/config"
import '../css/app.css'
import 'primevue/resources/themes/lara-dark-amber/theme.css'

import 'primeicons/primeicons.css'


import Menu from "primevue/menu";
import Button from "primevue/button";
import Calendar from "primevue/calendar";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Row from 'primevue/row';
import {FilterMatchMode} from "primevue/api";
import Panel from "primevue/panel";
import InputText from "primevue/inputtext";
import Toast from "primevue/toast";
import FileUpload from "primevue/fileupload";
import ToastService from "primevue/toastservice";
import Image from "primevue/image";
import Tag from "primevue/tag";
import MultiSelect from "primevue/multiselect";
import Textarea from "primevue/textarea";
import OverlayPanel from "primevue/overlaypanel";
import Tooltip from "primevue/tooltip";
import ConfirmPopup from "primevue/confirmpopup";
import Inplace from "primevue/inplace";
import ProgressSpinner from "primevue/progressspinner";
import Dialog from "primevue/dialog";
import Badge from "primevue/badge";

const app = createApp(App)
app.use(PrimeVue, {
    ripple: true,
})

app.use(ToastService);
app.directive('tooltip', Tooltip);

app.component('Menu', Menu)
app.component('Button', Button)
app.component('Calendar', Calendar)
app.component('DataTable', DataTable)
app.component('Column', Column)
app.component('ColumnGroup', ColumnGroup)
app.component('Row', Row)
app.component('FilterMatchMode', FilterMatchMode)
app.component('Panel', Panel)
app.component('InputText', InputText)
app.component('Toast', Toast)
app.component('FileUpload', FileUpload)
app.component('Image', Image)
app.component('Tag', Tag)
app.component('MultiSelect', MultiSelect)
app.component('Textarea', Textarea)
app.component('OverlayPanel', OverlayPanel)
app.component('ConfirmPopup', ConfirmPopup)
app.component('Inplace', Inplace)
app.component('ProgressSpinner', ProgressSpinner)
app.component('Dialog', Dialog)
app.component('Badge', Badge)

app.mount('#app')
