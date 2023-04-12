<template>
  <div id="content">
    <slot name="page_header"></slot>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">
            <slot name="panel_title"></slot>
          </h3>
        </div>
        <div class="panel-body">
          <div>
            <div class="table-responsive">
              <slot name="content_list"></slot>
            </div>
            <b3p-pagination :is-resource="isResource" />
          </div>
        </div>
      </div>
      <slot></slot>
    </div>
  </div>
</template>

<script>
  export default {
  props: {
    isResource: {
      type: Boolean,
      default: false,
      imediate: true,
    },
  },
}
</script>
