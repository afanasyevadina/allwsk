<template>
  <div class="element" @mousedown="$emit('movestart', $event)" :style="{top: `${element.y}px`, left: `${element.x}px`}">
    <div class="nodes" :class="{selected: element.selected}">
      <div class="node" v-for="node in element.nodes" :key="node.id" :class="`node-${node.id} ${node.linkId || node.linking ? 'active' : ''}`" @mouseup="mouseup($event, node)">
        <span>{{ node.id }}</span>
      </div>
    </div>
    <button class="edit" @click="$emit('selectElement')">E</button>
    <button class="delete" @click="$emit('deleteElement')">X</button>
  </div>
</template>

<script>
export default {
  name: 'EditModeElement',
  props: ['element'],
  data() {
    return {
      dragging: false,
      startOffset: {x: 0, y: 0}
    }
  },
  methods: {
    mouseup: function (e, node) {
      if (node.linkId) return
      if (e.shiftKey)
        this.$emit('linking', node)
      else
        this.$emit('createLinkedElement', node)
    }
  },
  mounted() {
  }
}
</script>