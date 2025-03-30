<template>
  <button :class="customClass" @click="handleClick">
    {{ label }}
  </button>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      required: true
    },
    customClass: {
      type: String,
      default: ''
    },
  },
  methods: {
    handleClick(event) {
      this.$emit('click', event);
    }
  }
};
</script>