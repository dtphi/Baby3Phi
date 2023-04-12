<template>
  <li @click="_selectParentCategory()">
    <b3p-emoji v-if="isSelected" emoji="plus" />
    <a href="javascript:void(0);">{{ category.name }}</a>
  </li>
</template>

<script>
export default {
  name: 'TheDropdownCategory',
  props: {
    category: Object,
    selectDropdownCategoryItem: Function,
  },
  data() {
    return {
      isSelected: false,
    }
  },
  methods: {
    _selectParentCategory() {
      this.isSelected = true
      this.selectDropdownCategoryItem(this.category)
    },
  },
  setting: {
    paren_category_txt: 'Danh mục hiển thị',
  },
}
</script>
