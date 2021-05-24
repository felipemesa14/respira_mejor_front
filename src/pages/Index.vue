<template>
  <q-page class="col">
 <div class="row q-pa-md">
   <div class="col-md-6">
    <q-select v-model="model" :options="options" label="Año" />
   </div>
  </div>
 <div id="mapa">
      <gmap-map
        :center="center"
        :zoom="zoom"
        style="width: 100%; height: 85vh;">
        <GmapCircle
          v-for="(pin, indexRed) in markersRed"
          :key="indexRed"
          :center="pin.position"
          :radius="500"
          :visible="true"
          :options="{fillColor:'red',fillOpacity:0.5}">
        </GmapCircle>
        <GmapCircle
          v-for="(pin, indexYellow) in markersYellow"
          :key="indexYellow"
          :center="pin.position"
          :radius="500"
          :visible="true"
          :options="{fillColor:'yellow',fillOpacity:0.5}">
        </GmapCircle>
      </gmap-map>
  </div>
  </q-page>
</template>

<script>
import Vue from 'vue'
import * as VueGoogleMaps from 'vue2-google-maps'
import axios from 'axios'

Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyAbBhECxbT35lhq-Wrj-ERv1gBvYs7b5uw'
  }
})

export default {
  name: 'PageIndex',
  watch: {
    model () {
      this.listarMarcadores()
    }
  },
  methods: {
    validateHighLevel (level) {
      console.log(level)
      if (level > 8) {
        return true
      } else {
        return false
      }
    },
    listarMarcadores () {
      this.markersRed = []
      this.markersYellow = []
      axios('http://localhost:8000/api/marcadores/' + this.model)
        .then(response => {
          this.myJson = response.data
          this.myJson.map(json => {
            if (this.validateHighLevel(json.nivel)) {
              this.markersRed.push({ Id: json.id, name: json.id, position: { lat: parseFloat(json.lat), lng: parseFloat(json.lng) } })
            } else {
              this.markersYellow.push({ Id: json.id, name: json.id, position: { lat: parseFloat(json.lat), lng: parseFloat(json.lng) } })
            }
            return true
          }
          )
          console.log(this.markersRed)
          console.log(this.markersYellow)
        })
        .catch(error => console.log('Error', error.message))
    }
  },
  mounted () {
    this.listarMarcadores()
  },
  data () {
    return {
      myJson: [],
      center: {
        lat: 6.247785784,
        lng: -75.5702257
      },
      zoom: 13,
      markersRed: [],
      markersYellow: [],
      model: '2021',
      options: [
        '2017',
        '2018',
        '2019',
        '2020',
        '2021',
        '2022',
        '2023',
        '2024'
      ]
    }
  }
}
</script>
