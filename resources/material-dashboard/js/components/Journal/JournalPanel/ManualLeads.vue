<template>
    <button
        class="btn btn-info rounded-0 m-0 gap-2 py-1 px-3 d-flex justify-content-center align-items-center w-50 w-md-25 w-lg-auto"
        data-bs-toggle="modal" data-bs-target="#journalManualLeads">
        Добавить лид
        &nbsp;
        <i class="material-icons-round text-sm"><span class="material-symbols-outlined">add_circle</span></i>
    </button>

    <div class="modal fade" id="journalManualLeads" tabindex="-1" role="dialog" aria-labelledby="journalCommentsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form @submit.prevent="addLead" action="#" class="modal-content rounded-0 bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="journalCommentsLabel">Добавление лида</h5>
                    <button ref="closeManualLeads" type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="d-flex justify-content-between flex-column flex-sm-row">
                        <div class="journal__manual-leads__modal__box p-1 pb-2 m-1">
                            <div
                                :class="{'is-invalid' : v$.name.$invalid && v$.$dirty}"
                                class="input-group mb-2">
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%)" class="input-group-text text-danger" id="manualLeadsName">*</span>
                                <input
                                    v-model="name"
                                    type="text" class="form-control text-white border p-1 rounded-2" placeholder="Имя" aria-describedby="manualLeadsName">

                                <div class="invalid-feedback" v-if="v$.name.required.$invalid && v$.$dirty">Обязательное поле.</div>
                            </div>

                            <div class="input-group mb-2">
                                <input
                                    v-model="surname"
                                    type="text" class="form-control text-white border p-1 rounded-2" placeholder="Фамилия">
                            </div>

                            <div class="input-group">
                                <input
                                    v-model="patronymic"
                                    type="text" class="form-control text-white border p-1 rounded-2" placeholder="Отчество">
                            </div>
                        </div>

                        <div class="journal__manual-leads__modal__box p-1 pb-2 m-1">
                            <div
                                :class="{'is-invalid' : v$.phone.$invalid && v$.$dirty}"
                                class="input-group mb-2">
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%)" class="text-danger" id="manualLeadsPhone">*</span>
                                <input
                                    v-model="phone"
                                    v-maska
                                    data-maska="+7 (###) ###-####"
                                    type="text" class="form-control text-white border p-1 rounded-2" placeholder="Телефон" aria-describedby="manualLeadsPhone">

                                <div class="invalid-feedback" v-if="v$.phone.required.$invalid && v$.$dirty">Обязательное поле.</div>
                                <div class="invalid-feedback" v-if="v$.phone.minLength.$invalid && v$.$dirty">Неверный формат</div>
                            </div>

                            <div
                                :class="{'is-invalid' : v$.email.$invalid && v$.$dirty}"
                                class="input-group mb-2">
                                <input
                                    v-model="email"
                                    type="text" class="form-control text-white border p-1" placeholder="E-mail">

                                <div class="invalid-feedback" v-if="v$.email.email.$invalid && v$.$dirty">Неверный формат</div>
                            </div>

                            <div class="input-group">
                                <input
                                    v-model="owner"
                                    type="text" class="form-control text-white border p-1" placeholder="Владелец лида">
                            </div>
                        </div>

                        <div class="journal__manual-leads__modal__box p-1 m-1">
                            <div class="input-group mb-2">
                                <input
                                    v-model="cost"
                                    type="text" class="form-control text-white border p-1" placeholder="Стоимость">
                            </div>

                            <div class="input-group mb-2">
                                <input
                                    v-model="city"
                                    type="text" class="form-control text-white border p-1" placeholder="Город">
                            </div>

                            <div class="input-group">
                                <input
                                    v-model="region"
                                    type="text" class="form-control text-white border p-1" placeholder="Регион">
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-between flex-column flex-sm-row">

                        <div class="journal__manual-leads__modal__box p-1 m-1">
                            <div class="input-group mb-2">
                                <input
                                    v-model="company"
                                    type="text" class="form-control text-white border p-1" placeholder="Компания">
                            </div>

                            <div
                                :class="{'is-invalid' : v$.ip.$invalid && v$.$dirty}"
                                class="input-group mb-2">
                                <input
                                    v-model="ip"
                                    type="text" class="form-control text-white border p-1" placeholder="IP">

                                <div class="invalid-feedback" v-if="v$.ip.isIP.$invalid && v$.$dirty">Неверный формат</div>
                            </div>

                            <div class="input-group">
                                <input
                                    v-model="referrer"
                                    type="text" class="form-control text-white border p-1" placeholder="Реферрер">
                            </div>
                        </div>

                        <div class="journal__manual-leads__modal__box p-1 m-1">

                            <div
                                :class="{'is-invalid' : v$.host.$invalid && v$.$dirty}"
                                class="input-group mb-2">
                                <input
                                    v-model="host"
                                    type="text" class="form-control text-white border p-1" placeholder="Посадочная">

                                <div class="invalid-feedback" v-if="v$.host.url.$invalid && v$.$dirty">Неверный формат</div>
                            </div>

                            <div class="input-group mb-2">
                                <input
                                    v-model="source"
                                    type="text" class="form-control text-white border p-1" placeholder="Источник">
                            </div>

                            <div class="input-group">
                                <input
                                    v-model="utmTerm"
                                    type="text" class="form-control text-white border p-1" placeholder="utmTerm">
                            </div>
                        </div>

                        <div class="journal__manual-leads__modal__box p-1 m-1">

                            <div class="input-group mb-2">
                                <input
                                    v-model="utmMedium"
                                    type="text" class="form-control text-white border p-1" placeholder="utmMedium">
                            </div>

                            <div class="input-group mb-2">
                                <input
                                    v-model="utmSource"
                                    type="text" class="form-control text-white border p-1" placeholder="utmSource">
                            </div>

                            <div class="input-group">
                                <input
                                    v-model="utmCampaign"
                                    type="text" class="form-control text-white border p-1" placeholder="utmCampaign">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between flex-column flex-sm-row">
                        <div class="journal__manual-leads__modal__box p-1 m-1">

                            <div class="input-group mb-2">
                                <input
                                    v-model="utmContent"
                                    type="text" class="form-control text-white border p-1" placeholder="utmContent">
                            </div>

                            <div class="input-group mb-2">
                                <input
                                    v-model="urlQueryString"
                                    type="text" class="form-control text-white border p-1" placeholder="urlQueryString">
                            </div>

