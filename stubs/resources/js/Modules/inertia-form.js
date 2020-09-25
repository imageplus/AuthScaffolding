class InertiaForm {
    constructor(inertiaInstance, inertiaPage, globals,  data = {}, options = {}) {
        this.init();

        this.__$inertia = {
            instance: inertiaInstance,
            page: inertiaPage
        }

        this.__$instance = {
            success: false,
            processing: false,
            initial: data,
            options: {
                ...{
                    bag: 'default'
                },
                ...options
            },
            globals: globals
        }

        this.setData(data);
    }

    static newForm(inertiaInstance, inertiaPage, globals, data = {}, options = {}){
        return new InertiaForm(inertiaInstance, inertiaPage, globals, data, options);
    }

    init(){
        this.options = {};
    }

    isProcessing(){
        return this.__$instance.processing;
    }

    isSuccess(){
        return this.__$instance.success;
    }

    setData(data = {}){
        for (let field in data) {
            this[field] = data[field];
        }

        return this;
    }

    data(){
        let data = {};

        for(let field in this.__$instance.initial){
            data[field] = this[field];
        }

        return data;
    }

    post(url, options = {}) {
        return this.submit('post', url, options);
    }

    put(url, options = {}) {
        return this.submit('put', url, options);
    }

    patch(url, options = {}) {
        return this.submit('patch', url, options);
    }

    delete(url, options) {
        return this.submit('delete', url, options);
    }

    submit(method, url){
        const requestTypes = ['get', 'post', 'put', 'patch', 'delete'];

        if(requestTypes.indexOf(method.toLowerCase()) === -1){
            throw new Error(`Method: ${method} doesn't exist`);
        }

        this.__$instance.processing = true;
        this.__$instance.successful = false;

        return this.__$inertia.instance[method](url, this.data())
            .then((response) => {
                this.processing = false;

                if (!this.hasErrors()) {
                    this.onSuccess();
                } else {
                    this.onFail();
                }

                this.__$instance.processing = false;
            });
    }

    onSuccess() {
        this.__$instance.successful = true;

        if(this.__$instance.globals.onSuccess !== undefined){
            this.__$instance.globals.onSuccess(this);
        }
    }

    onFail(){
        this.__$instance.successful = false;

        if(this.__$instance.globals.onFail !== undefined){
            this.__$instance.globals.onFail(this);
        }
    }

    errors(){
        return this.__$inertia.page().errorBags[this.__$instance.options.bag];
    }

    hasErrors() {
        return this.errors() && Object.keys(this.errors()).length > 0;
    }

    error(field) {
        if (!this.hasErrors()){
            return '';
        }

        return this.errors()[field] !== undefined
            ? this.errors()[field][0]
            : '';
    }
}

export default {
    install(Vue, globals = {}) {
        Vue.prototype.$inertia.form = (data = {}, options = {}) => {
            return InertiaForm.newForm(
                Vue.prototype.$inertia,
                () => Vue.prototype.$page,
                globals,
                data,
                options
            );
        }
    }
};
