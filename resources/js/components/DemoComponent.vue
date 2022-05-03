<template>
    <div class="row clearfix">

        <div class="col-md-4 column">
            <h3>Flight Offers Search Engine</h3>
            <p style="font-size:12px; font-style:italic; color:#999999;">
                Built by using Amadeus-PHP-SDK with Laravel + Vue.js
            </p>
            <br /> <br />
            <el-form ref="form" :model="form" label-width="100px">
                <el-form-item label="Departure" label-width="100px">
                    <el-input v-model="form.departure"></el-input>
                </el-form-item>
                <el-form-item label="Arrival" label-width="100px">
                    <el-input v-model="form.arrival"></el-input>
                </el-form-item>
                <el-form-item label="🛫" label-width="100px">
                    <el-date-picker
                        v-model="form.departureDate"
                        format="MMMM dd, yyyy"
                        value-format="yyyy-MM-dd"
                        placeholder="Departure Date"
                    ></el-date-picker>
                </el-form-item>
                <el-form-item label="🛬" label-width="100px">
                    <el-date-picker
                        v-model="form.returnDate"
                        format="MMMM dd, yyyy"
                        value-format="yyyy-MM-dd"
                        placeholder="Return Date"
                    ></el-date-picker>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" ref="btn1" @click="onSubmit(form)">Search</el-button>
                </el-form-item>
            </el-form>
        </div>

        <div class="col-md-1 column"> </div>

        <div class="col-md-7 column">
            <h3>Results</h3> <br />
            <div v-for="offer in offers" :key="offer.id">
                <div class="thumbnail">
                    <div class="caption">
                        <div class="col-md-6">
                            <h4 style="display: inline">Departure</h4>
                            <span style="font-size: 12px; font-style: italic; color: #666666;">Total duration - {{ offer.itineraries[0].duration | durationFormatter}} </span> <br />
                            <div v-for="segment in offer.itineraries[0].segments">
                                <span style="font-size: 10px; font-style: italic; color: #666666;"> Segment duration - {{ segment.duration | durationFormatter }} </span> <br />
                                <span> {{ segment.departure.at | onlyTimeFormatter }} </span>
                                <span style="font-weight: bold;"> {{ segment.departure.iataCode }} </span>
                                <span style="color: #999999">  -✈-  </span>
                                <span style="font-weight: bold;"> {{ segment.arrival.iataCode }} </span>
                                <span> {{ segment.arrival.at | onlyTimeFormatter }} </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 style="display: inline;">Return</h4>
                            <span style="font-size: 12px; font-style: italic; color: #666666;">Total duration {{ offer.itineraries[1].duration | durationFormatter }}</span> <br />
                            <div v-for="segment in offer.itineraries[1].segments">
                                <span style="font-size: 10px; font-style: italic; color: #666666;"> Segment duration - {{ segment.duration | durationFormatter}} </span> <br />
                                <span> {{ segment.departure.at | onlyTimeFormatter }} </span>
                                <span style="font-weight: bold;"> {{ segment.departure.iataCode }} </span>
                                <span style="color: #999999">  -✈-  </span>
                                <span style="font-weight:bold;"> {{ segment.arrival.iataCode }} </span>
                                <span> {{ segment.arrival.at | onlyTimeFormatter }} </span>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div style="text-align: center;">
                        <span style="font-size: 12px; color: #333333;"> Total price: {{ offer.price.total }} {{ offer.price.currency }} </span> <br />
                        <el-button type="success" size="mini">Book</el-button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    departure: "",
                    arrival: "",
                    departureDate: "",
                    returnDate: "",
                },
                rules: {
                },
                offers: []
            };
        },
        methods: {
            onSubmit(form) {
                console.log(this.form);
                console.log("Accepted");
                this.offers = [];
                axios.get(
                    '/api/flight-offers?' +
                    'originLocationCode=' + this.form.departure +
                    '&destinationLocationCode=' + this.form.arrival +
                    '&departureDate=' + this.form.departureDate +
                    '&returnDate=' + this.form.returnDate +
                    '&adult=1'
                ).then((response) => {
                    console.log(response.data)
                    this.offers = response.data.data
                    console.log("closing");
                });
            },
        }
    }
</script>

<style scoped>
@import url(https://unpkg.com/bootstrap@3.3.5/dist/css/bootstrap.min.css);
</style>
