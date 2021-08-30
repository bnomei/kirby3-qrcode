<template>
  <div class="qrcode-wrapper">
    <a :href="url" download v-html="image"></a>
  </div>
</template>

<script>
export default {
  name: 'QRCode',
  props: {
    image: String,
    url: String,
  }
}
</script>

<style lang="postcss">

</style>
