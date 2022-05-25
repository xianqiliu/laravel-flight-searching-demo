<template>
    <div class = "row clearfix">

        <div class="col-md-4 column">
            <h3>Airport and City Search Engine</h3>
            <p style="font-size:12px; font-style:italic; color:#999999;">
                A happy coding demo :) - Built by using Amadeus-PHP-SDK with Laravel + Vue.js .
            </p>
            <br /> <br />
            <el-form ref="form" :model="form" label-width="100px">
                <el-form-item label="* SubType" label-width="100px">
                    <el-checkbox v-model="form.city">City</el-checkbox>
                    <el-checkbox v-model="form.airport">Airport</el-checkbox>
                </el-form-item>
                <el-form-item label="* Keyword" label-width="100px">
                    <el-input v-model="form.keyword"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" ref="btn1" @click="onSubmit(form)">Search</el-button>
                </el-form-item>
            </el-form>
        </div>

        <div class="col-md-1 column"> </div>

        <div class="col-md-7 column">
            <h3>Results</h3>
            <el-pagination
                @current-change="setPage"
                :current-page=this.currentPage
                :page-count=this.pageCount
                layout="prev, pager, next"
            >
            </el-pagination>
            <div v-for="location in locations" :key="location.id">
                <div class="thumbnail">
                    <div class="caption">
                        <span style="font-weight: bold; color: blue"> * {{ location.subType }} </span>
                        <h4> {{ location.name }} </h4>
                        <span style="font-size: 12px; font-style: italic; color: #666666;">CountryName</span>
                        <p> {{ location.address.countryName }} </p>
                        <span style="font-size: 12px; font-style: italic; color: #666666;">DetailedName</span>
                        <p> {{ location.detailedName }} </p>
                        <span style="font-size: 12px; font-style: italic; color: #666666;">TimeZoneOffset</span>
                        <p> {{ location.timeZoneOffset }} </p>
                        <span style="font-size: 12px; font-style: italic; color: #666666;">Latitude</span>
                        <p> {{ location.geoCode.latitude }} </p>
                        <span style="font-size: 12px; font-style: italic; color: #666666;">Longitude</span>
                        <p> {{ location.geoCode.longitude }} </p>
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
                city: true,
                airport: "",
                keyword: "",
            },
            rules: {
            },
            locations: [],
            currentPage: 1,
            pageCount: 1,
            subType: "CITY",
            linksForEachPage: [],
        };
    },
    methods: {
        onSubmit(form) {

            if ( this.form.city === true && this.form.airport === true ) {
                this.subType = "CITY,AIRPORT";
            } else if ( this.form.city === true && this.form.airport !== true ) {
                this.subType = "CITY";
            } else if ( this.form.city !== true && this.form.airport === true )  {
                this.subType = "AIRPORT";
            }

            console.log(this.form);
            this.locations = [];

            console.log("Accepted");
            axios.get(
                '/api/locations?' +
                'subType=' + this.subType +
                '&keyword=' + this.form.keyword +
                '&page[offset]=' + '0'
            ).then((response) => {
                console.log(response.data);
                this.locations = response.data.data;
                this.pageCount = response.data.meta.pageCount;
                this.linksForEachPage = response.data.meta.linksForEachPage;
                console.log("closing");
            });
        },
        setPage(val) {
            console.log(val)
            this.currentPage = val;

            this.locations = [];

            console.log("Accepted");
            axios.get(
                this.linksForEachPage[this.currentPage-1]
            ).then((response) => {
                console.log(response.data);
                this.locations = response.data.data;
                console.log("closing");
            });
        },
    }
}
</script>

<style scoped>
@import url(https://unpkg.com/bootstrap@3.3.5/dist/css/bootstrap.min.css);
</style>