<!--                            <div class="input-group flex-column border p-1 rounded-2">-->
<!--                                <span class="text-xs">Дата следующего звонка</span>-->
<!--                                <input-->
<!--                                    v-model="nextCallDate"-->
<!--                                    type="datetime-local" class="form-control w-100 pt-0 text-white" placeholder="Дата следующего звонка">-->
<!--                            </div>-->
                        </div>

                        <div class="journal__manual-leads__modal__box--comment p-1 pb-2 m-1">
                            <div class="input-group h-100">
                                <textarea
                                    v-model="comment"
                                    type="text" class="form-control text-white border p-2" placeholder="Комментарий">
                                </textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button
                        type="submit"
                        class="btn bg-success w-50 rounded-0 text-white m-0">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { vMaska } from "maska"
import { useVuelidate } from '@vuelidate/core'
import { required, email, minLength, url } from '@vuelidate/validators'
import { isIP } from 'is-ip'

export default {
    name: "manualLeads",
    setup () {
        return { v$: useVuelidate() }
    },
    directives: { maska: vMaska },
    data() {
        return {
            name: '',
            surname: '',
            patronymic: '',
            phone: '',
            email: '',
            owner: '',
            cost: '',
            city: '',
            region: '',
            company: '',
            ip: '',
            referrer: '',
            host: '',
            source: '',
            utmTerm: '',
            utmMedium: '',
            utmSource: '',
            utmCampaign: '',
            utmContent: '',
            urlQueryString: '',
            nextCallDate: '',
            comment: ''
        }
    },
    computed: {
        stateProjectId() {
            return this.$store.getters['journalAll/stateProjectId']
        }
    },
    methods: {
        clearData() {
            this.name = ''
            this.surname = ''
            this.patronymic = ''
            this.phone = ''
            this.email = ''
            this.owner = ''
            this.cost = ''
            this.city = ''
            this.region = ''
            this.company = ''
            this.ip = ''
            this.referrer = ''
            this.host = ''
            this.source = ''
            this.utmTerm = ''
            this.utmMedium = ''
            this.utmSource = ''
            this.utmCampaign = ''
            this.utmContent = ''
            this.urlQueryString = ''
            this.nextCallDate = ''
            this.comment = ''
        },
        async addLead() {
            const result = await this.v$.$validate()
            if (!result) {
                return
            }

            this.$store.commit('loader/LOADER_TRUE')

            await axios.post('/api/v2/lead/add', {
                project_id: this.stateProjectId,
                name: this.name,
                surname: this.surname,
                patronymic: this.patronymic,
                phone: this.phone.replace(/\D/g, ''),
                email: this.email,
                owner: this.owner,
                cost: this.cost,
                city: this.city,
                manual_region: this.region,
                company: this.company,
                ip: this.ip,
                referrer: this.referrer,
                host: this.host,
                source: this.source,
                utm_term: this.utmTerm,
                utm_medium: this.utmMedium,
                utm_source: this.utmSource,
                utm_campaign: this.utmCampaign,
                utm_content: this.utmContent,
                url_query_string: this.urlQueryString,
                nextcall_date: this.nextCallDate.replace(/T/, ' '),
                comment: this.comment
            }).then(response => {
                this.v$.$reset()
                this.clearData()
                this.$store.commit('loader/LOADER_FALSE')
                this.$refs.closeManualLeads.click()
                this.$store.dispatch('getToast', {
                    msg: 'Лид добавлен!',
                    settingsObj: {
                        type: 'success',
                        position: 'bottom-right',
                        timeout: 2000,
                        showIcon: true
                    }
                })
            }).catch(error => {
                this.$store.dispatch('getToast', {
                    msg: 'Что-то пошло не так!',
                    settingsObj: {
                        type: 'danger',
                        position: 'bottom-right',
                        timeout: 2000,
                        showIcon: true
                    }
                })
                this.$store.commit('loader/LOADER_FALSE')
                console.log(error)
            })

            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    validations () {
        return {
            name: { required },
            phone: { required, minLength: minLength(17) },
            email: { email },
            host: { url },
            ip: {
                isIP: (val) => {
                    if (val) {
                        return isIP(val)
                    }
                    return true
                }
            }
        }
    }
}
</script>

<style scoped>
.is-invalid {
    outline: 1px solid tomato;
    border-radius: 4px;
}
.invalid-feedback {
    display: block;
    position:absolute;
    top: -2px;
    left: 2px;
    width: 100%;
    color: #dc3545;
    font-size: 10px;
    margin: 0 !important;
}

textarea {
    resize: none;
}

.modal-dialog {
    max-width: none;
}

@media screen and (min-width: 768px) {
    .modal-dialog {
        max-width: 600px;
    }
}

@media screen and (min-width: 576px) {
    .journal__manual-leads__modal__box {
        width: 33%;
    }

    .journal__manual-leads__modal__box--comment {
        width: 66%;
    }
}
</style>
