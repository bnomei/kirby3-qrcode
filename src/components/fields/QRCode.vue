<template>
  <figure class="qrcode-wrapper">
    <div v-html="url"></div>
    <figcaption v-if="title" data-theme="help" class="k-text">{{ title }}</figcaption>
  </figure>
</template>

<script>
export default {
  name: 'QRCode',
  props: {
    url: String,
    title: String,
  }
}
</script>

<style lang="scss">
.qrcode-wrapper {
  display: grid;
  grid-gap: 0.5rem;
  justify-content: start;
  > div {
    line-height: 0;
    border: 1px solid #cccccc;
  }
  .figure-caption {
      text-align: center;
  }
}
</style>
