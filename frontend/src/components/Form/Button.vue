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
      onClick: {
        type: Function,
        default: () => {}
      }
    },
    methods: {
      handleClick(event) {
        this.onClick(event);
        this.$emit('click', event);
      }
    }
  };
  </script>
  