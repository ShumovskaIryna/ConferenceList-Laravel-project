<script>
export default {
    data() {
        return {
            center: Object,
            position: Object,
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
                :position="position"
                :clickable="true"
                :draggable="true"
                @click="center = position"
            />
    </GMapMap>
</template>
