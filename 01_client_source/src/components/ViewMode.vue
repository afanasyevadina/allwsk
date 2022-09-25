<template>
  <div>
    <div class="view" v-if="activeElement">
      <div class="view-link" :class="`view-link-${node.id}`" v-for="node in activeElement.nodes" :key="node.id">
        <a href="#" v-if="node.linkId" @click.prevent="goTo(node)">
          {{ node.title }}
        </a>
      </div>
      <div class="view-element" :class="sliding">
        <h3>{{ activeElement.title }}</h3>
        <div v-html="activeElement.content"></div>
      </div>
    </div>
    <div class="breadcrumbs">
      <div v-for="element in breadbrumbs" :key="element.id">
        <a href="#" @click="activeElement = element">{{ element.title }}</a> /
      </div>
    </div>
    <button @click="$emit('editMode')">Edit mode</button>
  </div>
</template>

<script>
export default {
  name: 'ViewMode',
  props: ['elements', 'links'],
  data() {
    return {
      activeElement: null,
      sliding: null,
      breadbrumbs: []
    }
  },
  methods: {
    goTo: function (node) {
      let link = this.links.find(v => v.id === node.linkId)
      this.activeElement = this.activeElement.id === link.from.element.id ? this.elements.find(v => v.id === link.to.element.id) : this.elements.find(v => v.id === link.from.element.id)
      this.sliding = `sliding-${node.id}`
      if (this.breadbrumbs.length > 1 && this.breadbrumbs[this.breadbrumbs.length - 2].id === this.activeElement.id) {
        this.breadbrumbs.splice(this.breadbrumbs.length - 1, 1)
      } else {
        this.breadbrumbs.push(this.activeElement)
      }
    }
  },
  mounted() {
    if (this.elements.length) {
      this.activeElement = this.elements[0]
      this.breadbrumbs.push(this.activeElement)
    }
  }
}
</script>
<style scoped>
body {
  overflow: hidden;
}
button {
  position: fixed;
  top: 1rem;
  right: 1rem;
  padding: .5rem;
}
.breadcrumbs {
  position: fixed;
  top: 1rem;
  left: 1rem;
  padding: .5rem;
  display: flex;
}
.view {
  display: grid;
  height: 100vh;
  grid-template-columns: 100px 1fr 100px;
  grid-template-rows: 100px 1fr 100px;
  grid-template-areas:
". link1 ."
"link4 element link2"
". link3 ."
;
  padding: 1rem;
}
.view-element {
  grid-area: element;
  border: 1px solid #565656;
  padding: 1rem;
}
.view-link {
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}
.view-link-1 {
  grid-area: link1;
}
.view-link-2 {
  grid-area: link2;
}
.view-link-3 {
  grid-area: link3;
}
.view-link-4 {
  grid-area: link4;
}
h3 {
  margin-bottom: 1rem;
}
.view-element {
  transition: .5s;
}
@keyframes slide1 {
  0% {
    transform: translateY(-100%);
  }
  100% {
    transform: none;
  }
}
@keyframes slide2 {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: none;
  }
}
@keyframes slide3 {
  0% {
    transform: translateY(100%);
  }
  100% {
    transform: none;
  }
}
@keyframes slide4 {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: none;
  }
}
.sliding-1 {
  animation: slide1 .5s ease;
}
.sliding-2 {
  animation: slide2 .5s ease;
}
.sliding-3 {
  animation: slide3 .5s ease;
}
.sliding-4 {
  animation: slide4 .5s ease;
}
</style>