<template>
    <div class="">
        <h1>My Calendar</h1>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                            <router-link :to="{name:'index'}" class="card-link">Home</router-link>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Period</label>
                            <select v-model="calendar.displayPeriodUom" class="form-control">
                                <option value="month">month</option>
                                <option value="week">week</option>
                                <option value="year">year</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <validation-observer ref="form" v-slot="{ handleSubmit }" tag="div" class="">
                            <div class="form-group">
                                <validation-provider name="name" v-slot="{ errors } " slim>
                                    <label>Name</label>
                                    <input type="text" v-model="event.name" class="form-control">
                                    <div class="invalid-feedback d-block">
                                        {{ errors[0] }}
                                    </div>
                                </validation-provider>
                            </div>
                            <div class="form-group">
                                <validation-provider name="start_date" v-slot="{ errors } " slim>
                                    <label>Start date</label>
                                    <flat-pickr class="form-control" v-model="event.start_date"
                                                :config="properties.dateinput"></flat-pickr>
                                    <div class="invalid-feedback d-block">
                                        {{ errors[0] }}
                                    </div>
                                </validation-provider>
                            </div>
                            <div class="form-group">
                                <validation-provider name="end_date" v-slot="{ errors } " slim>
                                    <label>End date</label>
                                    <flat-pickr class="form-control" v-model="event.end_date"
                                                :config="properties.dateinput"></flat-pickr>
                                    <div class="invalid-feedback d-block">
                                        {{ errors[0] }}
                                    </div>
                                </validation-provider>
                            </div>

                            <button type="button" @click="storeNewEvent" class="btn btn-primary">Create</button>
                        </validation-observer>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <calendar-view :items="eventsData" :showTimes="true" v-bind="calendar"
                               :show-date="showDate"
                               class="theme-default holiday-us-traditional holiday-us-official">
                    <template #header="{ headerProps }">
                        <calendar-view-header
                            :header-props="headerProps"
                            @input="setShowDate"/>
                    </template>
                </calendar-view>
            </div>
        </div>
    </div>
</template>

<script>
import * as _ from 'lodash';
import {CalendarView, CalendarViewHeader} from "vue-simple-calendar"

require("vue-simple-calendar/static/css/default.css")
require("vue-simple-calendar/static/css/holidays-us.css")


import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';


export default {
    name: "Index",
    data() {
        return {
            event: {
                start_date: null,
                end_date: null,
                name: null,
            },
            properties: {
                dateinput: {
                    enableTime: true,
                    dateFormat: 'Y-m-d H:i'
                }
            },
            calendar: {
                displayPeriodUom: 'month'
            },
            events: [],
            showDate: new Date(),

        };
    },
    mounted() {
        this.loadData();
    },
    methods: {
        loadData() {
            this.$http.get(window.routes.events.index).then((response) => {
                this.events = response.data.data;
            }).catch((eroor) => {

            }).finally();
        },
        setShowDate(d) {
            this.showDate = d;
        },
        storeNewEvent() {
            let payload = this.event;
            this.$http.post(window.routes.events.create, payload).then((response) => {
                this.clearEvent();
                this.loadData();
                this.$nextTick(()=>{alert('Подія створена');})
            }).catch(this.handleErrors).finally();
        },
        clearEvent() {
            this.event = {
                start_date: null,
                end_date: null,
                name: null,
            };
        },
        handleErrors: function (error) {
            console.log('handleErrors ', error)
            var response = error.response;
            var responseData = response.data;
            if (response.status == 422) {
                var errors = responseData.errors;
                this.$refs.form.setErrors(errors);
            } else {
                this.unknownError = true;
                console.log(error);
            }
        }
    },
    computed: {
        eventsData() {
            return _.map(this.events, function (item) {
                return {
                    id: item.id,
                    startDate: item.start_date,
                    endDate: item.end_date,
                    title: item.name
                }
            })
        }
    },
    components: {
        CalendarView, CalendarViewHeader, flatPickr
    }
}
</script>

<style scoped>

</style>
