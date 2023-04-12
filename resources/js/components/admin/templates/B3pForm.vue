<template>
  <div id="content">
    <transition v-if="errors.length">
      <div class="alert alert-danger">
        <b3p-emoji emoji="exclamation-circle" />
        <button type="button" class="close" data-dismiss="alert">
          &times;
        </button>
        <p v-for="(err, idx) in errors" :key="idx">{{ err }}</p>
        <slot name="form_errors"></slot>
      </div>
    </transition>
    <slot name="form_loading"></slot>
    <div class="page-header">
      <div class="container-fluid">
        <div class="pull-right">
          <slot name="button_action"></slot>
        </div>
        <slot name="breadcrum"></slot>
      </div>
    </div>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">
            <b3p-emoji :emoji="emoji" />{{ panelTitle }}
          </h3>
        </div>
        <div class="panel-body">
          <slot name="form_body"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
  props: {
    errors: {
      type: Array,
      default: [],
    },
    emoji: {
      type: String,
      default: 'plus',
    },
    panelTitle: {
      type: String,
      default: 'Thêm',
    },
  },
}
</script>
