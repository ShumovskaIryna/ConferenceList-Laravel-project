<script>
export default {
   props: {
       center: Object,
       position: Object,
   },
    watch: {
     'position': {
        handler:  function () {
        this.position.lat = parseFloat(this.position.lat);
        this.position.lng = parseFloat(this.position.lng);
        },
       deep: true,
     }
   },
};
</script>

<template>
    <GMapMap
        :center="center"
        :zoom="10"
        map-type-id="terrain"
        style="width: 300px; height: 300px"
    >
            <GMapMarker
                :key="index"
                :position="position"
                :clickable="true"
                :draggable="true"
                @click="center = position"
            />
    </GMapMap>
</template>
