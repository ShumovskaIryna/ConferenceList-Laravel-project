<script>
export default {
    data() {
        return {
            center: { lat: 51.093048, lng: 6.84212 },
            markers: [
                {
                    position: {
                        lat: 51.093048,
                        lng: 6.84212,
                    },
                },
            ],
        };
    },
};
</script>

<template>
    <GMapMap
        :center="center"
        :zoom="10"
        map-type-id="terrain"
        style="width: 400px; height: 300px"
    >
            <GMapMarker
                :key="index"
                v-for="(m, index) in markers"
                :position="m.position"
                :clickable="true"
                :draggable="true"
                @click="center = m.position"
            />
    </GMapMap>
</template>
