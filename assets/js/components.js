//Шина событий

const eventEmmiter = new Vue();

// Мультиязычность

const i18n = new VueI18n({
    locale: 'en',
    fallbackLocale: 'ru',
    messages: {
        en: {
            name: "Name",
            surname: "Surname",
            phone: "Phone",
            password: "Password",
            confpass: "Confirm Password",
            addfile: "Add File",
            registr: "Registration",
            regButton: "Sign up",
            userSuccess: 'User',
            userRegis: 'successfully registered',            
        },
        ru: {
            name: "Имя",
            surname: "Фамилия",
            phone: "Номер",
            password: "Пароль",
            confpass: "Подтв. Пароля",
            addfile: "Загрузка Файла",
            registr: "Регистрация",
            regButton: "Зарегистрироваться",
            userSuccess: 'Пользователь',
            userRegis: 'успешно зарегестрирован',
        }
    }
});

//Компонент для Регистрации (форма)

const HomePage = {
    data() {
        return {
            
        }
    },
    template: `
<form id="signupForm" method="post" class="mt-5" action="">
                    <div class="form-group row">
                        <label for="staticName" class="col-sm-5 col-form-label">{{ $t('name') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="staticName" name="staticName"  :placeholder="$t('name')">
                            <div class="invalid-feedback">                               
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticSurname" class="col-sm-5 col-form-label">{{ $t('surname') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="staticSurname" name="staticSurname"  :placeholder="$t('surname')">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Email</label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control" id="staticEmail" name="staticEmail" aria-describedby="emailHelp" placeholder="name@example.com">
                            <div class="invalid-feedback">
                            </div>
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-5 col-form-label">{{ $t('password') }}</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="inputPassword" name="inputPassword" :placeholder="$t('password')">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputConfPassword" class="col-sm-5 col-form-label">{{ $t('confpass') }}</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="inputConfPassword" name="inputConfPassword" :placeholder="$t('confpass')">
                            <div class="invalid-feedback">
                            </div>
                        </div>                    
                    </div>
                    <div class="form-group row">
                        <label for="staticFile" class="col-sm-5 col-form-label">{{ $t('addfile') }}</label>
                        <div class="col-sm-7">
                            <input ref="file" type="file" class="form-control-file" id="staticFile" name="file" lang="ru">
                            <div class="invalid-feedback">
                            </div>
                        </div>                        
                    </div>
                    <button class="btn btn-primary mb-2">{{ $t('regButton') }}</button>
                </form>
`,
    methods: {
        
    },
    computed: {
        
    }
};


// Связываем маршруты с компонентами

const routes = [
    { path: '/', component: HomePage }
];

// Передаём routes во VueRoutes routes: routes

const router = new VueRouter({
    routes
});



// Создаем экземпляр Vue

new Vue({
    el: '#app',
    i18n,
    router,
    data: {
        msg: "Hello",
        langVal: 0
    },
    methods: {
        changeLang(locale) {
            this.$i18n.locale = locale;
            if (locale == 'en') {
                this.langVal = 0;
            } else {
                this.langVal = 1;
            }
        }
    },
    components: {
        HomePage
    },
    created() {
        
    },
    beforeCreate: function () {

    }
});