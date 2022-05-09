<template>
  <input type="hidden" :name="name" :value="value" />
</template>

<script>
  export default {
    mixins: [Fieldtype],
    inject: ['storeName'],

    mounted() {
      const handle = this.meta.blueprintHandle || this.$store.state.publish[this.storeName].blueprint.handle;

      this.update(handle);
    }
  };
</script>
