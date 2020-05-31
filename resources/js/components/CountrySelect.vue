<template>
    <div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Country</label>
            <div class="col-md-6">
                <input type="text" class="form-control" v-model="countrySearch" required>
                <input type="hidden" name="country" v-bind:value="selectedCountry.id">
                <input type="hidden" name="country_name" v-bind:value="selectedCountry.name">
                <div v-if="countrySearch.length > 0" class="mt-3">
                    <div class="form-check" v-for="country in filteredCountries">
                        <input required v-model="selectedCountry" class="form-check-input" type="radio" v-bind:value="country" :label="country.id" :id="country.id">
                        <label class="form-check-label" :for="country.id">
                            {{ country.name }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="findCity" class="col-md-4 col-form-label text-md-right">City</label>
            <div class="col-md-6">
                <input :disabled="selectedCountry === ''" id="findCity" type="text" v-model="search" class="form-control" required>
                <input type="hidden" name="city" v-bind:value="selectedCity">
                <input type="hidden" name="city_name" v-bind:value="selectedCityName">
                <input type="hidden" name="region" v-bind:value="selectedRegion">
                <input type="hidden" name="region_name" v-bind:value="selectedRegionName">
                <div v-if="cities.length > 0" class="mt-3">
                    <div class="form-check" v-for="city in cities">
                        <input required class="form-check-input" type="radio" v-bind:value="city" :label="city.id" :id="city.id" @click="setSelectedCity(city)">
                        <label class="form-check-label" :for="city.id" @click="setSelectedCity(city)">
                            {{ city.parent.name }}, {{ city.name }}
                        </label>
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
                countries: [],
                cities: [],
                countrySearch: '',
                search: '',
                selectedCountry: '',
                write: [],
                selectedRegion: '',
                selectedRegionName: '',
                selectedCity: '',
                selectedCityName: '',
            }
        },
        mounted() {
            let self = this;

            window.Axios.get('/geo/countries').then((response) => {
                self.countries = response.data;
            });

            // Every two seconds
            setInterval(() => {
                if (self.write.length > 0) {
                    window.Axios.get('/geo/search/' + self.write[self.write.length - 1] +'/' + self.selectedCountry.id).then((response) => {
                        self.cities = response.data;
                        let elements = [];
                        if (response.data.length <= 5) {
                            response.data.forEach((city) => {
                                window.Axios.get('/geo/item/' + city.parent_id).then((response) => {
                                    city.parent = response.data;
                                    elements.push(city);
                                });
                            });
                            self.cities = elements;
                        } else {
                            self.cities = response.data
                        }
                    });
                    self.write = [];
                }
            }, 3000)
        },
        methods: {
            setSelectedCity(city) {
                this.selectedCity = city.id;
                this.selectedCityName = city.name;
                this.selectedRegionName = city.parent.name;
                this.selectedRegion = city.parent.id;
            }
        },
        watch: {
            search: function(value) {
                this.write.push(value);
            }
        },
        computed: {
            filteredCountries: {
                get() {
                    let self = this;
                    let elements = this.countries.filter((country) => {
                        return country.name.toLowerCase().includes(self.countrySearch.toLowerCase())
                    });
                    if (elements.length > 10) {
                        return [];
                    } else {
                        return elements;
                    }
                }
            }
        }
    }
</script>
